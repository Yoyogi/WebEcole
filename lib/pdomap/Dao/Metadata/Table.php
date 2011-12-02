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
     * @subpackage     Dao
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /**
     * Describes a table definition
     */         
    class pdoMap_Dao_Metadata_Table {
        /**
         * @var string Get database connection key
         */         
        public $db;
        /**
         * @var string Bind name for table
         */         
        public $type;
        /**
         * @var string Physical table name
         */
        public $name;
        /**
         * @var string Entity class name
         */
        public $entity;
        /**
         * @var string Adapter service class name
         */
        public $service;
        /**
         * @var string Adapter class name
         */
        public $adapter;
        /**
         * @var array List of fields in table
         */
        public $fields = array();
        /**
         * primary key field
         */         
        private $pk;
        /**
         * Constructor
         */         
        public function __construct(
            $type, $name, $entity, 
            $service = null, $class = null, $db = '*'
        ) {
            if (!$service && !$class) {
                /**
                 * @todo : cast exception
                 */                                 
                throw new Exception('you must define a class or a service');          
            } 
            $this->name = $name;
            $this->type = $type;
            $this->entity = $entity;
            $this->adapter = $class;
            $this->service = $service;
            $this->db = $db;
        }
        /**
         * Get the structure type
         */                 
        public function getType() {
            return $this->type;
        }
        /**
         * Deserialize from php code
         */                 
        public function __set_state($conf) {
            $ret = new pdoMap_Dao_Metadata_Table(
                $conf['type'], 
                $conf['name'], 
                $conf['entity'], 
                $conf['service'],
                $conf['db']
            );
            $ret->fields = $conf['fields'];
            $ret->pk = $conf['pk'];
            return $ret;
        }
        /**
         * Get the primary key
         */         
        public function getPk() {
            if (!$this->pk) {
                foreach($this->fields as $bind => $field) {
                    if ($field->type == 'Primary') {
                        $this->pk = $bind;
                        break;
                    }
                }
                if (!$this->pk) 
                    throw new pdoMap_Dao_Exceptions_PrimaryKeyUndefined(
                        $this
                    );
            }
            return $this->fields[$this->pk];
        }
        /**
         * Get the class for the adapter
         */                 
        public function ResolveClassName() {
            if ($this->adapter) {
                return $this->adapter;
            } else {
                $classes = get_declared_classes();
                foreach($classes as $namespace) {
                    $reflexion = new ReflectionClass($namespace);
                    if (!$reflexion->isAbstract() && 
                            !$reflexion->isInterface() && 
                            $reflexion->implementsInterface($this->service)) {
                        return $namespace;
                    }
                }
            }
        }
        /**
         * Get a field structure from his bind key
         * @params string Key name (bind)         
         * @throws pdoMap_Dao_Metadata_Exceptions_UndefinedField         
         */                 
        public function getField($bind) {
            if (isset($this->fields[$bind])) {
                return $this->fields[$bind];            
            } else {
                throw new pdoMap_Dao_Metadata_Exceptions_UndefinedField(
                    $bind, $this
                );
            }
        }
        /**
         * Get the list of fields
         */                 
        public function getFields() {
            return $this->fields;
        }
        /**
         * Get the physical list of fields
         */                 
        public function getPhysicalFields() {
            $ret = array();
            foreach($this->fields as $field) {
                try {
                    foreach(pdoMap::field()->getMeta($field) as $meta) {
                        $ret[] = $meta;        
                    }                                
                } catch(Exception $ex) {
                    throw new Exception(
                        'Bad field exception on '
                        .$this->type
                        ."\n"
                        .$ex->getMessage()
                        ."\n"
                        .print_r($field, true)
                    );
                }
            }
            return $ret;
        }
        /**
         * Get the Table Request Manager
         */                 
        public function TableRequest() {
            return pdoMap::request()->structure($this->db)->get($this);
        }
        /** 
         * Get the request manager
         */         
        public function Request() {
            return pdoMap::request()->get($this->type);
        }
        /**
         * Get the service manager
         */                 
        public function Adapter() {
            return pdoMap::get($this->type);
        }
        /**
         * Create table
         */                 
        public function Create() {
            $this->TableRequest()->Create();                    
            pdoMap::cache()->clear();
        }
        /**
         * Join table foreign keys
         */                 
        public function Join() {
            $this->TableRequest()->JoinAll();        
        }
        /**
         * Drop Table
         */                 
        public function Drop() {
            $this->TableRequest()->Drop();
            pdoMap::cache()->clear();
        }
        /**
         * Truncate table
         */                 
        public function Truncate() {
            $this->TableRequest()->Truncate();            
            pdoMap::cache()->clear();
        }
        /**
         * Synchronise structure
         */                 
        public function Synchronise() {
            // @todo
        }
        /**
         * Create an auto generated entity
         */                 
        public function Populate($count) {
            mt_srand();  
            $ret = array();
            $class = $this->entity;
            $fields = $this->fields;
            unset($fields[$this->getPk()->bind]);
            for($i = 0; $i < $count; $i++) {
                $values = array();
                foreach($fields as $bind => $meta) {
                    $value = null;
                    switch($meta->type) {
                        case pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT:
                            switch($meta->getOption('size', 'int')) {
                                case 'tiny':
                                    $max = 255;
                                    break;
                                case 'small':
                                    $max = 65535;
                                    break;
                                case 'medium':
                                    $max = 16777215;
                                    break;
                                case 'big':
                                    $max = mt_getrandmax(); // biggest value : 18446744073709551615;
                                    break;
                                default:
                                    $max = 4294967295;
                            }
                            if ($meta->GetOption('unsigned') == 'true') {
                                $min = -$max - 1;
                                $max = ($max - 1) / 2;
                            } else {
                                $min = 0;
                            }
                            $value = mt_rand($min, $max);
                            break;
                        case pdoMap_Dao_Metadata_Field::FIELD_TYPE_FLOAT:
                            $precision = $meta->GetOption('precision', 3);
                            $scale = $meta->GetOption('scale', 2);
                            $entier = pow(10, $precision);
                            $virgule = pow(10, $scale);
                            $value = mt_rand(-$entier, $entier) + (mt_rand(0, $virgule) / $virgule);
                            break;
                        case pdoMap_Dao_Metadata_Field::FIELD_TYPE_TEXT:
                            $size = $meta->GetOption('size', 2048);
                            $length = mt_rand($size / 2, $size);
                            $value = '';
                            for($c = 0; $c < $size; $c ++) {
                                $type = mt_rand(0, 3);
                                switch($type) {
                                    case 0:
                                        $value .= ' ';
                                        break;
                                    case 1:
                                        $value .= chr(mt_rand(43, 64));
                                        break;
                                    case 2:
                                        $value .= chr(mt_rand(65, 90));                                        
                                        break;
                                    case 3:
                                        $value .= chr(mt_rand(97, 122));                                        
                                        break;
                                }
                            }
                            break;
                        case pdoMap_Dao_Metadata_Field::FIELD_TYPE_DATE:
                            $value = date('Y-m-d H:i:s', mt_rand(0, time()));
                            break;
                    }
                    $values[$bind] = $value;
                }
                $entity = $this->Adapter()->Create($values);
                $this->Adapter()->Insert($entity);
                $ret[] = $entity;
            }
            return $ret;
        }        
    }