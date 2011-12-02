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
     * Date and time implementation
     */         
    class pdoMap_Database_Fields_Date 
       implements
           pdoMap_Database_IField        
    {
        /**
         * Get database field definition
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @returns array of pdoMap_Dao_Metadata_Field                     
         */                 
        public function getMeta(            
            pdoMap_Dao_Metadata_Field $field
        ) {
            if ($field->type != 'Date') {
                throw new pdoMap_Database_Fields_Exceptions_BadType(
                    $field->bind, $field->type, 'Date'
                );                
            }         
            return array(
                pdoMap_Dao_Metadata_Field::duplicate(
                    $field,
                    pdoMap_Dao_Metadata_Field::FIELD_TYPE_DATE
                )
            );
        }
        /**
         * Get a value
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle                
         * @returns pdoMap_Utils_Date Date value    
         * @throw pdoMap_Database_Fields_Exceptions_BadValue                    
         */                 
        public function getter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        ) {
            if (!is_null($value)) {
                if (is_string($value)) {
                    $value = strtotime($value);
                    if (!$value) {
                        throw new pdoMap_Database_Fields_Exceptions_BadValue(
                            $field, $value
                        );
                    }
                }
                return new pdoMap_Utils_Date($value);
            }
        }
        /**
         * Set a value
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle       
         * @returns string         
         * @throw pdoMap_Dao_Exceptions_EntityValidateType                        
         */         
        public function setter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        ) {
            if (is_numeric($value) && $value > 0) {
                return $value;
            } elseif (is_string($value)) {
                $val = strtotime($value);
                if ($val !== false) return $val;
            } elseif ($value instanceof pdoMap_Utils_Date) {
                return $value->getTimeStamp();
            }
            throw new pdoMap_Database_Fields_Exceptions_BadValue(
                $field, $value
            );
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
            if (is_string($value)) {
                return (strtotime($value) > 0);
            } elseif(is_numeric($value)) {
                return ($value > 0);
            } elseif ($value instanceof pdoMap_Utils_Date) {
                return true;
            } else return false;
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
            $val = $entity->__get($field->bind);
            if (is_numeric($val) && $val > 0) {
                $setter->Set(
                    $field->bind, 
                    date('Y-m-d H:i:s', $val)
                );            
            } elseif (is_string($val)) {
                $setter->Set(
                    $field->bind,
                    $val
                );                        
            } else {
                $setter->Set(
                    $field->bind, 
                    null
                );
            }
        }           
    }