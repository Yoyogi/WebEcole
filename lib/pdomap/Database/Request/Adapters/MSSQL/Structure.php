<?php

    /*
     *  $Id$
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
     * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
     * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
     * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
     * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
     * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
     * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
     * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
     * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
     * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
     * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     *
     * This software consists of voluntary contributions made by many individuals
     * and is licensed under the LGPL. For more information, see
     * <http://www.pdomap.net>.
     */    
    
    /**
     * @author         Ioan CHIRIAC <i dot chiriac at yahoo dot com>
     * @license        http://www.opensource.org/licenses/lgpl-2.1.php LGPL
     * @package        pdoMap
     * @subpackage     Database::Adapters::MSSQL
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /** 
     * Database Structure Manager
     */
    class pdoMap_Database_Request_Adapters_MSSQL_Structure
        extends 
            pdoMap_Database_Request_Adapters_Helper_Structure 
        implements 
            pdoMap_Database_Request_Adapters_IStructure 
    {    
        public $dbPath          = 'C:\\Program Files\\Microsoft SQL Server\\MSSQL.1\\MSSQL\\DATA\\';
        public $dbStartSize     = '3072KB';
        public $dbMaxSize       = 'UNLIMITED';
        public $dbFileGrowth    = '1024KB';
        public $logStartSize    = '1024KB';
        public $logMaxSize      = '2048GB';
        public $logFileGrowth   = '10%';
        
        public function __construct($database) {
            parent::__construct($database);
            $this->sqlDropDatabase = '
                IF  EXISTS (SELECT name FROM sys.databases WHERE name = N\'%1$s\')
                DROP DATABASE %2$s     
            ';  
            $this->sqlCreateSchema = '
              CREATE DATABASE %1$s ON  PRIMARY 
              ( NAME = N\'%2$s\', FILENAME = N\'%3$s%2$s.mdf\' , SIZE = %4$s , MAXSIZE = %5$s, FILEGROWTH = %6$s )
               LOG ON 
              ( NAME = N\'%2$s_log\', FILENAME = N\'%3$s%2$s_log.ldf\' , SIZE = %7$s , MAXSIZE = %8$s , FILEGROWTH = %9$s)
            ';    
        }
        public function CreateTableManager($db, $table, $structure = null) {
            return new pdoMap_Database_Request_Adapters_MSSQL_Table(
                $db, $table, $structure
            );
        }
        public function CreateFieldManager($field) {
            return new pdoMap_Database_Request_Adapters_MSSQL_Field(
                $field
            );
        }
        public function Drop() {
            $name = pdoMap::database()->getName($this->database);
            return pdoMap::database()->request(
                'master', 
                sprintf(
                    $this->sqlDropDatabase,
                    $name, $this->EscapeEntity($name)
                )
            );                            
        }  
        public function Create($drop = false) {
            if ($drop) $this->Drop();
            pdoMap::database()->Request(
                'master', 
                sprintf(
                    $this->sqlCreateSchema,
                    $this->EscapeEntity($name),     // %1
                    $name,                          // %2
                    $this->dbPath,                  // %3
                    $this->dbStartSize,             // %4
                    $this->dbMaxSize,               // %5
                    $this->dbFileGrowth,            // %6
                    $this->logStartSize,            // %7
                    $this->logMaxSize,              // %8
                    $this->logFileGrowth            // %9
                )
            );        
        }              
        public function EscapeEntity($entity) {
            return pdoMap_Database_Request_Adapters_MSSQL_Builder::escapeEntity(
                $entity
            );
        }
    }