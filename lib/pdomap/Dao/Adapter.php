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
     * Adapter helper
     */         
    abstract class pdoMap_Dao_Adapter 
        extends 
            pdoMap_Core_Event 
    {        
    
        /**
         * Events declaration
         */                  
        protected $events = array(
            /**
             * Event raised when inserting an entity
             */                         
            'Insert'    => 'pdoMap_Dao_Adapter_Args',
            /**
             * Event raised when updating an entity
             */                         
            'Update'    => 'pdoMap_Dao_Adapter_Args',
            /**
             * Event raised when deleting an entity
             */                         
            'Delete'    => 'pdoMap_Dao_Adapter_Args',
            /**
             * Event raised when validating an entity
             */                         
            'Validate'  => 'pdoMap_Dao_Adapter_Args'
        );
    
        /**
         * @var string Adapter type
         */                 
        protected $type;
        
        /**
         * Get / Set the service state
         */                 
        protected $state = array();
        
        /**
         * Check if state was updated
         */                 
        protected $stateUpdated = false;
        
        /**
         * Constructor
         */                 
        public function __construct($type) {
            $this->type = $type;
        }
        /**
         * Get adapter type
         */    
        public function getType() { return $this->type; }  
		/**
		 * Get serializer properties
		 */         		
		public function __sleep() {
			return array('type', 'state');
        }           
        /**
         * Get a state value from cache
         */                 
        protected function getState($key, $default = null) {
            if (isset($this->state[$key])) {
                return $this->state[$key];
            } else return $default;
        }
        /**
         * Set a state value to cache
         */                 
        protected function setState($key, $value) {
            $this->state[$key] = $value;
            $this->stateUpdated = true;
        }
        /**
         * Get the updates status
         */                 
        public function getStateUpdates() { return $this->stateUpdated; }
        /**
         * Get entity structure
         */                 
        public function getStructure() { 
            return pdoMap::structure($this->type); 
        }        
        /**
         * Get the request manager
         */         
        public function getRequest() { 
            return pdoMap::request()->get($this->type); 
        }        
        /**
         * Select an entity
         */                 
        public function SelectEntity($id) {
            if (pdoMap::cache()->hasEntity($this->type, $id)) {
                return pdoMap::cache()->getEntity($this->type, $id);
            } else {
                return $this->SelectFirst(
                    $this->getStructure()->getPk()->bind, 
                    $id
                );
            }
        }
        /**
         * Select with a criteria
         */                 
        public function SelectBy($field, $value) {
            return $this->getRequest()
                ->Select()
                ->Where()
                    ->Cond($field, '=', $value)
                ->Run();
        }
        /**
         * Select first item with a criteria
         */                 
        public function SelectFirst($field = null, $value = null) {
            $ret = $this->getRequest()
                    ->Select()
                    ->Where();
            if (!is_null($field)) {
                $ret->Cond($field, '=', $value);
            }
            $ret = $ret->Limit(0, 1)->Run();
            if (sizeof($ret) == 1) {
                return $ret->current();
            } else return null;
        }
        /**
         * Delete items with a criteria
         */                 
        public function DeleteEntity($id) {
            $entity = $this->SelectEntity($id);
            if ($entity) {
                return $this->Delete($entity);
            } else return false;
        }        
        /**
         * Delete items with a criteria
         */                 
        public function DeleteBy($field, $value) {
            foreach($this->SelectBy($field, $value) as $entity) {
                $this->Delete($entity);
            }
        }
        /**
         * Delete first item with a criteria
         */                 
        public function DeleteFirst($field, $value) {
            foreach($this->SelectFirst($field, $value) as $entity) {
                $this->Delete($entity);
            }
        }
        /**
         * Select all items
         */                 
        public function SelectAll() {
            return $this->getSelectAll()->Run();
        }
        /**
         * Select all items
         */                 
        public function getSelectAll() {
            return $this->getRequest()->Select();
        }
        /**
         * Delete all items
         */                 
        public function DeleteAll() {
            foreach($this->SelectAll() as $entity) {
                $this->Delete($entity);
            }
        }
        /**
         * Delete an entity
         * @throws pdoMap_Dao_Exceptions_EntityValidate         
         */                 
        public function Delete(pdoMap_Dao_Entity $entity) {
            if (!$entity->isDbLink) {
                throw new pdoMap_Dao_Exceptions_EntityValidate($entity);
            }
            $event = $this->Raise(
                'Delete', 
                new pdoMap_Dao_Adapter_Args($entity)
            );
            if ($event) {
                $event->entity->isDbLink = false;
                $ok = $this->getRequest()
                            ->Delete()
                                ->Where()
                                ->Cond(
                                    $this->getStructure()->getPk()->bind, 
                                    '=', 
                                    $event->entity->getPk()
                                )
                                ->Limit(1)
                                ->Run();
                if ($ok) {
                    pdoMap::cache()->removeEntity($event->entity);
                    $event->entity->isDbLink = false;
                    $event->entity->isUpdated = false;                
                    $event->entity->setValue(
                        $this->getStructure()->getPk()->bind,
                        null
                    );
                    return true;
                } else return false;
            } else return false;
        }
        /**
         * Create a new entity instance
         */                 
        public function Create($values = null) {
            if ($values) {
                if (isset($values[$this->getStructure()->getPk()->bind])) {
                    $id = $values[$this->getStructure()->getPk()->bind];
                    if (pdoMap::cache()->hasEntity($this->type, $id)) {
                        $entity = pdoMap::cache()->getEntity($this->type, $id);
                        foreach($values as $key => $val) {
                            $entity->setValue($key, $val);
                        }
                        return $entity;
                    }
                } 
            }            
            $class = $this->getStructure()->entity;
            $entity = new $class($values);
            return $entity;
        }
        /**
         * Update an entity
         * @throws pdoMap_Dao_Exceptions_EntityValidate         
         */                 
        public function Update(pdoMap_Dao_Entity $entity) {
            if (!$this->Validate($entity))  
                throw new pdoMap_Dao_Exceptions_EntityValidate($entity);
            $event = $this->Raise(
                'Update', 
                new pdoMap_Dao_Adapter_Args(
                    $entity
                )
            );
            if ($event) {
                $request = $this->getRequest()->Update();
                foreach($this->getStructure()->getFields() as $field) {
                    pdoMap::field()->PrepareRequestSetter(
                        $event->entity,
                        $field,
                        $request
                    );
                }
                $ok = $request->Where()
                        ->Cond(
                            $this->getStructure()->getPk()->bind, 
                            '=', 
                            $event->entity->getPk()
                        )
                        ->Limit(1)
                        ->Run();
                if ($ok) {
                    $event->entity->Commit();
                    return true;
                } else {
                    throw new pdoMap_Dao_Exceptions_TransactionError(
                        'update', 
                        $entity
                    );
                }
            } else return false;
        }
        /**
         * Insert an entity
         * @returns mixed Returns inserted ID if ok, or false         
         * @throw pdoMap_Dao_Exceptions_EntityValidate         
         */                 
        public function Insert(pdoMap_Dao_Entity $entity) {
            // VALIDATE ENTITY
            if (!$this->Validate($entity)) 
                throw new pdoMap_Dao_Exceptions_EntityValidate($entity);
            // START INSERT EVENT
            $event = $this->Raise(
                'Insert', 
                new pdoMap_Dao_Adapter_Args($entity)
            );
            if ($event) {
                $request = $this->getRequest()->Insert();            
                foreach($this->getStructure()->getFields() as $field) {
                    pdoMap::field()->PrepareRequestSetter(
                        $event->entity,
                        $field,
                        $request
                    );
                }
                $id = $request->Run();
                if ($id) {
                     $event->entity->setValue(
                        $this->getStructure()->getPk()->bind,
                        $id
                    );
                    $event->entity->isDbLink = true;
                    $event->entity->Commit();                
                    pdoMap::cache()->setEntity($event->entity);
                    return $id; // RETURNS INSERTED ID
                } else {
                    throw new pdoMap_Dao_Exceptions_TransactionError(
                        'insert', 
                        $entity
                    );
                }
            } else return false; // EVENT WAS CANCEL
        }
        /**
         * Validate entity values
         * @throw pdoMap_Dao_Exceptions_EntityValidateIsNull
         * @throw pdoMap_Dao_Exceptions_EntityValidateType          
         */                 
        public function Validate(pdoMap_Dao_Entity $entity) {
            $event = $this->Raise(
                'Validate', 
                new pdoMap_Dao_Adapter_Args($entity)
            );
            if ($event) {
                // AUTOMATIC FIELD VALIDATION
                foreach($this->getStructure()->getFields() as $field) {
                    // SET DEFAULT VALUE
                    if (
                        is_null($event->entity->getValue($field->bind))
                        && !is_null($field->DefaultValue())
                    ) {
                        $event->entity->__set(
                            $field->bind, $field->DefaultValue()
                        );
                    }
                    // READ VALUE
                    try {
                        $value = $event->entity->__get($field->bind);                
                    } catch (Exception $ex) {
                        throw new pdoMap_Dao_Exceptions_EntityValidateType(
                            $event->entity, $field
                        );
                    }
                    // CHECK NULL CONSTRAINT
                    if (
                        !$field->IsNull() 
                        && is_null($value) 
                        && $field->type != 'Primary'
                    ) {
                    throw new pdoMap_Dao_Exceptions_EntityValidateIsNull(
                            $event->entity, $field
                        );
                    }
                    // VALIDATE FIELD VALUE
                    if (
                        !is_null($value) && 
                        !pdoMap::field()->Validate(
                            $event->entity, $field, $value
                        )
                    ) {
                        throw new pdoMap_Dao_Exceptions_EntityValidateType(
                            $event->entity, $field
                        );
                    }
                }
                return true;
            } else {
                return false;
            }
        }    
    }