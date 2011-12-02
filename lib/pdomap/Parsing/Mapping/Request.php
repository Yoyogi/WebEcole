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
    class pdoMap_Parsing_Mapping_Request 
        extends 
            pdoMap_Parsing_Mapping_Script 
    {
        /**
         * Convert tag to PHP code
         */                 
        public function toPhp($onAdapter = false) {
            parent::toPhp($onAdapter);
            /**
             * GENERATE REQUEST
             */                         
            if (!$this->isEntityRequest()) {
                $this->writeSignature(false, 'get');
                $this->writeLine('return '.$this->rqManager);
                $this->buildRequest();
                $this->writeLine(';');
                $this->writeLine('}');            
            } 
            /**
             * EXECUTE FUNCTION
             */                         
            $this->writeSignature();
            // START RETURN
            if (!$this->isEntityRequest()) {
                if ($this->type == 'select-one') {
                    $this->writeLine('$ret = $this->get'.$this->name.'(');
                } else {
                    $this->writeLine('return $this->get'.$this->name.'(');
                }               
                $this->writeLine($this->getParams(false).')->Run();');
                if ($this->type == 'select-one') {
                    $this->writeLine('if ($ret && sizeof($ret) == 1) {');
                    $this->writeLine('return $ret->current();');
                    $this->writeLine('} else {');
                    $this->writeLine('return null;');
                    $this->writeLine('}');
                }            

            } else {
                $this->buildRequest();        
            }
            $this->writeLine('}');
        }
    }