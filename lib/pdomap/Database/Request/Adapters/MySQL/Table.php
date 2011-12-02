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
     * @subpackage     Database::Adapters::MySQL
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /** 
     * Database Table structure
     */
    class pdoMap_Database_Request_Adapters_MySQL_Table 
        extends 
            pdoMap_Database_Request_Adapters_Helper_Table 
    {
        /**
         * Escape table syntax
         */                         
        public function escapeTable($name, $database) {
            return pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                $name, $database
            );        
        }
        /**
         * Escape entity syntax
         */                 
        public function escapeEntity($name) {
            return pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity(
                $name
            );        
        }   
        /**
         * Escape value syntax
         */                 
        public function escapeValue($value) {
            return pdoMap_Database_Request_Adapters_MySQL_Builder::escapeValue(
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
         * Defines that table is on innodb engine (for foreign keys)
         */                          
        public function getTableOptions() {
            return 'ENGINE = INNODB';
        }      
        /**
         * Convert the programmatic type to closer SQL type column
         */                    
        public function getTypeToSql($field) {    
            switch($field->type) {
                case pdoMap_Dao_Metadata_Field::FIELD_TYPE_PK:
                    $field->isNull = false;
                    $ret = array(
                        'type' => 'INT',
                        'size' => 10,
                        'options' => array(
                            'UNSIGNED', 
                            'NOT NULL',
                            'AUTO_INCREMENT', 
                            'PRIMARY KEY'
                        )
                    );
                    break;
                case pdoMap_Dao_Metadata_Field::FIELD_TYPE_FK:
                    $ret = array(
                        'type' => 'INT',
                        'size' => 10,
                        'options' => array(
                            'UNSIGNED'
                        )
                    );
                    break;
                case pdoMap_Dao_Metadata_Field::FIELD_TYPE_TEXT:
                    if (isset($field->size)) {
                        $ret = array(
                          'type' => 'VARCHAR',
                          'size' => $field->size
                        );
                    } else {
                        $ret = array(
                          'type' => 'TEXT'
                        );
                    }
                    break;
                case pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT:
                    switch($field->size) {
                        case 'tiny':
                            $ret = array('type' => 'TINYINT');
                            break;
                        case 'small':
                            $ret = array('type' => 'SMALLINT');
                            break;
                        case 'medium':
                            $ret = array('type' => 'MEDIUMINT');
                            break;
                        case 'big':
                            $ret = array('type' => 'BIGINT');
                            break;
                        default:
                            $ret = array('type' => 'INT', 'size' => 10);
                    }
                    break;
                case pdoMap_Dao_Metadata_Field::FIELD_TYPE_FLOAT:
                    $ret = array('type' => 'FLOAT');
                    break;                        
                case pdoMap_Dao_Metadata_Field::FIELD_TYPE_ENUM:
                    $def = '';
                    foreach($field->values as $val) {
                        $def .= $this->escapeValue($val).', ';
                    }
                    $ret = array(
                        'type' => 'ENUM',
                        'size' => substr($def, 0, strlen($def) - 2)
                    );                    
                    break;
                case pdoMap_Dao_Metadata_Field::FIELD_TYPE_DATE:
                    $ret = array(
                        'type' => 'TIMESTAMP'
                    );
                    break;
                default:
                    throw new Exception(
                        'Unknown field type '
                        .$field->type.' for '
                        .$field->name.' on table '
                        .$this->name
                    );
                    break;
            }
            if (!isset($ret['options'])) {
                $ret['options'] = array();
            }
            if ($field->IsNull()) {
                $ret['options'][] = 'NULL';
            } else {
                $ret['options'][] = 'NOT NULL';                
            }
            return $ret;
        }    
    }    