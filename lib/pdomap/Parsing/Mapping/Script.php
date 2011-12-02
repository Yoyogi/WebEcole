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
     * @subpackage     Parsing::Mapping
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /**
     * Represents a generic pdoMap script structure
     */         
    abstract class pdoMap_Parsing_Mapping_Script 
        extends 
            pdoMap_Parsing_Mapping_Node
    {        
        protected $onAdapter;
        protected $rqManager;
        protected $adapterLink;
        protected $isExternal;    
        /**
         * Parse an entity name
         */                 
        public function parseEntity($syntax) {
            if (substr($syntax, 0, 1) == '{') {
                return 
                    '$'
                    .str_replace(
                        '.', '->', 
                        substr($syntax, 1, strlen($syntax) - 2)
                    );
            } else {
                return '$'.$syntax;
            } 
        } 
        /**
         *  Get the list of entity properties
         */                 
        public function getProperties() {
            return $this->getRoot()->getCurrentAdapter()->entity->properties;
        }
        /**
         * Get the primary key
         */                 
        public function getPk() {
            if (isset($this->getProperties()->primary)) {
                return $this->getProperties()->primary->name;
            } else
                throw new Exception(
                    'Unable to find a primary key on '.$this->getType()
                );
        }
        /**
         * Read value from field and interpret him
         */                 
        public function getFieldValue($value) {
            if (is_numeric($value)) return $value;
            if (substr($value, 0, 1) == '*') return substr($value, 1);
            $len = strlen($value);
            $ret = '';
            $isChar = false;
            $isPhp = false;
            $isGlob = false;
            for($i = 0; $i < $len; $i ++) {
                $char = substr($value, $i, 1);
                if ($char == '{') {
                    if ($isPhp) 
                        throw new Exception(
                            'Could not open bracket, already one opened'
                        );
                    $isPhp = true;
                    if ($isChar) {
                        $ret .= '\'.';
                        $isChar = false;
                    }
                    $ret .= '$';
                    continue;
                }
                if ($char == '}' && $isPhp) {
                    $isPhp = false;
                    continue;
                }
                if ($isPhp) {
                    if ($char == '.') {
                        $ret .= '->';
                    } else {
                        $ret .= $char;
                    }
                } else {
                    if (!$isChar) {
                        $isChar = true;
                        if ($i > 0) $ret .= '.';
                        $ret .= '\'';
                    }
                    if ($char == '\'') $ret .= '\\';
                    $ret .= $char;
                }
            }
            if ($isChar) $ret .= '\'';
            return $ret;
        }        
        /**
         * Write current function signature
         */                 
        public function writeSignature($interface = false, $prefix = '') {            
            $this->ValidateFunctionName($this->name);            
            if ($interface) {
                $this->writeLine(
                    'function '.$this->name.'('.$prefix.$this->getParams().');'
                );
            } else {
                $this->writeLine(
                    'public function '.$prefix.$this->name.'('.$this->getParams().') {'
                );
            }
        }
        /**
         * Get the parameters list
         */                 
        public function getParams($default = true) {
            $ret = '';
            if (isset($this->params)) {
                foreach($this->params->param as $p) {
                    if (!isset($p->name)) {
                        throw new Exception('Expected param name tag');
                    }
                    $ret .= '$'.$p->name;
                    if ($default && isset($p->default)) {
                        $ret .= ' = \''.addslashes($p->default).'\'';
                    }
                    $ret .= ', ';
                }
                $ret = rtrim($ret, ', ');
            }
            return $ret;
        }        
        /**
         * Write the limit tag (if set)
         */                 
        public function getLimit($limit) {
            if (isset($limit->start))
                $start = $this->getFieldValue($limit->start);
            if (isset($limit->length)) 
                $len = $this->getFieldValue($limit->length);
            if (!isset($start)) $start = 0;
            if (isset($len)) {
                $this->writeLine('->Limit('.$start.', '.$len.')');                        
            } else {
                $this->writeLine('->Limit('.$start.')');                        
            }
        }    
        /**
         * Build a where tag
         */                 
        public function getWhere($where) {
            if (!isset($where->cond)) return;
            if ($where->operator) {
                $this->writeLine('->Where(\''.$where->operator.'\')');                        
            } else {
                $this->writeLine('->Where()');                        
            }
            $this->__root->tab += 1;
            foreach($where->cond as $c) {
                $this->getCondPhp($c);
            }        
            $this->__root->tab -= 1;
        }
        /**
         * Build order tags
         */             
        public function getOrders($orders) {
            foreach($orders as $order) {
                if ($order->field) {
                    $this->getOrder($order->field, $order->direction);                    
                } elseif($order->by) {
                    $this->getOrder($order->by, $order->direction);                                    
                }
            }
        }    
        public function getOrder($field, $direction = null) {
            if ($direction) {
                $this->writeLine(
                    '->OrderBy('
                    .$this->getFieldValue($field)
                    .', '
                    .$this->getFieldValue($direction)
                    .')'
                );                    
            } else {
                $this->writeLine(
                    '->OrderBy('
                    .$this->getFieldValue($field)
                    .')'
                );
            }     
        }
        /**
         * Build join tags
         */                 
        public function getJoin($joins) {
            foreach($joins as $join) {
                if (!$join->adapter) {
                    throw new Exception(
                        'Expecting to define the adapter on join !'
                    );
                }
                if (!$join->on) {
                    $on = $this->getType();
                } else $on = $join->on;
                $field = null;
                if (!$join->field) {
                    $fields = pdoMap::structure($join->adapter)->getFields();
                    foreach($fields as $f) {
                        if ($f->getOption('adapter') == $on) {
                            $field = $f->name;
                            break;
                        }
                    }
                    if (!$field) {
                        throw new Exception(
                            'Join error : unable to find a foreign key for '
                            .$on.' on adapter '.$join->adapter
                        );
                    }
                } else $field = $join->field;
                if ($join->adapter != $this->getType()) {
                    $pk = pdoMap::structure($join->adapter)->getPk()->bind;              
                } else {
                    $pk = $this->getPk();
                }
                $this->writeLine(
                    '->Join(\''
                    .$on.'\', \''
                    .$field.'\', \''
                    .$join->adapter.'\', \''
                    .$pk.'\')');
            }
        }
        /**
         * Build a set array list
         */                 
        public function getSet($sets) {
            foreach($sets as $set) {
                if (isset($set->value)) {
                    $value = $this->getFieldValue($set->value);
                } else $value = null;
                if (isset($set->literal)) 
                    $value = self::getLiteral($set->literal, $value);
                if (isset($set->function)) 
                    $value = $this->getFunction($set->function, $value);
                if ($this->isEntityRequest()) {
                    $this->writeLine(
                        $this->rqManager
                        .'->__set(\''.$set->property.'\', '.$value.');'
                    ); 
                } else {
                    $this->writeLine(
                        '->Set(\''.$set->property.'\', '.$value.')'
                    );            
                }                    
            }
        }
        /**
         * Build a function value
         */                 
        public function getFunction($name, $value) {
            switch($name) {
                case 'now':
                    return 'date(\'Y-m-d H:i:s\')';
                    break;
                default:
                    return $name.'('.$value.')';        
            }
        }
        
        /**
         * Build a literal expression
         */                 
        public static function getLiteral($expr, $value) {
            $expr = str_replace('{', '$', $expr);
            $expr = str_replace('}', '', $expr);
            $expr = str_replace('.', '->', $expr);
            return $expr;
        }
        /**
         * Read conditional data
         */                 
        public function getCondPhp($c) {
            if (isset($c->operator)) {
                if (isset($c->cond)) {
                    $this->writeLine('->OpenSub(\''.$c->join.'\')');
                    $this->__root->tab += 1;
                    foreach($c->cond as $subC) $this->getCondPhp($subC);
                    $this->__root->tab -= 1;
                    $this->writeLine('->CloseSub()');
                }
            } else {
                $cond = $this->readCondition($c);
                $op = $cond[0];
                $val = $cond[1];
                if (!$val) 
                    throw new Exception(
                        'You must define an operator for field '.$c->property
                    );
                if (isset($c->adapter)) {
                    $table = ', \''.$c->adapter.'\'';
                } else $table = '';
                $this->writeLine(
                    '->Cond(\''.$c->property.'\', \''.$op.'\', '.$val.$table.')'
                );
            }
        }    
        /**
         * Read Condition
         */              
        public function readCondition($c) {
            $op = null; $val = null;
            if (isset($c->not)) {
                $op = '<>';
                $val = $this->getFieldValue($c->not);
            }
            if (isset($c->equals)) {
                $op = '=';
                $val = $this->getFieldValue($c->equals);
            }
            if (isset($c->equal)) {
                $op = '=';
                $val = $this->getFieldValue($c->equal);
            }
            if (isset($c->is)) {
                $op = 'IS';
                $val = $this->getFieldValue($c->is);
            }
            if (isset($c->isnot)) {
                $op = 'IS NOT';
                $val = $this->getFieldValue($c->isnot);
            }            
            if (isset($c->like)) {
                $op = 'LIKE';
                $val = $this->getFieldValue($c->like);
            }
            if (isset($c->superior)) {
                $op = '>';
                $val = $this->getFieldValue($c->superior);
            }
            if (isset($c->inferior)) {
                $op = '<';
                $val = $this->getFieldValue($c->inferior);
            }
            if ($c->function) $val = $this->getFunction($c->function, $val);
            return array($op, $val);
        } 
        
        /**
         * Try to validate a function name
         */                 
        public function ValidateFunctionName($name) {
            if (
                in_array(
                    strtolower($name),
                    $this->getRoot()->unauthFuncNames
                )
            ) {
                throw new pdoMap_Parsing_Mapping_Exceptions_BadFunction(
                    $name, $this->getRoot()->getFileName()
                );
            }
            $first = substr($name, 0, 1);
            if (is_numeric($first)) {
                throw new pdoMap_Parsing_Mapping_Exceptions_BadFunction(
                    $name, $this->getRoot()->getFileName()
                );            
            }
            if (in_array(
                    $first,
                    array(
                        '_', '.', ' ', '-', '*', 
                        '(', '&', ';', ',', '@', 
                        '=', '+'
                    )
                )
            ) {
                throw new pdoMap_Parsing_Mapping_Exceptions_BadFunction(
                    $name, $this->getRoot()->getFileName()
                );                        
            }
            return true;
        }
              
        /**
         * Build node as a request
         */                 
        public function buildRequest() {
            // HANDLE TYPES
            switch($this->type) {
                case 'select':    // SELECT SERIALIZER
                    $this->handleSelect(false);
                    break;
                case 'select-one':
                    $this->handleSelect(true);
                    break;
                case 'insert':    // INSERT SERIALIZER
                    $this->handleInsert();
                    break;
                case 'update':    // UPDATE SERIALIZER
                    $this->handleUpdate();
                    break;
                case 'delete':    // DELETE SERIALIZER
                    $this->handleDelete();
                    break;
                default:
                    throw new Exception(
                        'Undefined request type '
                        .$this->type
                        .' for request '
                        .$this->name
                    );
            }
        }
        /**
         * Handle select
         */                 
        public function handleSelect($one) {
            $this->writeLine('->Select()');
            if (isset($this->join)) $this->getJoin($this->join);
            if (isset($this->where)) $this->getWhere($this->where);
            if (isset($this->order)) $this->getOrders($this->order);
            if ($one) {
                $this->writeLine('->Limit(0, 1)');
            } else {
                if (isset($this->limit)) $this->getLimit($this->limit);
            }
        }
        public function handleInsert() {
            if (!$this->isEntityRequest()) {
                $this->writeLine('->Insert()');        
            } elseif ($this->adapter != $this->__root->mappingKey) {
                $this->writeLine(
                    $this->rqManager
                    .' = '
                    .$this->adapterLink
                    .'->Create();'
                );                        
            }
            if (isset($this->set)) $this->getSet($this->set);
            if ($this->isEntityRequest()) {
                $this->handleEntityRequest($this->rqManager.'->Insert();');        
            }
        }
        public function handleUpdate() {
            if (!$this->isEntityRequest()) {
                $this->writeLine('->Update()');
                if (isset($this->where)) $this->getWhere($this->where);
                if (isset($this->limit)) $this->getLimit($this->limit);                    
            }
            if (isset($this->set)) $this->getSet($this->set);
            if ($this->isEntityRequest()) {
                $this->handleEntityRequest($this->rqManager.'->Update();');        
            }            
        }
        public function handleDelete() {
            if (!$this->isEntityRequest()) {
                $this->writeLine('->Delete()');
                if (isset($this->where)) $this->getWhere($this->where);
                if (isset($this->limit)) $this->getLimit($this->limit);                            
            } else {
                $this->handleEntityRequest($this->rqManager.'->Delete();');
            }
        }
        /**
         * Execute the entity request
         */                 
        public function handleEntityRequest($code) {
            $this->writeLine('return '.$code);
        }
        /**
         * Verify if request could be directly on Adapter
         */                 
        public function isEntityRequest() {
            if ($this->onAdapter) return false;
            if (
                $this->type == 'insert' 
                || $this->type == 'update'
                || $this->type == 'delete'
            ) {
                if (!isset($this->where)) {
                    if (!isset($this->adapter)) {
                        return true;
                    } else {
                        if ($this->adapter == $this->__root->mappingKey) {
                            return true;
                        } else {
                            return ($this->type == 'insert');
                        }
                    }  
                } else return false;
            } else return false;
        }
        /**
         * Initialize values
         */                 
        public function toPhp($onAdapter = false) {
            $this->onAdapter = $onAdapter;
            if (
                isset($this->adapter) 
                && $this->adapter != $this->getType()
            ) {
                $this->rqManager = 'pdoMap::get(\''
                                        .$this->adapter
                                    .'\')->getRequest()';
                $this->adapterLink     = 'pdoMap::get(\''.$this->adapter.'\')';
                if ($this->isEntityRequest()) {
                    $this->rqManager = '$entity';
                }                
                $this->isExternal     = true;
            } else {         
                if ($onAdapter) {
                    $this->rqManager = '$this->getRequest()';
                    $this->adapterLink = '$this';
                } else {
                    $this->adapterLink    = '$this->getAdapter()';
                    if ($this->isEntityRequest()) {
                        $this->rqManager = '$this';
                    } else {
                        $this->rqManager = '$this->getRequest()';                    
                    }
                }
                $this->isExternal     = false;
            }        
        }
    }
