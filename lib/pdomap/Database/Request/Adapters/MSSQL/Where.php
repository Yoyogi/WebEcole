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
     * @subpackage     Database::Adapters::MSSQL
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /** 
     * MSSQL where class 
     */
    abstract class pdoMap_Database_Request_Adapters_MSSQL_Where 
        extends 
            pdoMap_Database_Request_Adapters_MSSQL_State 
        implements 
            pdoMap_Database_Request_Adapters_IWhere 
    {
        private $helper;
        private function helper() {
            if (!$this->helper) {
                $this->helper = 
                    new pdoMap_Database_Request_Adapters_Helper_Where(
                        $this
                    );
            }
            return $this->helper;
        }
        public function Join($table, $field, $target, $pk) {
            return $this->helper()->Join($table, $field, $target, $pk); 
        }
        public function OpenSub($operator) {
            return $this->helper()->OpenSub($operator);
        }
        public function CloseSub() { 
            return $this->helper()->CloseSub();
        }
        public function Cond($field, $operator, $value, $table = null) {
            return $this->helper()->Cond($field, $operator, $value, $table);
        }
    }