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
     * @subpackage     Database::Request
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /**
     * ORDER BY ASC
     */
    define('ASC', 0);
    /**
     * ORDER BY DESC
     */         
    define('DESC', 1);
    /**
     * Request Builder manager
     */         
    class pdoMap_Database_Request_Manager {
        /**
         * Registers request managers by type
         */                 
        private $managers = array();
        /**
         * Get a typed request manager
         * @returns pdoMap_Database_Reques_Adapters_IBuilder         
         */                 
        public function get($type) {
            return $this->manager(pdoMap::structure($type)->db)->type($type);
        }
        /**
         * Get a database structure builder
         */                 
        public function structure($database = '*') {
            return $this->manager($database)->Structure();
        }
        /**
         * Get a database manager
         * @returns pdoMap_Database_Reques_Adapters_IBuilder         
         */                 
        public function manager($database) {
            if (!isset($this->managers[$database])) {
                $type = pdoMap::database()->getType($database);
                $name = pdoMap::config()
                            ->getDatabase()
                            ->FindAdapterNameByType($type);
                $manager = 'pdoMap_Database_Request_Adapters_'.$name.'_Builder';
                $this->register($database, new $manager($database));
            }
            return $this->managers[$database];        
        }        
        /**
         * Register a request builder
         * @params string database key
         * @params pdoMap_Database_Reques_Adapters_IBuilder         
         */                 
        public function register($db, &$manager) {
            $this->managers[$db] = $manager;
        }
    }