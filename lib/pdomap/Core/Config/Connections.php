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
     * The connections configuration collection
     */          
    class pdoMap_Core_Config_Connections {
        /**
         * @var array indexed array of connections 
         */                 
        private $connections = array();
        /**
         * Initialize a database connections manager
         * @params array List of connections with the following structure
         * array {
         *   [connection key] => array {
         *      [dsn]       => [dbtype]:host=[host]&dbname=[dbname]
         *      [user]      => database user name
         *      [pwd]       => database password
         *      [prefix]    => tables prefix                          
         *   } 
         * }         
         */                 
        public function __construct($connections) {
            foreach($connections as $key => $def) {
                $this->Add(
                    new pdoMap_Core_Config_Connection($key, $def)
                );
            }
        }
        /**
         * Adds a new connection
         * @params pdoMap_Core_Config_Connection connection configuration         
         */                 
        public function Add(pdoMap_Core_Config_Connection $connection) {
            $this->connections[$connection->getKey()] = $connection;        
        }
        /**
         * Remove a connection
         * @returns boolean true is connections was remove or false if was not defined
         */                 
        public function Remove($key) {
            if (isset($this->connections[$key])) {
                unset($this->connections[$key]);
                return true;            
            } else return false;
        }
        /**
         * Get a connection from his key
         * @returns pdoMap_Core_Config_Connection
         */                 
        public function Get($key) {
            if (!isset($this->connections[$key])) {
                $this->Add(
                    new pdoMap_Core_Config_Connection(
                        '*', array()
                    )
                );
            }
            return $this->connections[$key];  
        }
        /**
         * Clear all connections
         */                 
        public function Clear() {
            $this->connections = array();
        }
        /**
         * Register with pdoMap all connections
         */                 
        public function Register() {
            foreach($this->connections as $cnx) {
                $cnx->Register();            
            }
        }  
        /**
         * Convert this object as an XML string
         */                 
        public function __toString() {
            $ret = "\n\t".'<connections>';
            foreach($this->connections as $cnx) $ret .= $cnx->__toString();
            $ret .= "\n\t".'</connections>';
            return $ret;
        }         
    }