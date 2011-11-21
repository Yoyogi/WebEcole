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
     * Parse a adapter tag
     */
    class pdoMap_Parsing_Mapping_Entity
        extends 
            pdoMap_Parsing_Mapping_Node 
    {
        /**
         * Get the entity name
         */                 
        public function getClassName() {
            if (isset($this->class)) {
                return $this->class;
            } else return $this->getGenClassName();
        }
        /**
         * Get the generated class name
         */                 
        public function getGenClassName() {
            if (isset($this->generate_as)) {
                return $this->generate_as;
            } else {
                return ucfirst($this->getParent()->name).'EntityImpl';
            }        
        }
        /**
         * Get a list of fields
         */                 
        public function getProperties() {
            return $this->properties->getChilds();
        }
        /**
         * Get the class to extend
         */                 
        public function getExtends() {
            return 'pdoMap_Dao_Entity';
        }
        /**
         * Write each property
         */                 
        public function GenerateProperties() {
            foreach($this->getProperties() as $pos => $prop) {    
                if (!$prop->type) {
                    $prop->type = str_replace('-', '', $prop->getName());
                }
                if (!isset($prop->name)) {
                    throw new Exception(
                        'The property ('
                        .$prop->getName()
                        .') n#'
                        .$pos                        
                        .' must contains at least a name attribute !'
                    );
                }                
                if (!isset($prop->type)) {
                    throw new Exception(
                        'The property ('
                        .$prop->getName()
                        .') n#'
                        .$pos
                        .' must contain a type attribute !'
                    );
                }                
                if (!isset($prop->column)) $prop->column = $prop->name;
                $this->writeLine(
                    '$return->fields[\''
                    .$prop->name
                    .'\'] = new pdoMap_Dao_Metadata_Field('
                );
                $this->writeLine('\''.$prop->column.'\',');
                $this->writeLine('\''.$prop->name.'\',');
                $this->writeLine('\''.ucfirst(strtolower($prop->type)).'\','); 
                $props = $prop->getProperties();
                unset($props['name']); 
                unset($props['column']);    
                unset($props['type']);
                if (isset($props['formula'])) {
                    unset($props['formula']);
                }
                if (strtolower($prop->type) == 'onetomany') {
                    if (isset($props['one']))
                        $props['one'] = $prop->one->getProperties();
                    if (isset($props['many'])) {
                        $props['many'] = $prop->many[0]->getProperties();
                    }
                }     
                if (strtolower($prop->type) == 'manytomany') {
                    $props['many'] = array();
                    foreach($prop->many as $many)
                        $props['many'] = $many->getProperties();
                }                  
                $this->writeLine(var_export($props, true));
                $this->writeLine(');');
            }        
        }
        /**
         * Generate the entity code
         */                 
        public function Generate() {
            $this->writeLine(
                'class '
                .$this->getGenClassName()
                .' extends '
                .$this->getExtends()
                .'  {'
            );
            $this->writeLine(
                    'public function __construct($values = null) {'
            );
            $this->writeLine(
                        'parent::__construct(\''
                            .$this->getParent()->name
                            .'\', $values);'
            );
            $this->writeLine('}');    
            $this->GenerateFormulas();
            if (isset($this->select)) 
                foreach($this->select as $rq) 
                    $rq->toPhp(false);
            if (isset($this->select_one)) 
                foreach($this->select_one as $rq) 
                    $rq->toPhp(false);
            if (isset($this->update)) 
                foreach($this->update as $rq) 
                    $rq->toPhp(false);
            if (isset($this->insert)) 
                foreach($this->insert as $rq) 
                    $rq->toPhp(false);
            if (isset($this->delete)) 
                foreach($this->delete as $rq) 
                    $rq->toPhp(false);
            $this->writeLine('}');            
        }
        /**
         * Writing code for automatically calculated formulas 
         */                 
        public function GenerateFormulas() {
            if (isset($this->properties->property)) {
                foreach($this->properties->property as $property) {    
                    $property->GenerateFormula();
                }                    
            }
        }
    }