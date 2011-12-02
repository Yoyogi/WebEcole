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
     * @subpackage     Cache
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Cache adapter plugin
     */             
    interface pdoMap_Cache_IAdapter {
        /**
         * Initialize cache session
         */                 
        function openSession();
        /**
         * Unload cache session
         */                 
        function closeSession();
        /**
         * Verify a key status         
         * @params string     The key to check
         * @params int             The key lifetime in seconds before his last set
         * @returns boolean Returns true if key is enabled of false otherwise         
         */                 
        function check($key, $timeout = 0);
        /**
         * Get a key from cache
         * @params string The key to get
         * @returns mixed The value associated to indicated key
         */                 
        function get($key);
        /**
         * Set a key to cache
         * @params string The key to set
         * @params mixed The value to record
         */                 
        function set($key, $value);
        /**
         * Remove a key from cache
         * @params string The key to remove
         */                 
        function remove($key);
        /**
         * Clear all cache data
         * @returns boolean Returns true if cache was cleared          
         */                 
        function clear();
    }