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
     * Parse xml file
     */          
    class pdoMap_Parsing_Config_Document 
        extends 
            pdoMap_Core_XML_Document 
    {
        /**
         * Loads and read a xml mapping file
         */                 
        public function __construct($file) {
            $this->hasMany(
                array(
                    'add', 'adapter', 'check', 
                    'require', 'field', 'param'
                )
            );
            parent::__construct(pdoMap::$rootPath.'config.xml');
            $this->overload($file);            
        } 
        /**
         * Load file with specific xsd if not set
         */                 
        public function load($file, $xsd = null) {
            if (!$xsd) $xsd = pdoMap::$rootPath.'Parsing/Config/Structure.xsd';
            parent::load($file,  $xsd);
        } 
        /**
         * Overload file with specific xsd if not set
         */                   
        public function overload($file, $xsd = null) {
            if (!$xsd) $xsd = pdoMap::$rootPath.'Parsing/Config/Structure.xsd';
            parent::overload($file,  $xsd);
        }       
        /**
         * Returns an configuration array
         */                 
        public function getArray() {
            $ret = array(
                'database' => array(),
                'fields' => array(),
                'cache' => array(
                    'adapter' => null,
                    'options' => array(),
                    'adapters' => array()
                ),
                'connections' => array(),                 
                'mapping' => array(),
                'root' => './'
            );
            // READ DATABASE ADAPTERS ARRAY            
            if (isset($this->database) && isset($this->database->adapter)) {
                foreach($this->database->adapter as $adapter) {
                    // define entry
                    $ret['database'][$adapter->name] = array(
                        'enabled' => ($adapter->enabled == 'true'),
                        'check' => array(
                            'type' => array(),      // OR
                            'module' => array(),    // AND
                            'function' => array(),  // AND
                            'class' => array()      // AND
                        )
                    );
                    // read the check array
                    if (isset($adapter->check)) {
                        foreach($adapter->check as $check) {
                            foreach($check->getProperties() as $key => $value) {
                                if (isset(
                                    $ret['database'][$adapter->name]['check'][$key]
                                )) {
                                    $ret['database'][$adapter->name]['check'][$key][] = $value;
                                } else {
                                    throw new Exception('Illegal property '.$key);                            
                                }                            
                            }
                        }
                    }
                }
            }
            // READ CONNECTION ARRAY
            if (isset($this->connections) && isset($this->connections->add)) {
                foreach($this->connections->add as $cnx) {
                    if (isset($cnx->key)) {
                        $key = $cnx->key;
                    } else $key = '*';
                    $ret['connections'][$key] = array(
                        'dsn' => $cnx->dsn,
                        'user' => $cnx->user,
                        'pwd' => $cnx->pwd,
                        'prefix' => $cnx->prefix
                    );
                }
            }
            // READ MAPPING ARRAY
            if (isset($this->mapping)) {
                if (isset($this->mapping->root)) {
                    $ret['root'] = $this->mapping->root;
                }
                if (isset($this->mapping->adapter)) {
                    foreach($this->mapping->adapter as $adapter) { 
                        if (isset($adapter->meta)) {
                            $meta = $adapter->meta;
                        } else $meta = $adapter->name.'.map.xml';
                        $ret['mapping'][$adapter->name] = array(
                            'path' => $adapter->path,
                            'meta' => $meta,
                            'require' => array()
                        );
                        if (isset($adapter->require)) {
                            $ret['mapping'][$adapter->name]['require'] = $adapter->require;
                        }
                    }
                }
            }        
            // READ THE CACHE ARRAY
            if (isset($this->cache)) {
                $ret['cache']['adapter'] = $this->cache->use;
                if (isset($this->cache->params)) {
                    foreach($this->cache->params->param as $param) {
                        $ret['cache']['options'][$param->name] = $param->value;
                    }
                }
                if (isset($this->cache->adapter)) {
                    foreach($this->cache->adapter as $adapter) {
                        $ret['cache']['adapters'][$adapter->name] = array(
                            'enabled' => ($adapter->enabled == 'true'),
                            'check' => array(
                                'module' => array(),    // AND
                                'function' => array(),  // AND
                                'class' => array()      // AND                            
                            ),
                            'options' => array()
                        );
                        // read the check array
                        if (isset($adapter->check)) {
                            foreach($adapter->check as $check) {
                                foreach($check->getProperties() as $key => $value) {
                                    if (isset(
                                        $ret['cache']['adapters'][$adapter->name]['check'][$key]
                                    )) {
                                        $ret['cache']['adapters'][$adapter->name]['check'][$key][] = $value;
                                    } else {
                                        throw new Exception('Illegal property '.$key);                            
                                    }                            
                                }
                            }
                        } 
                        // read params array
                        if (isset($adapter->params)) {
                            foreach($adapter->params->param as $param) {
                                $ret['cache']['adapters'][$adapter->name]['options'][$param->name] = $param->value;
                            }
                        }                        
                    }
                }
            }
            // READ FIELDS ARRAY
            if (isset($this->fields)) {
                foreach($this->fields->field as $field) {
                    $ret['fields'][$field->name] = array(
                        'enabled' => ($field->enabled == true),
                        'options' => array()
                    ); 
                    if (isset($field->param) && is_array($field->param)) {
                        foreach($field->param as $param) {
                            $ret['fields'][$field->name]['options'][$param->name] = $param->value;
                        }
                    }
                }
            }    
            // Return result
            return $ret;
        }
        /**
         * Instanciate an object
         * @returns pdoMap_Core_Config         
         */                 
        public function getObject() {
            return new pdoMap_Core_Config(
                $this->getArray(), $this->__file
            );
        }
    }
