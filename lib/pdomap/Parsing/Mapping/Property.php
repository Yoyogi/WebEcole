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
     * Parse a mapping property tag
     */
    class pdoMap_Parsing_Mapping_Property
        extends 
            pdoMap_Parsing_Mapping_Node 
    {
        /**
         * Get the property name (in object)
         */                 
        public function getName() {
            return $this->name;
        }
        /**
         * Get the column name (in table)
         */                 
        public function getColumnName() {
            if (isset($this->column)) {
                return $this->column;
            } else {
                return $this->getName();
            }
        }
        /**
         * Write code for formula
         */                 
        public function GenerateFormula() {
            if (isset($this->formula)) {
                $formula = str_replace(
                    '{', '$this->', $this->formula
                );
                $formula = str_replace(
                    '}', '', $formula
                );
                $formula = str_replace(
                    '.', '->', $formula
                );
                $this->writeLine('/**');                    
                $this->writeLine(' * Calculated field getter '.$this->name);                    
                $this->writeLine(' * Formula : '.$this->formula);                    
                $this->writeLine(' */');                    
                $this->writeLine(
                    'public function getter'.$this->getName().'() {'
                );
                $this->writeLine('$this->setValue(\''.$this->getName().'\', '.$formula.');');
                $this->writeLine('return $this->getValue(\''.$this->getName().'\');');
                $this->writeLine('}');                              
            }
        }
        
    }