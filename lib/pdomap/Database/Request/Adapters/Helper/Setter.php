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
     * Setter helper class
     */
    class pdoMap_Database_Request_Adapters_Helper_Setter 
    {
        protected $scope;
        /**
         * Define a set value
         */                 
        public function Set($field, $value) {
            $this->scope->args['fields'][$field] = $this->scope->escapeValue(
                $value
            ); 
            return $this->scope;
        }
        /**
         * Define a set with a SQL formula
         */                  
        public function SetFormula($field, $value) {
            $this->scope->args['fields'][$field] = $this->parseFormula($value); 
            return $this->scope;
        }
        /**
         * Get the registered values
         */                 
        public function Values($values) {
            $this->scope->args['fields'] = $values; 
            return $this->scope;
        }   
        /**
         * Parse the formula
         */                 
        protected function parseFormula($formula) {
            $ret = '';
            $isField = false;
            $field = '';
            for($i = 0; $i < strlen($formula); $i++) {
                $char = substr($formula, $i, 1);
                if ($isField) {
                    if ($char == '}') {
                        $isField = false;
                        $field = explode('.', $field, 2);
                        if (sizeof($field) == 2) {
                            $ret .= $this->scope->escapeEntity($field[1], $field[0]);                        
                        } else {
                            $ret .= $this->scope->escapeEntity($field[0]);
                        }
                    } else {
                        $field .= $char;
                    }
                } else {
                    if ($char == '{') {
                        $isField = true;
                        $field = '';
                    } else {
                        $ret .= $char;
                    }
                }
            }
            return $ret;
        }
    }