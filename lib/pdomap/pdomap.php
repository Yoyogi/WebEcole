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
     * pdoMap Main Manager
     */              
    abstract class pdoMap {
        /**
         * @var string Root path (the pdoMap root)
         */               
        public static $rootPath;
        /**
         * @var string Caching path (must be secured - contains sensitive data) 
         * If path is in web folder (it's not recomended) you must create
         * a .htaccess file with this content :
         * <code>
         * Order Allow,Deny
         * Allow from None
         * Deny from All                           
         * </code>
         */               
        public static $cachePath;        
        /**
         * @var pdoMap_Parsing_Config_Document    Mapping configuration
         */                 
        private static $config;        
        /**
         * @var pdoMap_Cache_Manager  Cache manager instance
         */                 
        private static $cache;    
        /**
         * @var pdoMap_Database_Manager   Database manager instance         
         */                 
        private static $database;        
        /**
         * @var pdoMap_Database_Request_Manager   Request manager instance         
         */                 
        private static $request;
        /**
         * @var pdoMap_Database_Field Field manager instance
         */                 
        private static $field;
        /**
         * @var array Mapping structure buffer
         */                 
        private static $structures = array();
        /**
         * @var array Mapping services buffer
         */                 
        private static $services = array();                
        /**
         * Get the cache manager
         * @return pdoMap_Cache_Manager         
         */
        public static function cache() {
            if (!self::$cache) {
                self::$cache = new pdoMap_Cache_Manager();
            }
            return self::$cache;
        }    
        /**
         * Get the field manager
         */                     
        public static function field() {
            if (!self::$field) {
                self::$field = new pdoMap_Database_Field();
            }
            return self::$field;
        }                 
        /**
         * Get the database manager
         */                 
        public static function database() {
            if (!self::$database) {
                self::$database = new pdoMap_Database_Manager(); 
            }
            return self::$database;
        }
        /**
         * Get the request manager
         */                 
        public static function request($type = null) {
            if (!self::$request) {
                self::$request = new pdoMap_Database_Request_Manager(); 
            }
            if (!$type) {
                return self::$request;        
            } else return self::$request->get($type);
        }        
        /**
         * Get framework configuration instance
         * @returns pdoMap_Core_Config     
         */                 
        public static function config($file = null) {
            if (!is_null($file)) {
                $cache = pdoMap_Cache_Adapters_File::sanitizeFileName(
                    'config-'.$file
                );         
                try {
                    $refresh = filemtime($file) > @filemtime($cache);
                } catch (Exception $ex) {
                    $refresh = true;
                }       
                if ($refresh) {
                    $conf = new pdoMap_Parsing_Config_Document($file);
                    self::$config = $conf->getObject();
                    self::cache()->clear(); // clear all configuration  
                    // SAVING CONFIG AS CACHE
                    pdoMap_Cache_Adapters_File::file_store(
                        'config-'.$file, self::$config
                    );
                } else {
                    // READING CONFIGURATION
                    self::$config = pdoMap_Cache_Adapters_File::file_fetch(
                        'config-'.$file
                    );                
                }
                // WAKEUP SERVICES
                foreach(self::$config->getMapping()->getKeys() as $key) {
                    self::get($key); // initialize service
                }                
            } elseif (!self::$config) {
                throw new pdoMap_Exceptions_ConfigurationUndefined(
                    'undefined'
                );
            }
            return self::$config;
        }        
        /**
         * Get a mapping structure instance
         * @params string Mapping type     
         */                 
        public static function structure($type) {
            if (!isset(self::$structures[$type])) {
                $xml = self::config()
                            ->getMapping()
                            ->Get($type)
                            ->getMetaAbsolutePath();
                $time = time() - @filemtime($xml);
                if (!self::cache()->check('structure-'.$type, $time)) {
                    // REFRESH CACHE
                    $conf = new pdoMap_Parsing_Mapping_Document($xml);
                    try {      
                        if (!is_dir(self::$cachePath)) {
                            mkdir(self::$cachePath);
                        }              
                        self::cache()->set(
                            'structure-'.$type, 
                            $conf->generate(
                                self::$cachePath.$type, $type
                            )
                        );                        
                    } catch(Exception $ex) {
                        $conf->close();
                        if (file_exists(self::$cachePath.$type.'.class.php'))
                            unlink(self::$cachePath.$type.'.class.php');                        
                        if (file_exists(self::$cachePath.$type.'.structure.php'))
                            unlink(self::$cachePath.$type.'.structure.php');
                        throw new pdoMap_Core_InnerException(
                            $ex
                        );                    
                    }
                }    
                self::$structures[$type] = self::cache()->get('structure-'.$type);
            }
            return self::$structures[$type];
        }
        /**
         * Initialize mapping class files
         * @throw pdoMap_Exceptions_MappingNotFound
         */
        public static function using($type) {
            if (!isset(self::$services[$type])) {
                // REQUIRE GEN FILE
                self::structure($type);
                try {
                    $file = self::$cachePath.$type.'.class.php';
                    include_once($file);
                } catch(Exception $ex) {
                    throw new pdoMap_Exceptions_MappingNotFound(
                        $ex, $type, $file
                    );
                }
                // REQUIRE EXTENSION FILES (IF NEED)
                self::config()->getMapping()->Get($type)->RunRequires();                        
            }
        }                 
        /**
         * Get an adapter instance (singleton version)
         * Use static call directly for php 5.3 versions
         * @params string Binded table name           
         * @returns pdoMap_Dao_IAdapter
         * @throw pdoMap_Exceptions_ServiceDuplicated
         * @throw pdoMap_Exceptions_ServiceNotFound                 
         */                 
        public static function get($type) {
            if (!isset(self::$services[$type])) {
                self::using($type);                            
                if (!pdoMap::cache()->hasService($type)) {
                    $class = self::structure($type)->ResolveClassName();
                    if ($class) {
                        pdoMap::cache()->setService(
                            $type, 
                            new $class()
                        );
                    } else 
                        throw new pdoMap_Exceptions_ServiceNotFound($type);
                }         
                self::$services[$type] = pdoMap::cache()->getService($type);
            }
            return self::$services[$type];        
        }
        /**
         * Get an adapter instance
         * @returns pdoMap_Dao_IAdapter                  
         */                 
        public final static function __callStatic($type, $args = null) {
            return self::get($type);
        }
        /**
         * Autoload the framework classes 
         * @params string Class name
         * @returns mixed   
         * @throw pdoMap_Exceptions_ClassNotFound               
         */                 
        public static function autoload($class) {
            if (substr($class, 0, 7) == 'pdoMap_') { // works only for pdoMap framework
                $file = pdoMap::$rootPath
                    .str_replace(
                        '_', 
                        '/', 
                        substr(
                            $class, 
                            7
                        )
                    )
                    .'.php';
                try {
                    return include_once(
                        $file
                    );                                
                } catch(Exception $ex) {
                    throw new pdoMap_Exceptions_ClassNotFound($ex, $class);
                }
            } elseif (substr($class, -11) == 'AdapterImpl') {  // handles also generated classes
                $adapter = strtolower(substr($class, 0, strlen($class) - 11));
                self::get($adapter);
                if (!class_exists($class)) {
                    throw new pdoMap_Exceptions_ClassNotFound($ex, $adapter.':'.$class);
                }
                return true;
            } else return false; // ignore others classes
        }
    }
    
    /**
     * Defines pdoMap root directory
     */         
    pdoMap::$rootPath = dirname(__FILE__).'/';
    
    /**
     * Defines default pdoMap directories
     */         
    pdoMap::$cachePath         = pdoMap::$rootPath.'Cache/tmp/';
        
    /** 
     * Registers pdoMap Autoload Manager 
     */
    spl_autoload_register(array('pdoMap', 'autoload'));
    
    /**
     * Initialize error handler
     */         
    pdoMap_Exceptions_System::initialize(false);    
    
    /**
     * Initialize the default timezone
     */         
    date_default_timezone_set('Europe/Paris');