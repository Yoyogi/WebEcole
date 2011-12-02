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
     * @subpackage     Parsing::Mapping
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Parse a request tag
     */
    class pdoMap_Parsing_Mapping_Do extends pdoMap_Parsing_Mapping_Script {
        /**
         * Convert tag to PHP code
         */                 
        public function toPhp($onAdapter = false) {
            parent::toPhp($onAdapter);
            // Handle type            
            switch($this->type) {
                case 'call':
                    $this->handleCall();
                    break;
                case 'return':
                    $this->getReturn($this); 
                    break;
                case 'check':
                    $this->handleCheck();
                    break;
                case 'select':
                    $this->handleRequest();
                    break;
                case 'select-one':
                    $this->handleRequest();
                    break;
                case 'update':
                    $this->handleRequest();
                    break;
                case 'insert':
                    $this->handleRequest();
                    break;
                case 'delete':
                    $this->handleRequest();
                    break;
                default:
                    throw new Exception('Unknown do statement with type = \''.$this->type.'\' !');
                    break;
            }
        }
        /**
         * Handle do type = "call"
         */                 
        public function handleCall() {
            $code = '';
            if ($this->assign) $code .= $this->parseEntity($this->assign).' = ';
            if (substr($this->method, 0, 5) == 'this.') {
               $code .= '$'.str_replace('.', '->', $this->method).'(';                    
            } else {
               $code .= $this->adapterLink.'->'.$this->method.'(';                    
            }
            if (isset($this->params) && isset($this->params->param)) {
                foreach($this->params->param as $p) {
                    if (isset($p->name)) {
                        $code .= $this->parseEntity($p->name);
                    } else {
                        $code .= $this->getFieldValue($p->value);
                    }
                    $code .= ', ';
                }
                $code = rtrim($code, ', ');
            }
            $code .= ');';
            if (isset($this->return)) {
               $this->writeLine($this->parseEntity($this->return).' = ');                     
            }
            $this->writeLine($code);        
        }
        /**
         * Handle do type="insert/select/update/delete"
         */                 
        public function handleRequest() {
            if (!$this->isEntityRequest()) {
               $this->writeLine($this->rqManager);
            }
            $this->buildRequest();
            if (!$this->isEntityRequest()) {
                if ($this->type == 'select-one') {
                    $this->writeLine('->Run()->current();');                    
                } else {
                    $this->writeLine('->Run();');                    
                }
            }        
        }
        /**
         * Handle do type="check" tag ...
         */                 
        public function handleCheck() {
            if ($this->haveTrue()) {
                $this->writeLine('if ('.$this->getIfCond().') {');
                if ($this->true->do) {
                    foreach($this->true->do as $do) $do->toPhp($this->onAdapter);
                }
                if ($this->true->return) $this->getReturn($this->true->return);                    
            } else {
                $this->writeLine('if (!'.$this->getIfCond().') {');                    
            }
            if ($this->false) {
                if ($this->haveTrue())
                   $this->writeLine('} else {');
                if ($this->false->do) {
                    foreach($this->false->do as $do) $do->toPhp($onAdapter);
                }
                if ($this->false->return) $this->getReturn($this->false->return);
            }
            $this->writeLine('}');        
        }
        /**
         * Verify if true was set
         */                 
        public function haveTrue() {
            if (isset($this->true)) {
                return (isset($this->true->do) || isset($this->true->return));
            } else return false;
        }
        /**
         * Generate if condition
         */                 
        public function getIfCond() {
            $ret = '('.$this->parseEntity($this->param);
            $cond = $this->readCondition($this);
            if (!empty($cond[0])) {
                if ($cond[0] == '=') $cond[0] = '==';
                if ($cond[0] == '<>') $cond[0] = '!=';
                $ret .= ' '.$cond[0].' '.$cond[1];
            }
            return $ret.')';    
        }
        /**
         * Execute the entity request
         */                 
        public function handleEntityRequest($code) {
            $this->writeLine($code);
        }        
        /**
         * Build a return tag
         */                 
        public function getReturn($return) {
            if ($return->param) {
                $this->writeLine('return $'.$return->param.';');
            } elseif($return->value) {
                $this->writeLine('return '.$return->value.';');            
            } elseif($return->string) {
                $this->writeLine('return \''.addslashes($return->string).'\';');            
            } else {
                $this->writeLine('return;');
            }
        }
    }
