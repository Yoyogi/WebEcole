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
     * Database Table structure
     */
    class pdoMap_Database_Request_Adapters_MSSQL_Table 
        extends 
            pdoMap_Database_Request_Adapters_Helper_Table 
    {
        /**
         * MS Sql Table Manager Constructor
         */                 
        public function __construct($database, $name, $data = null) {
            $this->sqlReadTable = '
                SELECT * FROM information_schema.COLUMNS WHERE 
                        table_schema = \'%1$s\'
                        table_name = \'%2$s\'
                ORDER BY ordinal_position';
            parent::__construct($database, $name, $data);
        }               
        /**
         * Escape table syntax
         */                         
        public function escapeTable($name, $database) {
            return pdoMap_Database_Request_Adapters_MSSQL_Builder::escapeTable(
                $name, $database
            );        
        }
        /**
         * Escape entity syntax
         */                 
        public function escapeEntity($name) {
            return pdoMap_Database_Request_Adapters_MSSQL_Builder::escapeEntity(
                $name
            );        
        }   
        /**
         * Escape value syntax
         */                 
        public function escapeValue($value) {
            return pdoMap_Database_Request_Adapters_MSSQL_Builder::escapeValue(
                $value
            );        
        }  
        /**
         * Run the request manager for this table
         */                 
        public function Request($sql) {
            return pdoMap::database()->Request(
                $this->database, 
                $sql
            );        
        }
        /**
         * Convert the programmatic type to closer SQL type column
         */                    
        public function getTypeToSql($field) {    
            // @todo: must to implement            
        }                          
    }    