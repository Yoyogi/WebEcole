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
     * The database config wrapper
     */          
    class pdoMap_Core_Config_DatabaseAdapter {
        /**
         * @var string the adapter name
         */                 
        protected $name;
        /**
         * @var boolean adapter status
         */                 
        protected $enabled = true;
        /**
         * @var array check constraints
         */                 
        protected $check = array();        
        /**
         * Initialize an adapter configuration
         */                 
        public function __construct($name, $data) {
            $this->name = $name;
            if (isset($data['enabled'])) {
                $this->enabled = $data['enabled'];
            }
            if (isset($data['check'])) {
                $this->check = $data['check'];            
            }
        }        
        /**
         * Get the adapter name
         */
        public function getName() {
            return $this->name;
        }  
        /**
         * Get the enabled state
         */                 
        public function getEnabled() {
            return $this->enabled;
        }
        /**
         * Check if this adapter can be used for defined type
         * @params string database type        
         */                            
        public function CheckType($type) {
            if (!$this->enabled) return false;
            $isOk = false;
            // compare database types : OR
            foreach($this->check['type'] as $check) {
                if ($check == $type) {
                    $isOk = true;
                    break;
                }
            }
            if (!$isOk) return false;
            // check loaded extensions : AND
            foreach($this->check['module'] as $check) {
                if (!extension_loaded($check)) {
                    $isOk = false;
                    break;
                }
            }
            if (!$isOk) return false;
            // check defined functions : AND
            foreach($this->check['function'] as $check) {
                if (!function_exists($check)) {
                    $isOk = false;
                    break;
                }
            }                    
            if (!$isOk) return false;
            // check defined classes
            foreach($this->check['class'] as $check) {
                if (!class_exists($check)) {
                    return false;
                }
            } 
            return true;           
        }    
    }