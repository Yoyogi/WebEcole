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
     * Date time helper
     */         
    class pdoMap_Utils_Date  {
        /**
         * @var string Date timestamp
         */                 
        private $timestamp;
        /**
         * Initialize date helper
         * @params mixed Date value as timestamp or string in format Y-m-d H:i:s         
         */                 
        public function __construct($date) {
            if (is_numeric($date) && $date > 0) {
                $this->timestamp = $date;
            } else {
                throw new Exception('Bad constructor value - expecting a timestamp');
            }
        }
        /**
         * Gets the unix timestamp value
         */                 
        public function getTimeStamp() {
            return $this->timestamp;
        }
        /**
         * Get a specific date format
         * @params string Format of date
         * @see date For format syntax                  
         */                 
        public function getFormat($format = 'Y-m-d H:i:s') { 
            return date($format, $this->timestamp); 
        }
        /**
         * Get the year
         */                 
        public function getYear() { 
            return $this->getFormat('Y'); 
        }
        /**
         * Get month 
         */                 
        public function getMonth() {
            return $this->getFormat('m');
        }
        /**
         * Get day
         */       
        public function getDay() {
            return $this->getFormat('d');
        }          
        /**
         * Get hour
         */        
        public function getHour() {
            return $this->getFormat('H');
        }         
        /**
         * Get minute
         */          
        public function getMinute() {
            return $this->getFormat('i');
        }       
        /**
         * Get seconds
         */           
        public function getSeconds() {
            return $this->getFormat('s');
        }      
        /**
         * Add days
         */                 
        public function addDays($number) {
            $this->timestamp += ($number * 86400);
        }
        /**
         * Add month
         * @todo fix         
         */                 
        public function addMonths($number) {
            $this->addDays($number * 30);
        }
        /**
         * Add years
         * @todo fix         
         */                 
        public function addYears($number) {
            $this->addDays($number * 365);
        }
        /**
         * Set current datetime
         */                 
        public function setNow() {
            $this->timestamp = time();
        }
        /**
         * Get the date string value
         */                 
        public function __toString() {
            return $this->getFormat();
        }
    }