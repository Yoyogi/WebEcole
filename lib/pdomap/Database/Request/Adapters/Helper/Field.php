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
     * Field Definition
     */
    class pdoMap_Database_Request_Adapters_Helper_Field 
        implements pdoMap_Database_Request_Adapters_IField 
    {
        public $name;
        public $type;
        public $size;
        public $bind;
        public $comment;
        public $default;
        public $isNull;
        public $isIndex;
        public $adapter;
        public $values;
        public function __construct($row = null) {
            if ($row instanceof pdoMap_Dao_Metadata_Field) {
                $this->name = $row->name;
                $this->bind = $row->bind;
                $this->type = $row->type;
                $this->values = $row->getOption('value', array());
                $this->size = $row->getOption('size');
                $this->isNull = $row->IsNull();
                $this->default = $row->DefaultValue();
                $this->adapter = $row->getOption('adapter');
            } elseif (is_array($row)) {
                $this->name = $row[0];
                $t = explode('(', $row[1], 2);
                if (isset($t[1])) {
                    $this->size = substr($t[1], 0, strlen($t[1]) - 1);
                }
                $this->isNull = ($row[3] == 'YES');
                $this->default = $row[5];
                if (substr($row[8], 0, 1) == '*') {
                    $b = explode(':', substr($row[8], 1), 2);
                    $this->bind = $b[0];
                    if (isset($b[1])) $this->comment = $b[1];
                } else {
                    $this->comment = $row[8];
                    $b = explode('_', $this->name);
                    $this->bind = $b[sizeof($b) - 1];
                }
                $this->isIndex = ($row[4] != '');
                if ($row[4] == 'PRI') {
                    $this->type = $this->parseFieldType($row[4]);
                } else {
                    $this->type = $this->parseFieldType($t[0]);
                }                        
            }
        }
        public function parseFieldType($type) {
            switch(strtolower($type)) {
                case 'pri':
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_PK;
                    break;
                case 'varchar':
                    if (!$this->size) $this->size = 255;
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_TEXT;            
                    break;
                case 'text':
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_TEXT;            
                    break;
                case 'date':
                case 'datetime':
                case 'timestamp':
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_DATE;            
                    break;
                case 'int':
                    $this->size = 'normal';        
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT;    
                    break;
                case 'tinyint':
                    $this->size = 'tiny';        
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT;    
                    break;
                case 'smallint':
                    $this->size = 'small';        
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT;    
                    break;
                case 'mediumint':
                    $this->size = 'medium';        
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT;    
                    break;
                case 'bigint':
                    $this->size = 'big';        
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT;    
                    break;
                case 'float':
                case 'decimal':
                case 'real':
                    return pdoMap_Dao_Metadata_Field::FIELD_TYPE_FLOAT;    
                    break;
                default:
                    return $type;            
            }                 
        }
        public function getName() { return $this->name; }
        public function getBind() { return $this->bind; }
        public function getSize() { return $this->size; }
        public function getType() { return $this->type; }
        public function isNull() { return $this->isNull; }
        public function isIndex() { return $this->isIndex; }
        public function getDefault() { return $this->default; }
        public function getComment() { return $this->comment; }    
    }    