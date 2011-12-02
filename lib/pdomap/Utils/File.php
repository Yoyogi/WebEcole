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
     * @subpackage     Utils
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * File helper
     */         
    class pdoMap_Utils_File  {
        /**
         * @var string File name
         */                 
        private $name;
        /**
         * @var string File path
         */                 
        private $path;
        /**
         * @var string File type
         */                 
        private $type;        
        /**
         * @var string Date create
         */                 
        private $dateCreate;        
        /**
         * @var string Date update
         */                 
        private $dateUpdate;        
        /**
         * Initialize file helper
         * @params mixed Data       
         */                 
        public function __construct($data, $file = null) {
            // @todo
        }
        /**
         * Get the file full path
         */                 
        public function getFullPath() {
            return $this->path.'/'.$this->name;
        }
        /**
         * Verify if file exists
         */                 
        public function Exists() {
            return file_exists($this->getFullPath());
        }
        /**
         * Get file contents
         */
        public function getContents() {
            return file_get_contents($this->getFullPath());
        }
        /**
         * Set file contents
         */                 
        public function setContents($contents) {
            return file_put_contents($this->getFullPath(), $contents);
        }
    }