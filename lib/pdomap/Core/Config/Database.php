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
     * The database config wrapper
     */          
    class pdoMap_Core_Config_Database {
        /**
         * @var array list of database adapters
         */                 
        protected $adapters = array();    
        /**
         * @var array list of adapters selected for each type
         */                 
        protected $adapterCheck = array();
        /**
         * Initialize a database configuration from array
         */                 
        public function __construct($adapters) {
            foreach($adapters as $name => $data) {
                $this->Add(
                    new pdoMap_Core_Config_DatabaseAdapter($name, $data)
                );  
            }        
        }
        /**
         * Add a new database adapter
         * @params pdoMap_Core_Config_DatabaseAdapter          
         */                 
        public function Add(pdoMap_Core_Config_DatabaseAdapter $adapter) {
            $this->adapters[$adapter->getName()] = $adapter;
        }
        /**
         * Get a database adapter from his name        
         * @return pdoMap_Core_Config_DatabaseAdapter
         * @throw pdoMap_Core_Config_Exceptions_DatabaseAdapterUndefined  
         * @see FindAdapterNameByType                
         */                 
        public function Get($name) {
            if (isset($this->adapters[$name])) {
                return $this->adapters[$name];            
            } else 
                throw new pdoMap_Core_Config_Exceptions_DatabaseAdapterUndefined(
                    $name
                );
        }
        /**
         * Get the adapter configuration instance
         * @params string The database connection type (declared from dsn)
         * @return pdoMap_Core_Config_DatabaseAdapter
         * @throw pdoMap_Core_Config_Exceptions_DatabaseAdapterNotFound
         * @see FindAdapterNameByType
         * @see Get                  
         */
        public function GetAdapterByType($type) {
            return $this->Get(
                $this->FindAdapterNameByType($type)
            );
        }
        /**
         * get the adapter name from type
         * @params string The database connection type (declared from dsn)
         * @returns string The adapter name (corresponding of path name)
         * @throw pdoMap_Core_Config_Exceptions_DatabaseAdapterNotFound                            
         * @see GetAdapterByType
         * @see Get                  
         */                 
        public function FindAdapterNameByType($type) {
            if (!isset($this->adapterCheck[$type])) {
                foreach($this->adapters as $name => $adapter) {
                    if ($adapter->CheckType($type)) {
                         $this->adapterCheck[$type] = $name;
                         return $name;
                    }
                }   
                throw new pdoMap_Core_Config_Exceptions_DatabaseAdapterNotFound(
                    $type
                );
            }
            return $this->adapterCheck[$type];
        }                            
    }