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
     * @subpackage     Database::Fields
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * Handles integer fields
     * @tested
     */         
    class pdoMap_Database_Fields_Integer 
       implements
           pdoMap_Database_IField        
    {
        /**
         * @const string Defines the default size (when not defined)
         */                  
        const DEFAULT_SIZE = 'normal';
        /**
         * @const string Defines all possible values
         */                 
        public static $SIZE_LIST = array('tiny', 'small', 'medium', 'normal', 'big');
        /**
         * Get database field definition
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @returns array of pdoMap_Dao_Metadata_Field  
         * @throw pdoMap_Database_Fields_Exceptions_BadType                            
         */                 
        public function getMeta(            
            pdoMap_Dao_Metadata_Field $field
        ) {
            if ($field->type != 'Integer') {
                throw new pdoMap_Database_Fields_Exceptions_BadType(
                    $field->bind, $field->type, 'Integer'
                );
            }
            if (!$field->getOption('size')) {
                $field->setOption('size', self::DEFAULT_SIZE);
            }
            if (!in_array($field->getOption('size'), self::$SIZE_LIST)) {
                throw new pdoMap_Database_Fields_Exceptions_BadOption(
                    $field->bind, $field->type, 'size'
                );
            }
            return array(
                pdoMap_Dao_Metadata_Field::duplicate(
                    $field,
                    pdoMap_Dao_Metadata_Field::FIELD_TYPE_INT
                )
            );
        }
        /**
         * Get a value
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle                
         * @returns integer               
         */                 
        public function getter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        ) {
            return $value;
        }
        /**
         * Set a value
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle       
         * @returns integer
         * @throw pdoMap_Dao_Exceptions_EntityValidateType                                
         */         
        public function setter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        ) {
            if (is_numeric($value)) {
                return $value;        
            } else {
                throw new pdoMap_Database_Fields_Exceptions_BadValue(
                    $field, $value
                );
            }
        }
        /**
         * Validate a value 
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle                      
         * @returns boolean True if value is valid or false if not         
         */                
        public function Validate(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        ) {
            // CHECK TYPE
            if (!is_numeric($value) || (int)$value != $value) return false;
            // CHECK SIZE
            switch($field->getOption('size')) {
                case 'tiny':
                    $max = 255;
                    break;
                case 'small':
                    $max = 65535;
                    break;
                case 'medium':
                    $max = 16777215;
                    break;
                case 'normal':
                    $max = 4294967295;                        
                case 'big':
                    $max = mt_getrandmax(); // biggest value : 18446744073709551615;
                    break;
            }
            if ($field->GetOption('unsigned') != 'true') {
                $min = -$max - 1;
                $max = ($max - 1) / 2;
            } else {
                $min = 0;
            }
            return ($value >= $min && $value <= $max);      
        }           
        /**
         * Prepare the request set 
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params pdoMap_Database_Request_Adapters_ISetter Request setter                    
         */
        public function PrepareRequestSetter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            pdoMap_Database_Request_Adapters_ISetter $setter        
        ) {
            $setter->Set(
                $field->bind, 
                $entity->__get($field->bind)
            );
        }                
    }