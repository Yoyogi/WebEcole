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
     * The cache config wrapper
     */          
    class pdoMap_Core_Config_Cache {
        /**
         * @var string define the cache adapter name
         */                 
        protected $adapter = null;
        /**
         * @var array the key / values indexed options
         */                 
        protected $options = array(); 
        /**
         * @var array list of adapters
         */                        
        protected $adapters = array();        
        /**
         * Initialize the cache configuration from configuration array
         */                 
        public function __construct($data) {
            if (isset($data['options'])) {
                $this->options = $data['options'];
            }         
            foreach($data['adapters'] as $name => $info) {
                $this->Add(
                    new pdoMap_Core_Config_CacheAdapter(
                        $name, $info
                    )
                );
            }   
        }
        /**
         * Add a new cache adapter
         * @params pdoMap_Core_Config_CacheAdapter         
         */                 
        public function Add(pdoMap_Core_Config_CacheAdapter $adapter) {
            $this->adapters[$adapter->getName()] = $adapter;
        }
        /**
         * Get an adapter configuration from his name
         * @returns pdoMap_Core_Config_CacheAdapter         
         */                 
        public function Get($name) {
            if (isset($this->adapters[$name])) {
                return $this->adapters[$name];
            } else 
                throw new pdoMap_Core_Config_Exceptions_CacheAdapterUndefined(
                    $name
                ); 
        }
        /**
         * Get an option value
         */                            
        public function getOption($name, $default = null) {
            if (isset($this->options[$name])) {
                return $this->options[$name];
            } else return $default;
        }
        /**
         * Set an option value
         */                 
        public function setOption($name, $value) {
            $this->options[$name] = $value;
        }        
        /**
         * Get or find for the adapter name
         */                 
        public function getAdapterName() {
            if (!$this->adapter) {
                foreach($this->adapters as $name => $config) {
                    if ($config->Check()) {
                        $this->adapter = $name;
                        break;
                    }
                }                       
                if (!$this->adapter) {
                    throw new 
                        pdoMap_Core_Config_Exceptions_CacheAdapterNotFound();
                }
            }
            return $this->adapter;
        }
        /**
         *  Get current cache adapter configuration
         */                 
        public function getAdapter() {
            return $this->Get($this->getAdapterName());
        }       
    }