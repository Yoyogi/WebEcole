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
     * @subpackage     Parsing::Config
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * Cached configuration file
     */          
    class pdoMap_Parsing_Config_Cache {
        private $data;
        private $runtime;
        private $file;
        private $adapterCheck = array();
        
        public $cacheAdapter = null;
        public $cacheAdapters = array(
                                    'APC' => array(
                                        'module' => 'apc'
                                    ), 
                                    'MemCache' => array(
                                        'module' => 'memcache'
                                    ), 
                                    'File'
                                );
        public $databaseFields = array(
                                    'Boolean', 'Char', 'Date', 
                                    'Enum', 'File', 'Float',
                                    'Foreign', 'Integer', 'Primary', 
                                    'Text'
                                ); 
                                       
        /**
         * Constructor
         * @params array Configuration data         
         */                 
        public function __construct($data, $file = null) {
            $this->data = $data;
            $this->file = $file;
            $this->runtime = array();
            $this->__wakeup();
        }
        /**
         * Registering database connections
         */         
        public function __wakeup() {
            foreach($this->data['connections'] as $key => $cnx) {
                pdoMap::database()->Register($cnx['dns'], $cnx['user'], $cnx['pwd'], $cnx['prefix'], $key);
            }            
        }
        /**
         * Set the user connection
         * @params string User name
         * @params string Connection key                  
         */           
        public function setUser($user = 'root', $db = '*') {
            $this->data['connections'][$db]['user'] = $user; 
        }      
        /**
         * Set the password connection
         * @params string Password
         * @params string Connection key                  
         */                 
        public function setPwd($pwd = '', $db = '*') {
            $this->data['connections'][$db]['pwd'] = $pwd;             
        }
        /**
         * Set the tables prefix
         * @params string Prefix for each table
         * @params string Connection key                  
         */                 
        public function setPrefix($prefix = '', $db = '*') {
            $this->data['connections'][$db]['prefix'] = $prefix;
        }
        /**
         * Set the connection string
         * @params string Connection string
         * @params string Connection key                  
         */                 
        public function setDns($dns = '', $db = '*') {
            $this->data['connections'][$db]['dns'] = $dns;
        }
        /**
         * Save and execute connections
         */                 
        public function Save() {
            $f = @fopen($this->file, 'w+');
            if ($f) {
                fputs($f, '<?xml version="1.0"?'.">\n");
                fputs($f, '<pdomap>'."\n");
                fputs($f, "\t".'<connections>'."\n");
                foreach($this->data['connections'] as $key => $info) {
                    fputs($f, "\t\t".'<add ');
                    foreach($info as $key => $data) {
                        fputs($f, $key.'="'.$data.'" ');
                    }
                    fputs($f, '/>'."\n");                
                }
                fputs($f, "\t".'</connections>'."\n"); 
                fputs($f, "\t".'<mapping root="'.$this->data['root'].'"');
                if (sizeof($this->data['mapping']) > 0) {
                    fputs($f, '>'."\n");
                    foreach($this->data['mapping'] as $key => $data) {
                        fputs($f, "\t\t".'<adapter ');
                        fputs($f, 'name="'.$key.'" ');
                        fputs($f, 'path="'.$data['path'].'" ');
                        fputs($f, 'meta="'.$data['meta'].'"');
                        if (sizeof($data['require']) > 0) {
                            fputs($f, ">\n");
                            foreach($data['require'] as $file) {
                                fputs($f, "\t\t\t".'<require>'.$file.'</require>'."\n");
                            }
                            fputs($f, "\t\t".'</adapter>'."\n");                    
                        } else {
                            fputs($f, " />\n");
                        }
                    }
                    fputs($f, "\t".'</mapping>'."\n");                
                } else {
                    fputs($f, ' />'."\n");                
                }
                fputs($f, '</pdomap>'."\n");
                fclose($f);
                $this->__wakeup();
                return true;
            } else return false;
        }
        /**
         * get the adapter name from type
         * @params string The database connexion type (declared from dsn)
         * @returns string The adapter name (corresponding of path name)                   
         */                 
        public function FindAdapterByType($type) {
            if (!isset($this->adapterCheck[$type])) {
                foreach($this->data['databaseAdapters'] as $name => $conf) {
                    $isOk = false;
                    // compare database types : OR
                    foreach($conf['check']['type'] as $check) {
                        if ($check == $type) {
                            $isOk = true;
                            break;
                        }
                    }
                    if (!$isOk) continue;
                    // check loaded extensions : AND
                    foreach($conf['check']['module'] as $check) {
                        if (!extension_loaded($check)) {
                            $isOk = false;
                            break;
                        }
                    }
                    if (!$isOk) continue;
                    // check defined functions : AND
                    foreach($conf['check']['function'] as $check) {
                        if (!function_exists($check)) {
                            $isOk = false;
                            break;
                        }
                    }                    
                    if (!$isOk) continue;
                    // check defined classes
                    foreach($conf['check']['class'] as $check) {
                        if (!class_exists($check)) {
                            $isOk = false;
                            break;
                        }
                    }
                    // check if was found
                    if (!$isOk) {
                        continue;  
                    } else {
                        break;
                    }                  
                }   
                // handle result
                if (!$isOk) {
                    // @todo cast exception
                    throw new Exception('Unable to find adapter for type '.$type);
                } else {
                    $this->adapterCheck[$type] = $name;
                }
            }
            return $this->adapterCheck[$type];
        }         
        /**
         * Include requires list 
         * @throw pdoMap_Parsing_Config_Exceptions_MappingUndefined   
         * @throw pdoMap_Exceptions_MappingNotFound               
         */                 
        public function RunRequires($type) {
            $data = $this->mapping($type);
            $root = $this->getRootPath().$data['path'];
            foreach($data['require'] as $file) {
                if (file_exists($root.$file)) {
                    require_once($root.$file);
                } else throw new pdoMap_Exceptions_MappingNotFound($type, $root.$file);
            }
        } 
        /**
         * Check if a service was defined
         */                 
        public function exists($type) {
            return (
                isset($this->data['mapping'][$type]) 
                || isset($this->runtime['mapping'][$type])
            );
        }       
        /**
         * Get the mapping configuration
         * @throw pdoMap_Parsing_Config_Exceptions_MappingUndefined         
         */                 
        public function mapping($type) {
            if ($this->exists($type)) {
                if (isset($this->data['mapping'][$type])) {
                    return $this->data['mapping'][$type];            
                } else {
                    return $this->runtime['mapping'][$type];
                }
            } else 
                throw new pdoMap_Parsing_Config_Exceptions_MappingUndefined($type);
        }
        /**
         * Registers a xml mapping file dynamically
         */                 
        public function register($type, $path = null, $file = null, $requires = null) {
            if (!$file) $file = $type.'.map.xml';
            if (!$requires) $requires = array();
            $this->runtime['mapping'][$type] = array(
                'path'      => $path,
                'meta'      => $file,
                'require'   => $requires
            );
        }
        /**
         * Get the meta link with full path
         * @throw pdoMap_Parsing_Config_Exceptions_MappingUndefined         
         */                 
        public function getMetaPath($type) {
            $data = $this->mapping($type);
            return 
                $this->getRootPath()
                .$data['path']
                .$data['meta'];
        }
        /**
         * Get the mapping root
         */                 
        public function getRootPath() {
            if (substr($this->data['root'], 0, 1) == '.') {
                return realpath(dirname($this->file)).'/'.$this->data['root']; 
            } else return $this->data['root'];        
        }
        /**
         * Get the mapping key list
         */                 
        public function getMappingKeys() {
            if (isset($this->runtime['mapping'])) {
                return array_merge(
                    array_keys($this->data['mapping']), 
                    array_keys($this->runtime['mapping'])
                );
            } else 
                return array_keys($this->data['mapping']);
        }
        /**
         * Deserialize from php code
         */                 
        public function __set_state($conf) {
            return new pdoMap_Parsing_Config_Cache($conf['data'], $conf['file']);
        }        
    }