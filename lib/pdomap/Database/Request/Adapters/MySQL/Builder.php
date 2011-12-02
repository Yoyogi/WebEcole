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
     * @subpackage     Database::Adapters::MySQL
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Defines a mysql request builder
     */     
    class pdoMap_Database_Request_Adapters_MySQL_Builder 
        implements pdoMap_Database_Request_Adapters_IBuilder 
    {
        private $database;
        private $type;
        public function __construct($database = null, $type = null) {
            $this->database = $database;
            $this->type = $type;
        }
        public function build($database) {
            return new pdoMap_Database_Request_Adapters_MySQL_Builder($database);
        }
        public function type($type) {
            return new pdoMap_Database_Request_Adapters_MySQL_Builder($this->database, $type);
        }        
        public function getType() {
            return $this->type;
        }
           public function Select() {
            return new pdoMap_Database_Request_Adapters_MySQL_Select($this->database, $this->type);
        }
        public function Insert() {
            return new pdoMap_Database_Request_Adapters_MySQL_Insert($this->database, $this->type);
        }
        public function Update() {
            return new pdoMap_Database_Request_Adapters_MySQL_Update($this->database, $this->type);
        }
        public function Delete() {
            return new pdoMap_Database_Request_Adapters_MySQL_Delete($this->database, $this->type);
        }
        public function Structure() {
            return new pdoMap_Database_Request_Adapters_MySQL_Structure($this->database);
        }
        public static function escapeTable($name, $db = '*') { 
            return self::escapeEntity(
                    pdoMap::database()->getName($db)
                ).'.'.self::escapeEntity(
                    pdoMap::database()->getPrefix($db).$name
                ); 
        }
        public static function escapeEntity($name, $table = null) { 
            if ($table) {
                $db = pdoMap::structure($table)->db;
                $table = pdoMap::database()->getPrefix($db).pdoMap::structure($table)->name;
                return '`'.$table.'`.`'.$name.'`'; 
            } else {
                return '`'.$name.'`'; 
            }
        }
        public static function escapeValue($value) { 
            if (is_null($value)) return 'null';
            if (is_numeric($value)) return $value;
            return '\''.addslashes($value).'\''; 
        }
    }