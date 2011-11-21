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
     * Select helper class 
     */
    class pdoMap_Database_Request_Adapters_Helper_Select 
    {
        private $scope;
        public function __construct($scope, $database, $name) {
            $this->scope = $scope;
            $this->scope->mode = 'select';
            $this->scope->database = $database;
            $this->scope->table[0] = $name;
            $this->scope->args = array(
                'join' => array(),
                'cond' => array(),
                'fields' => array(),
                'order' => array(),
                'limit' => array()
            );
            foreach(pdoMap::structure($name)->fields as $field) {
                $this->scope->args['fields'][] = $this->scope->escapeEntity(
                    $field->bind, $name
                ).' AS '.$this->scope->escapeObject($field->bind);
            }        
        }
        public function Where($op = 'and') { 
            $this->scope->op = array($op);
            return $this->scope; 
        }
        public function OrderBy($field, $direction = 0, $table = null) {
            $this->scope->args['order'][$field] = array($direction, $table);
            return $this->scope;
        }
        public function Limit($start = 0, $length = null) {
            $this->scope->args['limit'] = array($start, $length); 
            return $this->scope;
        }
        public function Count() {
            $l = $this->scope->args['limit']; 
            $f = $this->scope->args['fields'];
            $this->scope->args['fields'] = array('COUNT(*) AS NB');
            $this->scope->args['limit'] = array();
            $ret = pdoMap::database()->Request(
                $this->scope->database, 
                $this->scope->Request()
            ); 
            $ret = pdoMap::database()->Fetch($ret); 
            $this->scope->args['fields'] = $f;
            $this->scope->args['limit'] = $l;
            return $ret['NB'];
        }
    }