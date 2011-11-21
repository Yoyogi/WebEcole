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
     * Configuration Reader
     * Loads a table XML mapping and generate associated class      
     */
    class pdoMap_Parsing_Mapping_Document 
        extends 
            pdoMap_Core_XML_Document 
    {
        private $f;
        public $tab = 0;
        public $mappingKey;
        public $mappingData = array();
        /** Define restricted function names **/
        public $unauthFuncNames = array(
                'extends', 'class', 'function', 'var', 'return',
                'echo', 'if', 'switch', 'do', 'while', 'implements',
                'select', 'insert', 'update', 'delete', 'create',
                'validate', 'getstructure', 'getrequest', 'get', 'set', 
                'selectentity', 'deleteentity'        
        );
        /**
         * Loads and read a xml mapping file
         */                 
        public function __construct($file) {
            $this->hasMany(
                array(
                    'property', 'foreign', 'one_to_many', 'many_to_many', 
                    'many', 'select', 'insert', 'update', 'delete', 
                    'select_one', 'transaction', 
                    'param', 'cond', 'order', 'join', 'and', 'or', 
                    'do', 'collection', 'value', 'adapter', 'set'
                )
            );
            $this->mapTag('adapter',     'pdoMap_Parsing_Mapping_Adapter');
            $this->mapTag('entity',      'pdoMap_Parsing_Mapping_Entity');
            $this->mapTag('property',    'pdoMap_Parsing_Mapping_Property');
            $this->mapTag('transaction', 'pdoMap_Parsing_Mapping_Transaction');
            $this->mapTag('select',      'pdoMap_Parsing_Mapping_Request_Select');
            $this->mapTag('select-one',  'pdoMap_Parsing_Mapping_Request_SelectOne');
            $this->mapTag('update',      'pdoMap_Parsing_Mapping_Request_Update');
            $this->mapTag('insert',      'pdoMap_Parsing_Mapping_Request_Insert');
            $this->mapTag('delete',      'pdoMap_Parsing_Mapping_Request_Delete');
            $this->mapTag('do',          'pdoMap_Parsing_Mapping_Do');
            $this->mapTag('collection',  'pdoMap_Parsing_Mapping_Collection');
            parent::__construct(
                $file,
                pdoMap::$rootPath.'Parsing/Mapping/Structure.xsd'    
            );
        }
        /**
         * Start writing to a file
         */                 
        public function open($file) {   
            $this->close();
            $this->f = fopen($file, 'w+');
            $this->tab = 0;
            if (!$this->f) 
                throw new pdoMap_Parsing_Mapping_Exceptions_Write($file);
        }
        /**
         * Close file
         */          
        public function close() {
            if ($this->f) {
                fclose($this->f);   
                $this->f = null; 
            }    
        }        
        /**
         * Write a line to open file
         * @params string data to write
         */                 
        public function writeLine($data) {
            if (substr($data, 0, 1) == '}') $this->tab -= 1;
            if (substr($data, 0, 2) == '->') 
                $this->writeData(str_repeat("\t", 6));
            $this->writeData(str_repeat("\t", $this->tab).$data."\n");
            if (substr($data, -1) == '{') $this->tab += 1;
        }
        /**
         * Write data to open file
         * @params string data to write
         */                 
        public function writeData($data) {
            if ($this->f) {
                fputs($this->f, $data);
            } else {
                throw new pdoMap_Parsing_Mapping_Exceptions_Write('not already opened');            
            }
        }
        /**
         * Retrieve an adapter from his name
         */                 
        public function getAdapterByName($name) {
            foreach($this->adapter as $adapter) {
                if ($adapter->name == $name) {
                    return $adapter;
                }
            }
            throw new pdoMap_Parsing_Mapping_Exceptions_AdapterNotFound(
                $name, $this->__file
            );
        }
        /**
         * Get the current generating adapter instance
         */                 
        public function getCurrentAdapter() {
            return $this->getAdapterByName($this->mappingKey);
        }
        /**
         * Generate php mapping class 
         * @throw pdoMap_Parsing_Mapping_Exceptions_Field         
         */                 
        public function Generate($file, $ns) {
            $this->mappingKey = $ns;
            $ns = ucfirst($ns); // Camelstyle
            /**
             * Defining the adapter class
             */                         
            $this->open($file.'.class.php');
            $this->writeLine('<?php // GEN '.$ns.' AT '.date('Y-m-d H:i:s'));
            $this->getCurrentAdapter()->GenerateInterface();
            $this->getCurrentAdapter()->GenerateAdapter();                   
            $this->getCurrentAdapter()->GenerateEntity();                               
            /**
             * Generating Structure Manager
             */                                 
            $this->open($file.'.structure.php');
            $this->writeLine('<?php // GEN '.$ns.' AT '.date('Y-m-d H:i:s'));
            $this->getCurrentAdapter()->GenerateStructure();              
            $this->close();            
            /**
             * Check the mapping structure
             */             
            $structure = include($file.'.structure.php');
            foreach($structure->fields as $bind => $field) {
                try {
                    pdoMap::field()->getMeta($field);   // TEST FIELD META
                } catch(Exception $ex) {
                    @unlink($file.'.structure.php');
                    @unlink($file.'.class.php');
                    throw new pdoMap_Parsing_Mapping_Exceptions_Field(
                        $ex, $this->__file, $field->bind
                    );
                }
            }
            return $structure;
        }        
        /**
         * Generate a xml file from structure
         * @todo update with new syntax         
         */                 
        public static function map(IRequestTable $table, $path) {
            $filename = pdoMap::$mappingPath.$table->getName().'.map.xml';
            $f = fopen($filename, 'w+');
            if (!$f) 
                throw new pdoMap_Parsing_Mapping_Exceptions_Write(
                    $filename
                );
            fputs($f, '<?xml version="1.0"?'.'>'."\n");
            fputs($f, 
                '<table name="'
                    .$table->getName()
                    .'" use="'
                    .$table->getDatabase().'">'."\n"
            );
            fputs($f, 
                '<!-- GENERATED BY PDOMAP AT '
                    .date('Y-m-d H:i:s')
                .' -->'."\n"
            );            
            fputs($f, "\t".'<fields>'."\n");
            foreach($table->getFields() as $field) {
                fputs($f, "\t\t".'<field ');
                fputs($f, "\n\t\t\t".'bind="'.$field->getBind().'"');
                fputs($f, "\n\t\t\t".'type="'.$field->getType().'"');
                fputs($f, "\n\t\t\t".'size="'.$field->getSize().'"');
                fputs($f, "\n\t\t\t".'name="'.$field->getName().'"');
                fputs($f, ' />'."\n");                
            }
            fputs($f, "\t".'</fields>'."\n");            
            fputs($f, '</table>'."\n");
            fclose($f);            
        }
    } 