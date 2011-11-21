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
     class pdoMap_Core_InnerException extends Exception {
        protected $template = '%1$s';
        protected $inner;
        /**
         * Initialize a message error
         */                 
        public function __construct() {
            $arguments = func_get_args();
            $exception = array_shift($arguments);
            if (!($exception instanceof Exception)) {
                throw new Exception('Expecting an exception as first argument !');
            }
            array_unshift($arguments, $this->template);
            if (sizeof($arguments) == 1) {
                $arguments[] = 'undefined exception message';
            }    
            $this->inner  = '<div class="pdoMapInnerException">';
            $class = get_class($this);
            $this->inner .= '<h2>Raised Inner Exception ('.$class.')</h2>';            
            $this->inner .= '<div class="location">';
            $this->inner .= '<span class="file">'.$this->getFile().'</span>';
            $this->inner .= '<span class="line"> at line '.$this->getLine().'<span>';                
            $this->inner .= '</div>';
            $this->inner .= '<div class="message">';
            $this->inner .= call_user_func_array(
                    'sprintf',
                    $arguments
            );   
            $this->inner .= ' <a class="more" href="http://www.pdomap.net/help/exceptions/';
            $this->inner .= str_replace('_', '/', $class).'">read more details</a>';
            $this->inner .= '</div>';  
            $this->inner .= '<div class="pdoMapException">';                      
            $this->inner .= $exception->__toString();
            $this->inner .= '</div>';                
            $this->inner .= '</div>';                
        }
        /**
         * Show error information as valid html
         */                 
        public function __toString() {
            return $this->inner;
        }
     }