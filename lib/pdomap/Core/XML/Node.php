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
     * @author          Ioan CHIRIAC <i dot chiriac at yahoo dot com>
     * @license         http://www.opensource.org/licenses/lgpl-2.1.php LGPL
     * @package         pdoMap
     * @subpackage      Core::XML
     * @link            www.pdomap.net
     * @since           2.*
     * @version         $Revision$
     */
     
    /**
     * Représente un noeud XML
     */         
    class pdoMap_Core_XML_Node {
        /**
         * Propriétées
         */                 
        protected $__childs = array();
        protected $__properties = array();
        protected $__parent;
        protected $__root;
        protected $__line;
        protected $__col;
        protected $__name;
        
        /**
         * Node constructor
         */                 
        public function __construct($name, $root, $parent) {
            $this->__name = $name;
            $this->__parent = $parent;
            $this->__root = $root;
        }
        /**
         * Get the tag name
         */                 
        public function getName() {
            return $this->__name;
        }
        /**
         * Get the parent tag
         */                 
        public function getParent() {
            return $this->__parent;
        }        
        /**
         * Retrieve the document root node
         */                 
        public function getRoot() {
            return $this->__root;
        }        
        /**
         * Add an item 
         */                 
        public function add($name, $value) {
            if (is_array($this->__properties[$name])) {
                $this->__properties[$name][] = $value;
                return true;
            } else return false;
        }
        /**
         * Add an item 
         */                 
        public function item($name, $value) {
            if (is_array($this->__properties[$name])) {
                $this->__properties[$name][$item] = $value;
                return true;
            } else return false;
        }        
        /**
         * Removes an item
         */                 
        public function remove($name, $index) {
            if (is_array($this->__properties[$name])) {
                if ($index == 0) {
                    array_shift($this->__properties[$name]);
                    return true; 
                } elseif ($index == sizeof($this->__properties[$name]) - 1) {
                    array_pop($this->__properties[$name]);
                    return true;
                } else {
                    if (isset($this->__properties[$name][$index])) {
                        $this->__properties[$name] = array_merge(
                            array_slice($this->__properties[$name], 0, $index), 
                            array_slice($this->__properties[$name], $index + 1)
                        );
                        return true;                
                    } else return false;
                }
            } else return false;
        }
        /**
         * Verify if property is defined
         */                 
        public function contains($key) {
            return (isset($this->__properties[$key]));
        }
        /**
         * Verify if is a node property
         */                 
        public function isNode($key) {
            if (!$this->contains($key)) return false;
            return is_a($this->__properties[$key], 'xmlNode');
        }
        /**
         * Get all properties
         */                 
        public function getProperties() {
            return $this->__properties;
        }
        /**
         * Vérifie l'existance d'une propriétée
         */                 
        public function __isset($key) {
            return (isset($this->__properties[$key]));
        }
        /**
         * Lit la valeur d'une propriétée
         */                 
        public function __get($key) {
            if (isset($this->__properties[$key])) {
                return $this->__properties[$key];
            } else {
                return null;
            }
        } 
        /**
         * Add a child item
         */                
        public function addChild(pdoMap_Core_XML_Node $child) {
           $this->__childs[] = $child;
           // echo 'Add child '.$this->getName().'.'.$child->getName().'<br />';
        }
        /**
         * Get all tag childs
         */                 
        public function getChilds() {
            return $this->__childs;
        } 
        /**
         * Get a list of childs from his tag name
         */                 
        public function getChildsByName($name) {
            $ret = array();
            foreach($this->__childs as $child) {
                if ($child->getName() == $name) {
                    $ret[] = $child;
                }
            }
            return $name;
        }
        /**
         * Get the first found child
         */                 
        public function getFirstChildByName($name) {
            foreach($this->__childs as $child) {
                if ($child->getName() == $name) {
                    return $child;
                }
            }
            return null;            
        }
        /**
         * Enregistre la valeur d'une propriétée
         */                 
        public function __set($key, $value) {
            $this->__properties[$key] = $value;
        }        
        /**
         * Serialize
         */                 
        public function __sleep() {
            return array("__properties");
        }
        /**
         * Link nodes
         */                 
        public function attachNodes(&$root, &$parent) {
            foreach($this->__properties as $key => $val) {
                if ($val instanceof xmlNode) {
                    $this->__properties[$key]->__parent = $parent;
                    $this->__properties[$key]->__root = $root;
                    $this->__properties[$key]->attachNodes($root, $this);
                }
                if (is_array($val)) {
                    foreach($val as $p => $v) {
                        if ($v instanceof xmlNode) {
                            $this->__properties[$key][$p]->__parent = $parent;
                            $this->__properties[$key][$p]->__root = $root;
                            $this->__properties[$key][$p]->attachNodes($root, $this);
                        }
                    }
                }
            }
        }
    }