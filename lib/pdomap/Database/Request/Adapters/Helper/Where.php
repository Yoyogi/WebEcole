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
     * Base where class 
     */
    class pdoMap_Database_Request_Adapters_Helper_Where 
    {
        protected $scope;
        public function __construct(
            pdoMap_Database_Request_Adapters_IWhere $scope
        ) { $this->scope = $scope; }
        public function Join($table, $field, $target, $pk) {
            $this->scope->args['join'][$target] = array(
                $table, $field, $target, $pk
            ); 
            if (!in_array($table, $this->scope->table)) 
                $this->scope->table[] = $table;
            if (!in_array($target, $this->scope->table)) 
                $this->scope->table[] = $target;
            return $this->scope;
        }
        public function OpenSub($operator) {
            $this->scope->op[] = $operator;
            $this->scope->args['cond'][] = '('; 
            return $this->scope;
        }
        public function CloseSub() {
            array_pop($this->scope->op);
            $this->scope->args['cond'][] = ')'; 
            return $this->scope;
        }
        public function Cond($field, $operator, $value, $table = null) {
            $this->scope->args['cond'][] = array(
                $field, $operator, $value, $table
            ); 
            $this->scope->args['cond'][] = $this->scope->op[
                sizeof($this->scope->op) - 1
            ];
            return $this->scope;
        }
    }