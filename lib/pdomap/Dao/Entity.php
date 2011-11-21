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
     * Abstract entity
     * @tested     
     */         
    abstract class pdoMap_Dao_Entity {
        /**
         * @var string Indicates entity adapter name
         */                 
        protected $type;
        /**
         * @var boolean Indicates if entity is from db or not
         */                 
        public $isDbLink = false;
        /**
         * @var boolean Indicates if entity has pending changes
         */                 
        public $isUpdated = false;
        /**
         * @var array Entity values collection (stored from db)
         */                 
        protected $values = array();
        /**
         * @var array Pending entity values collection
         */                 
        protected $pending = array();
        /**
         * Constructor
         * @params string Adapter type
         * @params array Values to initialize from database                  
         */                 
        protected function __construct($type, $values = null) {
            $this->type = $type;
            // LOAD VALUES FROM ARRAY
            if ($values) {
                $this->values = $values;
                if (!isset($this->values[$this->getStructure()->getPk()->bind])) {
                    $this->values[$this->getStructure()->getPk()->bind] = null;
                }
                if ($this->getPk() > 0) {
                    $this->isDbLink = true;
                    pdoMap::cache()->setEntity($this);
                } else {
                    $this->pending = $this->values;
                    $this->values = array();
                    $this->isUpdated = true;
                }
            }
        }
        /**
         * Get the entity type
         */                         
        public function getType() { 
            return $this->type; 
        }
        /**
         * Get entity structure
         */                 
        public function getStructure() { 
            return pdoMap::structure($this->type); 
        }
        /**
         * Get entity request manager
         */                 
        public function getRequest() { 
            return pdoMap::request()->get($this->type); 
        }
        /**
         * Get adapter instance
         */                 
        public function getAdapter() { 
            return pdoMap::get($this->type);
        }
        /**
         * Get the primary key value
         */                 
        public function getPk() {
            return $this->getValue(
                $this->getStructure()->getPk()->bind
            );
        }
        /**
         * Get values array
         */             
        public function getDbValues() {
            return $this->values;
        }    
        /**
         * Reads a value from collection
         */
        public final function getValue($key, $default = null) {
            if (isset($this->pending[$key])) {
                return $this->pending[$key];            
            } elseif (isset($this->values[$key])) {
                return $this->values[$key];                        
            } else return $default;
        }           
        /**
         * Write a value to collection
         */
        public final function setValue($key, $value) {
            $this->isUpdated = true;
            return ($this->pending[$key] = $value);
        }  
        /**
         * Get a value from collection
         */
        protected function __getter($key) {
            return pdoMap::field()->getter(
                $this,
                $this->getStructure()->getField($key),
                $this->getValue($key)
            );
        }                         
        /**
         * Set a value to collection
         */                 
        protected function __setter($key, $value) {
            if (!is_null($value)) {
                $value = pdoMap::field()->setter(
                    $this,
                    $this->getStructure()->getField($key),
                    $value
                );            
            }
            $this->setValue(
                $key, 
                $value
            );
            return $value;
        }
        /**
         * Flush entity to database
         * @returns boolean Returns true if entity was flushed or false if dont need
         */                 
        public function Flush() {
            if (!$this->isDbLink) {
                return $this->Insert();
            } elseif ($this->isUpdated) {
                return $this->Update();
            } else return false;
        }
        /** 
         * Perform an rollback on updates during execution 
         * from last database flush
         */                 
        public function RollBack() {
            $this->pending = array();
            $this->isUpdated = ($this->getPk() != null);
        }     
        /**
         * Internal function called after Insert or Update
         * to say to entity that was flushed correctly on database         
         */                 
        public function Commit() {
            foreach($this->pending as $k => $v) $this->values[$k] = $v;
            $this->pending = array();
            $this->isUpdated = false;
        }   
        /**
         * Reload state from database
         */                 
        public function Refresh() {
            pdoMap::cache()->removeEntity($this);
            return pdoMap::get($this->type)->SelectEntity($this->getPk());        
        }
        
        #region Implementing Interface IEntity
        /**
         * Update current entity
         */                 
        public function Update() {
            if (!$this->isDbLink) {
                return $this->Insert();
            } else return $this->getAdapter()->Update($this);
        }
        /**
         * Unable to clone this object
         */                 
        public function __clone() {
            throw new Exception();
        }
        /**
         * Insert current entity
         */                 
        public function Insert() {
            return $this->getAdapter()->Insert($this);
        }
        /**
         * Delete current entity
         */                 
        public function Delete() {
            return $this->getAdapter()->Delete($this);
        }
        /**
         * Validate current entity
         */                 
        public function Validate() {
            return $this->getAdapter()->Validate($this);
        }                
        #endregion
        #region Magic PHP functions
        /**
         * Magic getter
         */                 
        public final function __get($key) {
            $method = 'getter'.$key;
            if (method_exists($this, $method)) {
                return call_user_func(array($this, $method));                
            } else return $this->__getter($key);
        }
        /**
         * Magic setter
         */                 
        public final function __set($key, $value) {
            $method = 'setter'.$key;
            if (method_exists($this, $method)) {
                $value = call_user_func(array($this, $method), $value);                
            }
            return $this->__setter($key, $value);
        }
        /**
         * Get a string representation of entity
         */                 
        public function __toString() {
            return $this->type.'('.$this->getPk().')';
        }        
        /**
         * Load object from a var_export command
         */                 
        public static function __set_state($data) {
            return pdoMap::get($data['type'])->Create($data['values']);
        }
        #endregion                
    }