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
     * @subpackage     Database
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
         
    /**
     * Database pool manager
     */          
    class pdoMap_Database_Manager 
        extends 
            pdoMap_Core_Event
    {
    
        /**
         * Declare events
         */                 
        protected $events = array(
            /**
             * Event raised when connecting to a database
             */                        
            'Connect'   => 'pdoMap_Database_Manager_Args',
            /**
             * Event raised when closing connection to a database
             */ 
            'Close'     => 'pdoMap_Database_Manager_Args',
            /**
             * Event raised when requesting data
             */  
            'Query'     => 'pdoMap_Database_Manager_Args',
            /**
             * Event raised when request is bad
             */ 
            'Error'     => 'pdoMap_Database_Manager_Args'
        );
    
        /**
         * PDO objects instances
         */                 
        private $connectors = array();
        /**
         * Registered connection strings
         */                 
        private $connections = array();
        /**
         * Queries counter
         */               
        private $nbQuery = 0;  
        /**
         * Registering a connection string
         * @params string Connection string (type:host=...&dbname=...)                  
         * @params string User name, by default root
         * @params string User password, by default empty                           
         * @params string Tables name prefix, by default empty (usefull for multiple app on a single database)         
         * @params string Connection key (use by default '*')
         */        
        public function Register(
            $connectionString, 
            $userName = 'root', 
            $password = '', 
            $prefix = '', 
            $key = '*'
        ) {
            if (isset($this->connectors[$key])) {
                // close open session if already openned                
                $this->close($key);
            }
            $type = explode(':', $connectionString, 2);
            $args = explode(';', $type[1]);
            $this->connections[$key] = array(
                $connectionString, 
                $userName, 
                $password, 
                strtolower($type[0]), 
                $prefix,
                array()
            );
            foreach($args as $arg) {
                $data = explode('=', $arg, 2);
                $this->connections[$key][5][strtolower($data[0])] = $data[1];
            }
        }
        /**
         * Close a database connection
         * @params string Connection key     
         */                                          
        public function Close($key) {
            if (isset($this->connectors[$key])) {
                $this->Raise(
                    'Close', 
                    new pdoMap_Database_Manager_Args($key)
                );
                unset($this->connectors[$key]);            
            }
        }        
        /**
         * Get a PDO instance by connection key
         * @params string Connection key         
         * @returns PDO The PDO instance     
         * @see PDO
         */                          
        public function getPdo($key) {
            if (!isset($this->connectors[$key])) {
                if (isset($this->connections[$key])) {
                    $this->Raise(
                        'Connect', 
                        new pdoMap_Database_Manager_Args(
                            $key, 
                            $this->connections[$key][0]
                        )
                    );
                    $this->connectors[$key] = new PDO(
                        $this->connections[$key][0],    // connection string
                        $this->connections[$key][1],    // user name
                        $this->connections[$key][2]   // password
                    );    
                } else {
                    $this->Raise(
                        'Error', 
                        new pdoMap_Database_Manager_Args(
                            $key, 
                            'Unable to connect'
                        )
                    );                
                    throw new pdoMap_Database_Exceptions_ConnectionUndefined($key);
                }
            }
            return $this->connectors[$key];
        }
        /**
         * Get the database type : mysql / oracle / mssql ...
         * @params string Connection key         
         * @returns string The database driver type          
         */                 
        public function getType($key = '*') {
            return $this->connections[$key][3];
        }
        /**
         * Get the database host name
         * @params string Connection key         
         */                 
        public function getHost($key = '*') {
            return $this->connections[$key][5]['host'];
        }
        /**
         * Get the database name
         * @params string Connection key         
         */                 
        public function getName($key = '*') {
            return $this->connections[$key][5]['dbname'];
        }    
        /**
         * Get the database user
         * @params string Connection key         
         */                 
        public function getUser($key = '*') {
            return $this->connections[$key][1];
        }    
        /**
         * Get a table prefix value
         * @params string Connection key         
         */                 
        public function getPrefix($key = '*') {
            return $this->connections[$key][4];
        }
        /**
         * Select another database
         */                 
        public function Change($name, $database = '*') {
            $this->close($database);
            $old = $this->connections[$database][5]['dbname'];
            $this->connections[$database][5]['dbname'] = $name;
            $this->connections[$database][0] = str_ireplace(
                'dbname='.$old, 
                'dbname='.$name, 
                $this->connections[$database][0]
            );
        }
        /**
         * Use generic request function
         * @params     string                Connection key         
         * @params     string                Requested SQL
         * @returns PDOStatement     Résultat de l'execution              
         */
        public function Request($key, $sql) {
            $this->Raise(
                'Query',
                new pdoMap_Database_Manager_Args($key, $sql)
            );                
            $this->nbQuery ++;
            $ret = $this->getPdo($key)->query($sql);
            if (!$ret) {
                $err = $this->getPdo($key)->errorInfo();
                $this->Raise(
                    'Error', 
                    new pdoMap_Database_Manager_Args($key, $err)
                );                
                throw new pdoMap_Database_Exceptions_BadRequest(
                    $key, $err[0], $err[1], $err[2], $sql
                );
            } else return $ret;
        }        
        /**
         * Get a result iterator
         */                  
        public function RequestArray($key, $sql, $type = null) {
            return new pdoMap_Database_Request_Dataset(
                $this->request($key, $sql), 
                $type
            );
        }
        /**
         * Use generic fetch execution
         * @params PDOStatement Objet de parsing de la requette              
         */
        public function Fetch(PDOStatement &$ptr) {
            return $ptr->fetch(PDO::FETCH_ASSOC);
        }
        /**
         * Count and get number of executed queries
         */                 
        public function CountSQL() {
            return $this->nbQuery;
        }
    }