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
     * @subpackage     Cache::Adapters
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Cache Manager with file storage 
     * @tested     
     */         
    class pdoMap_Cache_Adapters_File implements pdoMap_Cache_IAdapter {
        public $key = 'pdoMap-tmp-';
        private $hash;
        private $buffer;
        /**
         * Save a file data
         * @throws pdoMap_Cache_Exceptions_Write    
         * @returns int number of written bytes         
         */                 
        public static function file_store($key, $value) {
            $file = self::sanitizeFileName($key);
            $ok = file_put_contents($file, serialize($value));
            if ($ok === false) {
                throw new pdoMap_Cache_Exceptions_Write($key);
            } else return $ok;
        }
        /**
         * Reads a key entry
         * @throws pdoMap_Cache_Exceptions_KeyNotFound
         * @throws pdoMap_Cache_Exceptions_Read              
         */                 
        public static function file_fetch($key) {
            $file = self::sanitizeFileName($key);
            if ($buffer = @file_get_contents($file)) {
               $ret = @unserialize($buffer);
                if ($ret === false) {
                    throw new pdoMap_Cache_Exceptions_Read($key);
                } else return $ret;
            } else {
                throw new pdoMap_Cache_Exceptions_KeyNotFound($key);
            }
        }
        /**
         * Delete a cached file entry
         */                 
        public static function file_delete($key) { 
            return @unlink(self::sanitizeFileName($key));
        }
        /**
         * Escape special chars from key name
         */                 
        public static function sanitizeFileName($key) {
            return pdoMap::$cachePath
                .str_replace(
                    array(
                        '!', '?', '/', '\\', '+', ' ', '.', ':', '\'', '\"', '#'
                    ), 
                    '_', $key
                ).'.tmp';
        }
        /**
         * Open the file manager session
         */                 
        public function openSession() {
            if (!is_dir(pdoMap::$cachePath)) {
                mkdir(pdoMap::$cachePath);
            }
            try {
                $this->hash = self::file_fetch($this->key.'hash');            
            } catch(Exception $ex) {
                $this->hash = array();            
            }
            $this->buffer = array();
        }
        /**
         * Close the file manager session
         */                 
        public function closeSession() {
            self::file_store($this->key.'hash', $this->hash);            
        }
        /**
         * Verify a key entry
         */                 
        public function check($key, $timeout = 0) {
            if (!$timeout) {
                return isset($this->hash[$key]);            
            } else {
                if (isset($this->hash[$key])) {
                    return ($this->hash[$key] + $timeout > time());
                } else return false;        
            }
        }
        /**
         * Set a key entry
         */                 
        public function set($key, $value) {
            $this->hash[$key] = time();
            $this->buffer[$key] = $value;
            self::file_store($this->key.$key, $value);
        }
        /**
         * Get a key entry
         */                 
        public function get($key) {
            if (!isset($this->buffer[$key])) {
                $this->buffer[$key] = self::file_fetch($this->key.$key);
            }
            return $this->buffer[$key];
        }
        /**
         * Remove a key entry
         */                 
        public function remove($key) {
            if (isset($this->hash[$key])) {
                unset($this->hash[$key]);
                unset($this->buffer[$key]);
                return self::file_delete($this->key.$key);
            } else throw new pdoMap_Cache_Exceptions_KeyNotFound($key);
        }
        /**
         * Clear all keys
         */                 
        public function clear() {
            foreach($this->hash as $key => $time) $this->remove($key);
            $this->hash = array();
            $this->buffer = array();
        }
    }