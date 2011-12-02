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
     * @subpackage     Core::Config
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * The mapping config wrapper
     */          
    class pdoMap_Core_Config_Mapping {
        
        /**
         * @var array list of registered adapters
         */                 
        protected $adapters = array();
        
        /**
         * @var string the mapping directory relative with configuration file
         */                 
        protected $root;
        
        /**
         * @var string configuration path 
         */                 
        protected $from;
        
        /**
         * Initialize a new mapping manager
         * @params array indexed array with adapters configuration         
         * @params string indicate the configuration file name (used to calculate the absolute path)
         * @params string the relative (from configuration) path to xml mapping files
         */                 
        public function __construct($adapters, $from, $path = './') {
            $this->root = $path;
            $this->from = $from;
            foreach($adapters as $key => $conf) {
                if (!isset($conf['meta'])) $conf['meta'] = null;
                if (!isset($conf['require'])) $conf['require'] = array();
                $this->Register(
                    $key, $conf['meta'], $conf['require']
                );
            }
        }
        /**
         * Registers a xml mapping file dynamically
         * @params string adapter name
         * @params string xml meta file name
         * @params array list of required php scripts                  
         */
        public function Register($name, $meta = null, $requires = array()) {
            $this->Add(
                new pdoMap_Core_Config_MappingAdapter(
                    $name, $meta, $requires
                )
            ); 
        }
        /**
         * Adds a new configuration adapter
         * @params pdoMap_Core_Config_MappingAdapter
         */                 
        public function Add(pdoMap_Core_Config_MappingAdapter $adapter) {
            $adapter->setParent($this);
            $this->adapters[$adapter->getName()] = $adapter;
        }
        /**
         * Retrieve a meta configuration from his key 
         */                 
        public function Get($key) {
            if (isset($this->adapters[$key])) {
                return $this->adapters[$key];
            } else {
                throw new pdoMap_Core_Config_Exceptions_MappingAdapterUndefined(
                    $key
                );
            }
        }
        /**
         * Get a list of mapping keys
         */                 
        public function getKeys() {
            return array_keys($this->adapters);
        }
        /**
         * Get the mapping path
         */                 
        public function getPath() {
            return $this->root;
        }
        /**
         * Get the absolute path
         */                 
        public function getAbsolutePath() {
            if (substr($this->root, 0, 1) == '.') {
                return realpath(dirname($this->from)).'/'.$this->root; 
            } else return $this->root;           
        } 
        /**
         * Set the mapping path
         */                 
        public function setPath($path) {
            $this->root = $path;
        }
        /**
         * Convert this object as an XML string
         */                 
        public function __toString() {
            $ret = "\n\t".'<mapping root="'.$this->getPath().'">';
            foreach($this->adapters as $adapter) $ret .= $adapter->__toString();
            $ret .= "\n\t".'</mapping>';
            return $ret;
        }
    }