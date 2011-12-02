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
     * @subpackage     Database::Adapters::Helper
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Main request class
     */
    abstract class pdoMap_Database_Request_Adapters_Helper_State 
        implements 
            pdoMap_Database_Request_Adapters_IState 
    {
        public $table = array();
        public $database;
        public $mode;
        public $args = array();
        public $op = array('and');
        
        abstract function escapeObject($name);
        abstract function escapeEntity($key, $table = null);
        abstract function escapeTable($name);
        abstract function escapeValue($value);
        
        public function Table() { return $this->table; }
        public function Run() { 
            if ($this->mode == 'select') {
                return pdoMap::database()->RequestArray(
                    $this->database, 
                    $this->Request(), 
                    $this->table[0]
                ); 
            } else {            
                if ($this->mode == 'insert') {
                    $ret = pdoMap::database()->Request($this->database, $this->Request()); 
                    if ($ret) {
                        return pdoMap::database()->getPdo($this->database)->lastInsertId();
                    } else return false;
                } else {
                    return pdoMap::database()->Request($this->database, $this->Request()); 
                } 
            }
        }
        public function Request() {
            switch($this->mode) {
                case 'select':
                    $sql = 'SELECT '.implode(', ', $this->args['fields']);
                    $sql .= ' FROM '; // FROM
                    foreach($this->table as $t) 
                        $sql .= $this->escapeTable($t).', ';
                    $sql = rtrim($sql, ', ');
                    $sql .= $this->getWhere();            
                    // JOIN        
                    if (sizeof($this->args['join']) > 0) { 
                         if (sizeof($this->args['cond']) > 0) {
                            $sql .= ' AND (';
                        } else $sql .= ' WHERE (';
                        foreach($this->args['join'] as $join) {
                            $sql .= $this->escapeEntity(
                                        $join[1], 
                                        $join[0]
                                    )
                                    .' = '
                                    .$this->escapeEntity(
                                        $join[3], 
                                        $join[2]
                                    )
                                    .' AND ';
                        }
                        $sql = substr($sql, 0, strlen($sql) - 5).')';
                    }
                    $sql .= $this->getOrder();
                    $sql .= $this->getLimit();
                    break;
                case 'insert':
                    $sql = 'INSERT INTO '
                            .$this->escapeTable(
                                $this->table[0]
                            );
                    $f = ''; $v = '';
                    foreach($this->args['fields'] as $field => $value) {
                        $f .= $this->escapeEntity($field).', ';
                        $v .= $value.', ';
                    }
                    $sql .= ' ('.rtrim($f, ', ').') VALUES ('.rtrim($v, ', ').')';
                    break;
                case 'update':
                    $sql = 'UPDATE '
                            .$this->escapeTable(
                                $this->table[0]
                            )
                            .' SET ';
                    foreach($this->args['fields'] as $field => $value) {
                        $sql .= $this->escapeEntity(
                                    $field
                                )
                                .' = '
                                .$value
                                .', ';
                    }
                    $sql =  rtrim(
                                $sql, 
                                ', '
                            )
                            .$this->getWhere()
                            .$this->getLimit();
                    break;
                case 'delete':
                    $sql = 'DELETE FROM '
                            .$this->escapeTable(
                                $this->table[0]
                            )
                            .$this->getWhere()
                            .$this->getLimit();
                    break;
                default:
                    throw new Exception('Builder unknown mode '.$this->mode);
            }
            return $sql;
        }
        protected function getOrder() {
            if (sizeof($this->args['order']) > 0) { // ORDER BY
                $sql = ' ORDER BY ';
                foreach($this->args['order'] as $field => $conf) {
                    $table = $this->table[0];
                    if ($conf[1])
                        $table =  $conf[1];                                
                    $sql .= $this->escapeEntity($field, $conf[1]);
                    if ($conf[0] == 'desc') {
                        $sql .= ' DESC, ';
                    } else {
                        $sql .= ' ASC, ';
                    }
                }
                return rtrim($sql, ', ');
            }        
        }
        protected function getWhere() {
            if (sizeof($this->args['cond']) > 0) {
                $sql = ' WHERE';
                if (!is_array($this->args['cond'][sizeof($this->args['cond']) - 1])) {
                    array_pop($this->args['cond']);
                }
                foreach($this->args['cond'] as $c) {
                    if (is_array($c)) {
                        if (strtoupper($c[1]) == 'LIKE') {
                            $c[2] = str_replace(' ', '%', $c[2]);
                            $c[2] = str_replace('+', '%', $c[2]);
                        }
                        if (!isset($c[3])) $c[3] = $this->table[0];
                        $sql .= ' '.$this->escapeEntity($c[0], $c[3]).' '.$c[1].' '.$this->escapeValue($c[2]);
                    } else {
                        $sql .= ' '.$c;
                    }
                }
                return $sql;
            } else return null;
        }
        protected function getLimit() {
            if (sizeof($this->args['limit']) > 0) { // LIMIT
                $sql = ' LIMIT '.$this->args['limit'][0];
                if (isset($this->args['limit'][1])) $sql .= ', '.$this->args['limit'][1];
                return $sql;
            }    else return null;    
        }
    }     