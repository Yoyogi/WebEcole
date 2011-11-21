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
     * @subpackage     Dao
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /**
     * Defines a table field structure
     */
    class pdoMap_Dao_Metadata_Field {
        /**
         * Primary key (with autoinc)
         */
        const FIELD_TYPE_PK            = 'primary';
        const FIELD_TYPE_FK            = 'foreign';
        const FIELD_TYPE_INT         = 'integer';
        const FIELD_TYPE_FLOAT       = 'float';
        const FIELD_TYPE_TEXT        = 'text';
        const FIELD_TYPE_DATE        = 'date';
        const FIELD_TYPE_ENUM        = 'enum';
        /**
         * @var string Physical field name
         */
        public $name;
        /**
         * @var string Binded on property field name
         */
        public $bind;
        /**
         * @var int Field type name
         * @see defined constants FIELD_TYPE_*
         */
        public $type;
        /**
         * @var array Field properties
         */
        protected $options = array();
        /**
         * Default constructor
         */
        public function __construct($name, $bind, $type, $options) {
            $this->name = $name;
            $this->bind = $bind;
            $this->type = $type;
            $this->options = $options;
        }
        /**
         * Duplicate a field and change some information
         */                 
        public static function duplicate(
            pdoMap_Dao_Metadata_Field $field, 
            $type = null,
            $name = null,
            $bind = null,
            $options = null
        ) {
            $ret = new pdoMap_Dao_Metadata_Field(
                $field->name,
                $field->bind,
                $field->type,
                $field->getOptions()
            );
            if (!is_null($type)) {
                $ret->type = $type;
            }
            if (!is_null($name)) {
                $ret->name = $name;
            }
            if (!is_null($bind)) {
                $ret->bind = $bind;
            }
            if (!is_null($options)) {
                foreach($options as $key => $value) 
                    $ret->setOption($key, $value);
            }
            return $ret;
        }
        /**
         * Verify if field can be null
         */                 
        public function IsNull() {
            return ($this->getOption('null') == 'true');
        }
        /**
         * Get the default value
         */                 
        public function DefaultValue() {
            return $this->getOption('default');
        }
        /**
         * Deserialize from php code
         */                 
        public static function __set_state($data) {
            return new pdoMap_Dao_Metadata_Field(
                $data['name'],
                $data['bind'],
                $data['type'],
                $data['options']
            );
        }    
        /**
         * Get all options
         */               
        public function getOptions() {
            return $this->options;
        }      
        /**
         * Reads an option value
         */                 
        public function getOption($name, $default = null) {
            if (isset($this->options[$name])) {
                return $this->options[$name];
            } else return $default;
        }
        /**
         * Reads an option value
         */                 
        public function setOption($name, $value) {
            $this->options[$name] = $value;
        }
    }    