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
     * @subpackage     Core
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * The configuration wrapper
     */          
    class pdoMap_Core_Config {
        /**
         * @var string the configuration file name
         */                 
        protected $file;
        /**
         * @var pdoMap_Core_Config_Database the database configuration
         */                 
        protected $database;
        /**
         * @var pdoMap_Core_Config_Cache the cache configuration
         */                 
        protected $cache;
        /**
         * @var pdoMap_Core_Config_Connections the connection manager
         */                 
        protected $connections;
        /**
         * @var pdoMap_Core_Config_Fields the fields configuration
         */                 
        protected $fields;
        /**
         * @var  pdoMap_Core_Config_Cache the mapping configuration
         */                 
        protected $mapping;
        /**
         * Configuration constructor (initialized by an array)
         * @params array Configuration data
         * @params string The configuration file                 
         */                 
        public function __construct($data, $file = null) {
            // initialize the database adapters
            $this->database = new pdoMap_Core_Config_Database(
                $data['database']
            );
            // initialize the fields array
            $this->fields = new pdoMap_Core_Config_Fields(
                $data['fields']
            );
            // initialize the cache array
            $this->cache = new pdoMap_Core_Config_Cache(
                $data['cache']
            );
            // initialize connections configuration wrapper            
            $this->connections = new pdoMap_Core_Config_Connections(
                $data['connections']
            );
            // initialize mapping configuration wrapper
            $this->mapping = new pdoMap_Core_Config_Mapping(
                $data['mapping'], $file, $data['root']
            );
            // initialize class
            $this->file = $file;
            $this->__wakeup();
        }     
        /**
         * Deserialize wakeup function
         */         
        public function __wakeup() {
            // setup database connections
            $this->connections->Register();           
        }           
        /**
         * Get the database configuration
         * @returns pdoMap_Core_Config_Database         
         */                         
        public function getDatabase() {
            return $this->database;
        }
        /**
         * Get the cache configuration
         * @returns pdoMap_Core_Config_Cache         
         */                 
        public function getCache() {
            return $this->cache;
        }
        /**
         * Get the connections configuration
         * @return pdoMap_Core_Config_Connections         
         */                 
        public function getConnections() {
            return $this->connections;
        }
        /**
         * Get the fields configuration
         * @returns pdoMap_Core_Config_Fields         
         */                 
        public function getFields() {
            return $this->fields;
        }
        /**
         * Get the mapping configuration
         * @return pdoMap_Core_Config_Mapping         
         */                 
        public function getMapping() {
            return $this->mapping;
        }
        /**
         * Get the configuration file name
         * @returns string the configuration file name         
         */                 
        public function getFile() {
            return $this->file;
        }
        /**
         * Save configuration data as XML
         * @params string (Optional) save to specified file name         
         * @throw pdoMap_Core_Config_Exceptions_WriteError
         */                 
        public function Save($as = null) {
            if (!$as) $as = $this->file;
            $f = @fopen($this->file, 'w+');
            if ($f) {
                fputs($f, '<?xml version="1.0"?'.">\n");
                fputs($f, '<pdomap>');
                fputs($f, $this->connections->__toString());
                fputs($f, $this->mapping->__toString());
                fputs($f, "\n".'</pdomap>');
                fclose($f);
                $this->file = $as;
            } else 
                throw new pdoMap_Core_Config_Exceptions_WriteError(
                    $as
                );
        }
    }