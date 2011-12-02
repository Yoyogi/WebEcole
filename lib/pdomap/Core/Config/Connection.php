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
     * The connection configuration
     */          
    class pdoMap_Core_Config_Connection {
        /**
         * @var string the connection key
         */                 
        protected $key;
        /**
         * @var string the connection DSN
         * @see http://www.php.net/manual/en/pdo.connections.php         
         */                 
        protected $dsn;
        /**
         * @var string user name
         */                 
        protected $user;
        /**
         * @var string password
         */                          
        protected $pwd;
        /**
         * @var string tables prefix
         */                 
        protected $prefix;
        
        /**
         * Construct a connection from his key and data structure
         * @params string unique connection key used by mapping (* by default)
         * @params array configuration of connection in an indexed :
         * indexes : dsn, user, pwd, prefix                            
         */                 
        public function __construct($key, $data) {
            $this->key = $key;        
            if (isset($data['dsn'])) {
                $this->dsn = $data['dsn'];
            }
            if (isset($data['user'])) {
                $this->user = $data['user'];
            }
            if (isset($data['pwd'])) {
                $this->pwd = $data['pwd'];
            }
            if (isset($data['prefix'])) {
                $this->prefix = $data['prefix'];
            }        
        }
        /**
         * Register on pdoMap current connection
         */                 
        public function Register() {
            return pdoMap::database()->Register(
                $this->dsn, 
                $this->user, 
                $this->pwd, 
                $this->prefix, 
                $this->key
            );                
        }
        /**
         * Get the connection key
         */                 
        public function getKey() {
            return $this->key;
        }
        /**
         * Get the connection user
         */                 
        public function getUser() {            
            return $this->user;
        }
        /**
         * Set the user connection
         * @params string User name
         * @params string Connection key                  
         */           
        public function setUser($user = 'root') {
            $this->user = $user; 
        }      
        /**
         * (WriteOnly) Set the password connection
         * @params string Password
         */                 
        public function setPwd($pwd = '') {
            $this->pwd = $pwd;             
        }
        /**
         * Get tables prefix
         */
        public function getPrefix() {
            return $this->prefix;
        }         
        /**
         * Set the tables prefix
         * @params string Prefix for each table
         */                 
        public function setPrefix($prefix = '') {
            $this->prefix = $prefix;
        }
        /**
         * Get the connection dsn
         */                 
        public function getDsn() {
            return $this->dsn;
        }
        /**
         * Set the connection string
         * @params string Connection string
         */                 
        public function setDsn($dsn = '') {
            $this->dsn = $dsn;
        }             
        /**
         * Convert this object as an XML string
         */                 
        public function __toString() {
            $ret = "\n\t\t".'<add ';
            $ret .= 'key="'.$this->key.'" ';
            $ret .= 'dsn="'.$this->dsn.'" ';
            $ret .= 'user="'.$this->user.'" ';
            $ret .= 'pwd="'.$this->pwd.'" ';
            $ret .= 'prefix="'.$this->prefix.'" ';
            return $ret.'/>';
        } 
    }