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
     * @subpackage     Core::Config
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * The adapter configuration wrapper
     */          
    class pdoMap_Core_Config_MappingAdapter {
        /**
         * @var pdoMap_Core_Config_Mapping instance of mapping wrapper
         */                 
        protected $parent;
        /**
         * @var string the mapping name / key used by pdoMap::get(key)
         */                 
        protected $name;
        /**
         * @var string the xml filename containing mapping definition
         */                 
        protected $meta;
        /**
         * List of php files
         */                 
        protected $requires = array();
        /**
         * Initialize a configuration for a mapping adapter
         * @params string adapter name
         * @params string xml meta file name
         * @params array required php files array                  
         */                 
        public function __construct($name, $meta, $requires = array()) {
            $this->name = $name;
            $this->meta = $meta;
            $this->requires = $requires;
        }
        /**
         * Include requires list 
         * @throw pdoMap_Exceptions_MappingNotFound               
         */                 
        public function RunRequires() {
            $root = dirname($this->getMetaAbsolutePath());
            if (substr($root, -1) != '/') $root .= '/';
            foreach($this->requires as $file) {
                if (file_exists($root.$file)) {
                    require_once($root.$file);
                } else 
                    throw new pdoMap_Exceptions_MappingNotFound(
                        $type, $root.$file
                    );
            }
        } 
        /**
         * (WriteOnly) Set the mapping configuration wrapper
         */                 
        public function setParent(pdoMap_Core_Config_Mapping $parent) {
            $this->parent = $parent;
        }
        /**
         * (ReadOnly) Get the adapter name
         * @see pdoMap::get         
         */                 
        public function getName() {
            return $this->name;
        }
        /**
         * Get the meta file name
         */                 
        public function getMeta() {
            if ($this->meta) {
                return $this->meta;
            } else {
                return $this->name.'.map.xml'; // auto generated from name
            }
        }
        /**
         * Get the full path to the meta file
         * @see getMeta         
         */                 
        public function getMetaAbsolutePath() {
            return $this->parent->getAbsolutePath().$this->getMeta();
        }
        /**
         * Define the xml meta filename
         */                 
        public function setMeta($file) {
            $this->meta = $file;
        }
        /**
         * Get the requires files list
         */                 
        public function getRequires() {
            return $this->requires;
        }
        /**
         * Set the requires array
         */                 
        public function setRequires($files) {
            $this->requires = $files;
        }
        /**
         * Add a require file
         */                 
        public function addRequire($file) {
            if (!in_array($file, $this->requires)) {
                $this->requires[] = $file;
                return true;
            } else return false;
        }
        /**
         * Convert this object as an XML string
         */                 
        public function __toString() {
            $ret = "\n\t\t".'<adapter name="'.$this->name.'" meta="'.$this->meta.'"';
            if (sizeof($this->requires) > 0) {
                foreach($this->requires as $file) {
                    $ret .= "\n\t\t\t".'<require>'.$file.'</require>';
                }
                $ret .= "\n\t\t".'</adapter>';
            } else $ret .= ' />';
            return $ret;
        }
    }