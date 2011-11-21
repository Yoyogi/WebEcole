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
     * Observable objects helper
     */         
    abstract class pdoMap_Core_Event  {
        /**
         * Declare events
         */                 
        protected $events = array();
        
        /**
         * Observers array
         */                 
        protected $observers = array();
        
        /**
         * Attach an observer
         */                 
        public function Attach($sender, $event, $function = null) {
            if (!isset($this->events[$event])) {
                throw new pdoMap_Exceptions_EventAttach(
                    get_class($sender), $function,
                    get_class($this), $event
                );
            }
            if (!$function) $function = 'on'.ucfirst($event);
            if (!isset($this->observers[$event])) {
                $this->observers[$event] = array();
            }
            $this->observers[$event][] = array($sender, $function);
            return true;
        }    
        /**
         * Detach event observers
         * @params string The event name         
         */                 
        public function Detach($event) {
            if (!isset($this->events[$event])) {
                throw new pdoMap_Exceptions_EventDetach(
                    get_class($this), $event
                );
            }
            $this->observers[$event] = array();
            return true;
        }         
        /**
         * Detach all observers
         */                 
        public function DetachAll() {
            $this->observers = array();
            return true;
        }        
        /**
         * Raise event on observers stack
         * @params string Event name    
         * @params pdoMap_Core_IEventArgs arguent              
         */                 
        protected function Raise($event, pdoMap_Core_Event_Args $args = null) {        
            if (!isset($this->events[$event])) {
                throw new pdoMap_Exceptions_EventRaise(
                    get_class($this), $event
                );
            }
            if (is_null($args)) $args = new pdoMap_Core_Event_Args();
            if (
                !isset($this->observers[$event]) 
                || sizeof($this->observers) == 0
            ) return $args; 
            try {                                                    
                foreach($this->observers[$event] as $observer) {
                    call_user_func_array(
                        $observer, 
                        array(
                            &$this, 
                            &$args
                        )
                    );                        
                }
                return $args;
            } catch(pdoMap_Core_Event_Exceptions_StopBubble $ex) {
                return false;
            }
        }
    }     