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
     * Field manager structure
     */         
    interface pdoMap_Database_IField {
        /**
         * Get database field definition
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @returns array of pdoMap_Dao_Metadata_Field                     
         */                 
        function getMeta(            
            pdoMap_Dao_Metadata_Field $field
        );
        /**
         * Get a value
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle                      
         */                 
        function getter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        );
        /**
         * Set a value
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle                      
         */         
        function setter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        );    
        /**
         * Validate a value 
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params mixed Value to handle                      
         */                
        function Validate(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            $value
        );     
        /**
         * Prepare the request set 
         * @params pdoMap_Dao_Entity Entity to handle
         * @params pdoMap_Dao_Metadata_Field Field to manage
         * @params pdoMap_Database_Request_Adapters_ISetter Request setter                    
         */
        function PrepareRequestSetter(
            pdoMap_Dao_Entity $entity, 
            pdoMap_Dao_Metadata_Field $field,
            pdoMap_Database_Request_Adapters_ISetter $setter        
        );                     
    }