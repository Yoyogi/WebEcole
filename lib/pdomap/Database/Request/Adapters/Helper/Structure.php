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
     * @subpackage     Database::Adapters::Helper
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /** 
     * Database Structure Manager
     */
    abstract class pdoMap_Database_Request_Adapters_Helper_Structure 
        implements 
            pdoMap_Database_Request_Adapters_IStructure 
    {
        protected $database;
        protected $tables;
        protected $sqlShowTables = 'SHOW TABLES';
        protected $sqlDropDatabase = 'DROP DATABASE IF EXISTS %s';
        protected $sqlCreateSchema = 'CREATE SCHEMA IF NOT EXISTS %s  DEFAULT CHARACTER SET %s COLLATE %s';
        public $character_set = 'utf8';
        public $collate = 'utf8_swedish_ci';
        public function __construct($database) {
            $this->database = $database;
            $this->tables = array();
        }
        abstract function CreateTableManager($db, $table, $structure = null);
        abstract function CreateFieldManager($field);
        abstract function EscapeEntity($entity);
        public function All() {
            $ret = array();
            $sql = pdoMap::database()->Request(
                $this->database, $this->sqlShowTables
            );
            while($name = pdoMap::database()->Fetch($sql)) $ret[] = $name[0];
            return $ret;
        }
        public function Get(pdoMap_Dao_Metadata_Table $table) {
            $structure = array(
                'pk' => 0, 
                'fields' => array(),
                'adapter' => $table->getType()    
            );
            foreach($table->getPhysicalFields() as $field) {
                if ($field->type == pdoMap_Dao_Metadata_Field::FIELD_TYPE_PK) {
                    $structure['pk'] = sizeof($structure['fields']);
                }    
                $structure['fields'][] = $this->CreateFieldManager($field);            
            }
            return $this->CreateTableManager(
                $this->database, 
                $table->name, 
                $structure
            );
        }
        public function Read($table) {
            if (!isset($this->tables[$table]) || !is_null($structure)) {
                $this->tables[$table] = $this->CreateTableManager(
                    $this->database, $table
                );
            }
            return $this->tables[$table];
        }        
        public function Drop() {
            $name = pdoMap::database()->getName($this->database);
            pdoMap::database()->Change('');        
            return pdoMap::database()->request(
                $this->database, 
                sprintf(
                    $this->sqlDropDatabase,
                    $this->escapeEntity($name)
                )
            );                            
        }
        public function Create($drop = false) {
            $name = pdoMap::database()->getName($this->database);
            if ($drop) $this->Drop();
            pdoMap::database()->Change('');        
            pdoMap::database()->Request(
                $this->database, 
                sprintf(
                    $this->sqlCreateSchema,
                    $this->escapeEntity($name),
                    $this->character_set,
                    $this->collate
                )
            );        
            pdoMap::database()->Change($name);        
        }
    }