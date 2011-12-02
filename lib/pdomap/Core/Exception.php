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
     * @subpackage     Core
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
     /**
      * Defines a pdoMap Exception
      */             
     class pdoMap_Core_Exception 
        extends 
            Exception 
    {
        protected $template = '%1$s';
        /**
         * Initialize a message error
         */                 
        public function __construct() {
            $arguments = func_get_args();
            array_unshift($arguments, $this->template);
            parent::__construct(
                call_user_func_array(
                    'sprintf',
                    $arguments
                )
            );
        }
        /**
         * Show error information as valid html
         */                 
        public function __toString() {
            $ret = '<div class="pdoMapException">';
            $class = get_class($this);
            $ret .= '<h2>Raised a '.$class.'</h2>';
            $ret .= '<div class="location">';
            $ret .= '<span class="file">'.$this->getFile().'</span>';
            $ret .= '<span class="line"> at line '.$this->getLine().'<span>';                
            $ret .= '</div>';
            $ret .= '<div class="message">';
            $ret .= $this->getMessage();
            $ret .= '<a class="more" href="http://www.pdomap.net/help/exceptions/';
            $ret .= str_replace('_', '/', $class).'">read more details</a>';
            $ret .= '</div>';
            $ret .= '<div class="trace">';
            foreach($this->getTrace() as $level => $line) {
                $ret .= '<div class="item">';
                $ret .= '<div class="call">';
                if (isset($line['class'])) {
                    $ret .= '<span class="class">'.$line['class'].$line['type'].'</span>';
                }
                $ret .= '<span class="function">'.$line['function'].'</span>';
                $ret .= '<span class="args"><span class="bracket">(</span>';
                if (!isset($line['args'])) $line['args'] = array();
                foreach($line['args'] as $arg) {
                    $ret .= '<span class="arg';
                    if (is_string($arg)) {
                        $ret .= ' string">"';
                        if (strlen($arg) > 33) {
                            $ret .= htmlentities(substr($arg, 0, 10));
                            $ret .= '<span class="etc">...</span>';
                            $ret .= htmlentities(substr($arg, -20));
                        } else $ret .= htmlentities($arg);
                        $ret .= '"';
                    } elseif (is_array($arg)) {
                        $ret .= ' array">';
                        $ret .= 'array('.sizeof($arg).')';
                    } elseif (is_object($arg)) {
                        $ret .= ' object">';
                        $ret .= get_class($arg);
                    } elseif (is_bool($arg)) {
                        $ret .= ' boolean">';
                        $ret .= ($arg ? 'true' : 'false');
                    } elseif (is_numeric($arg)) {
                        $ret .= ' number">'.$arg;
                    } else {
                        $ret .= ' variant">';
                        $ret .= $arg;
                    }
                    $ret .= '</span>, ';
                }
                if (sizeof($line['args']) > 0) 
                    $ret = substr($ret, 0, strlen($ret) - 2);
                $ret .= '<span class="bracket">)</span></span>';
                $ret .= '</div>';
                if (isset($line['file'])) {
                    $ret .= '<div class="location">';
                    $ret .= '<span class="file">'.$line['file'].'</span>';
                    $ret .= '<span class="line"> at line '.$line['line'].'<span>';                
                    $ret .= '</div>';
                }
            }
            foreach($this->getTrace() as $level => $line) $ret .= '</div>';
            $ret .= '</div>';
            return $ret.'</div>';
        }
     }