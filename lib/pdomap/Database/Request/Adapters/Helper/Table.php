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
     * Database Table structure
     */
    abstract class pdoMap_Database_Request_Adapters_Helper_Table 
        implements 
            pdoMap_Database_Request_Adapters_ITable 
    {        
        /**
         * The database key
         */                 
        protected $database;
        /**
         * Name of current table
         */                 
        protected $name;
        /**
         * Name of table adapter (by default the same as table name)
         */                 
        protected $adapter;
        /**
         * Primary key index in fields array
         */                 
        protected $primary;
        /**
         * Array of fields in current table
         */                 
        protected $fields = array();    
        /**
         * SQL Command to read a table structure
         * @params %1$s Unescaped database name
         * @params %2$s Unescaped table name
         * @params %3$s Escaped table and database name (with escape entity)
         */                 
        protected $sqlReadTable = 'SHOW FULL COLUMNS FROM \'%1$s\'.\'%2$s\'';
        /**
         * SQL Command to truncate an table
         * @params %1$s Table name
         */                 
        protected $sqlTruncateTable = 'TRUNCATE TABLE %1$s';
        /**
         * SQL Command to drop an table
         * @params %1$s Table name
         */                 
        protected $sqlDropTable = 'DROP TABLE %1$s';
        /**
         * SQL Command to change table structure
         * @params %1$s Table name
         * @params %2$s Alter command
         */                 
        protected $sqlAlterTable = 'ALTER TABLE %1$s %2$s';
        /**
         * SQL Command to drop a foreign key
         * @params %1$s Field name
         */                 
        protected $sqlDropFk = 'DROP FOREIGN KEY %1$s';
        /**
         * @params %1$s Foreign key index name
         * @params %2$s Field name
         * @params %3$s Foreign table name
         * @params %4$s Foreign primary key name
         */                 
        protected $sqlJoinFk = 'ADD CONSTRAINT %1$s FOREIGN KEY(%2$s) REFERENCES %3$s(%4$s) ON DELETE CASCADE';
        /**
         * SQL Command to create a new table
         * @params %1$s Table name
         * @params %2$s List of fields
         * @params %3$s List of indexes
         * @params %4$s Table options
         */                 
        protected $sqlCreateTable = 'CREATE TABLE %1$s (%2$s %3$s) %4$s';
        /**
         * SQL Syntax to define a field
         * @params %1$s Field name
         * @params %2$s Field type
         * @params %3$s Field size
         * @params %4$s Field options
         * @params %5$s Default value        
         * @params %6$s Bind field name
         * @params %7$s Comment
         */                 
        protected $sqlDefineField = '%1$s %2$s%3$s %4$s %5$s COMMENT \'*%6$s:%7$s\'';         

        /**
         * SQL Syntax to define an indexed field
         * @params %1$s Field name         
         */                 
        protected $sqlIndexField = 'INDEX(%1$s)';         

        /**
         * Initialize a new table structure from database or from code
         * @params string   Database key where the table is/will be located
         * @params string   Name of table
         * @params array    Structure of table to load (if not defined will 
         *                  initialize table structure from the existing 
         *                  database table)                          
         */                 
        public function __construct($database, $name, $data = null) {
            if (is_null($data)) {
                $sql = $this->Request(
                    sprintf(
                        $this->sqlReadTable,
                        $database,
                        $name,
                        $this->escapeTable(
                            $name, 
                            $database
                        )
                    ) 
                );
                while($row = pdoMap::database()->Fetch($sql)) {
                    $this->fields[] = new pdoMap_Database_Request_Adapters_MySQL_Field($row);
                    if ($row[4] == 'PRI') {
                        $this->primary = sizeof($this->fields) - 1;
                    }
                }
            } else {
                $this->fields = $data['fields'];
                $this->primary = $data['pk'];
                $this->adapter = $data['adapter'];
            }
            $this->database = $database;
            $this->name = $name;
        }
        /**
         * Must be implemented function : escape the table name
         */                 
        abstract function escapeTable($name, $database);
        /**
         * Must be implemented function : escape the entity name
         */  
        abstract function escapeEntity($name);
        /**
         * Must be implemented function : escape a value
         */  
        abstract function escapeValue($value);
        /**
         * Must be implemented function : convert a type to SQL syntax
         */   
        abstract function getTypeToSql($field);             
        /**
         * Must be implemented function : run the request manager
         */   
        abstract function Request($sql);             
        /**
         * Get the database key
         */                 
        public function getDatabase() { 
            return $this->database; 
        }
        /**
         * Get the table name
         */                 
        public function getName() { 
            return $this->name; 
        }
        /**
         * Get the primary key structure
         */                 
        public function getPrimaryKey() { 
            return $this->fields[$this->primary]; 
        }
        /**
         * Get the list of table fields
         */                 
        public function getFields() { 
            return $this->fields; 
        }
        /**
         * Get a list of foreign keys
         */                 
        public function getForeignKeys() { 
            return $this->fk; 
        }
        /**
         * Truncate current table
         */                 
        public function Truncate() {
            return $this->Request(
                sprintf(
                    $this->sqlTruncateTable,
                    $this->escapeTable(
                        $this->name, 
                        $this->database
                    )
                )
            );
        }
        /**
         * Drop current table
         */                 
        public function Drop() {
            // REMOVE TABLE REFERENCES
            if ($this->adapter) {
                foreach(pdoMap::Config()->getMapping()->getKeys() as $m) {
                    if ($m != $this->adapter) {
                        pdoMap::structure($m)->TableRequest()->DropFk(
                            $this->adapter
                        );
                    }
                }            
            }
            // RUN TABLE DROPPING
            return $this->Request(
                sprintf(
                    $this->sqlDropTable,
                    $this->escapeTable(
                        $this->name, 
                        $this->database
                    )
                )
            );        
        }
        /**
         * Delete on current table the foreign key linked to specified adapter
         */                 
        public function DropFk($adapter) {
            foreach($this->fields as $field) {
                if ($field->type == pdoMap_Dao_Metadata_Field::FIELD_TYPE_FK) {
                    if ($field->adapter == $adapter) {
                        try {
                            return $this->Request(
                                sprintf(
                                    $this->sqlAlterTable,
                                    $this->escapeTable(
                                        $this->name, 
                                        $this->database
                                    ),      // %1 (table name)
                                    sprintf(
                                        $this->sqlDropFk,
                                        $this->escapeEntity(
                                            $this->name.'_'.$field->name
                                        )   // %1 (entity name)
                                    )                                                                        
                                )
                            );
                        } catch(pdoMap_Database_Exceptions_BadRequest $ex) {
                            return false;
                        }
                    }
                }
            }            
            return false;     
        }     
        /**
         * Delete on current table all foreign keys
         */                  
        public function DropAllFk() {
            $drop = array();
            foreach($this->fields as $field) {
                if ($field->type == pdoMap_Dao_Metadata_Field::FIELD_TYPE_FK) {
                    $drop[] = sprintf(
                        $this->sqlDropFk,
                        $this->escapeEntity(
                            $this->name.'_'.$field->name
                        )   // %1 (entity name)
                    );               
                }
            }            
            if (sizeof($drop) == 0) return true; // have nothing to drop
            try {
                return $this->Request(
                    sprintf(
                        $this->sqlAlterTable,
                        $this->escapeTable(
                            $this->name, 
                            $this->database
                        ),      // %1 (table name)
                        implode(', ', $drop)                                                                       
                    )                    
                );
            } catch(pdoMap_Database_Exceptions_BadRequest $ex) {
                return false;
            }                                 
        }       
        /**
         * Add on current table all foreign keys
         */                    
        public function JoinAll() {
            $join = array();
            foreach($this->fields as $field) {
                if ($field->type == pdoMap_Dao_Metadata_Field::FIELD_TYPE_FK) {
                    $ref = pdoMap::structure($field->adapter);
                    if (!$ref) {
                        throw new Exception(
                            'Could not join '.$field->bind.
                            ' to an undefined table '.
                            $field->adapter
                        );
                    }
                    $join[] = sprintf(
                        $this->sqlJoinFk,
                        $this->escapeEntity($this->name.'_'.$field->name),
                        $this->escapeEntity($field->name),
                        $this->escapeTable($ref->name, $ref->db),
                        $this->escapeEntity($ref->getPk()->name)
                    );
                }
            }            
            if (sizeof($join) == 0) return true; // have nothing to join
            return $this->Request(
                sprintf(
                    $this->sqlAlterTable,
                    $this->escapeTable(
                        $this->name, 
                        $this->database
                    ),      // %1 (table name)
                    implode(', ', $join)    
                )
            );             
        }   
        /**
         * Get a list of table options
         */                 
        public function getTableOptions() {
            return '';
        }     
        /**
         * Generate the field definition
         */                 
        public function getFieldDefinition($field) {
            $data = $this->getTypeToSql($field);
            $data['size'] = (
                isset($data['size']) ?
                    '('.$data['size'].')': 
                    ''
                );
            if (isset($data['options'])) {
                if (
                    !in_array('NULL', $data['options']) &&
                    !in_array('NOT NULL', $data['options'])
                ) {
                    if ($field->isNull) {
                        $data['options'][] = 'NULL';
                    } else {
                        $data['options'][] = 'NOT NULL';                    
                    }   
                }
            } else {
                $data['options'] = array();
            }            
            return sprintf(         
                $this->sqlDefineField,
                $this->escapeEntity($field->name),      
                $data['type'],
                $data['size'],
                implode(' ', $data['options']),                
                $this->getDefaultValue($field),
                $field->bind,
                $field->comment
            );
        }
        /**
         * Get field options
         */                 
        public function getFieldOptions($field) {
            if (
                $field->isIndex 
                || $field->type == pdoMap_Dao_Metadata_Field::FIELD_TYPE_FK
            ) {
                return sprintf(
                    $this->sqlIndexField,
                    $this->escapeEntity($field->name)
                );
            } else return null;
        }
        /**
         * Get the default value of a field
         */                 
        public function getDefaultValue($field) {
            if ($field->default) {
                if (substr($field->default, 0, 1) == '*') {
                    return ' DEFAULT '.substr($field->default, 1);                    
                } else {
                    return ' DEFAULT '.$this->escapeValue($field->default);
                }
            } else return '';
        }
        /**
         * Create current table on database
         */                 
        public function Create() {   
            $options = array(); 
            $fields = array();                       
            foreach($this->fields as $field) {
                $fields[] = $this->getFieldDefinition($field);
                $option = $this->getFieldOptions($field);
                if ($option) $options[] = $option;                               
            }
            if (sizeof($options) > 0) $fields[] = "\n"; 
            return $this->Request(
                sprintf(
                    $this->sqlCreateTable,
                    $this->escapeTable(
                            $this->name, 
                            $this->database
                    ),
                    implode(', ', $fields),
                    implode(', ', $options),
                    $this->getTableOptions()
                )
            ); 
        }        
    }    