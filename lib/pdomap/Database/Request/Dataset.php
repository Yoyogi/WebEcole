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
     * @subpackage     Database
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /**
     * SQL Enumerable Result
     */         
    class pdoMap_Database_Request_Dataset 
        implements Iterator, Countable 
    {
        protected $ptr;
        protected $current;
        protected $index = -1;
        protected $type;
        protected $buffer;
        /**
         * Initialize the recordset
         */                 
        public function __construct(PDOStatement $ptr, $type = null) {
            $this->ptr = $ptr;
            $this->type = $type;
            $this->buffer = array();
        }
        /**
         * Bind a class to handle result items
         */                 
        public function getType() {
            return $this->type;
        }
        /**
         * Start request at first
         */                 
        public function rewind() { 
            if ($this->index != -1) {
                $this->index = -1; 
            }
            $this->next(); 
        }
        /**
         * Get current item
         * @returns mixed Returns an array or a class if result is binded         
         */                 
        public function current() { 
            if ($this->index == -1) $this->next(); 
            return $this->current; 
        }
        /**
         * Get current row position in recordset
         */                 
        public function key() { return $this->index; }
        /**
         * Get to the next item
         */                 
        public function next() { 
            $this->index ++; 
            if (!isset($this->buffer[$this->index])) {
                $this->buffer[$this->index] = pdoMap::database()->Fetch($this->ptr);
            }
            if ($this->type && $this->buffer[$this->index]) {
                $this->current = pdoMap::get($this->type)->Create($this->buffer[$this->index]);
            } else {
                $this->current = $this->buffer[$this->index];
            }
        }
        /**
         * Verify if recordset is not at end
         */                 
        public function valid() { return ($this->index > -1 && $this->current); }        
        /**
         * Get the size of recordset
         */                 
        public function count() { return $this->ptr->rowCount(); }
        /**
         * Rendering results to a string
         */                 
        public function __toString() {
            $bind = $this->type; $this->type = null;
            $this->rewind();
            $ret = '<div class="sqlResult"><div class="sqlStatement">'.$this->ptr->queryString.'</div>';
            if ($this->valid()) {
                $ret .= '<table border="1"><thead><tr>';
                foreach($this->current() as $key => $value) {
                    $ret .= '<th>'.$key.'</th>';
                }
                $ret .= '</tr></thead><tbody>';
                $this->rewind();
                foreach($this as $key => $vals) {
                    $ret .= '<tr>';
                    foreach($vals as $v) $ret .= '<td>'.$v.'</td>';
                    $ret .= '</tr>';
                }
                $ret .= '</tbody></table></div>';
            } else {
                $ret .= 'Empty dataset ...';
            }
            $this->type = $bind;
            return $ret;
        }
    }
    