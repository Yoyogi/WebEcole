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
     * @subpackage     Database::Adapters::MySQL
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Main request class
     */
    abstract class pdoMap_Database_Request_Adapters_MySQL_State 
        extends 
            pdoMap_Database_Request_Adapters_Helper_State
        implements 
            pdoMap_Database_Request_Adapters_IState 
    {
        public function escapeObject($name) {
            return pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity(
                    $name
            );
        }
        public function escapeEntity($key, $table = null) {
            if (is_null($table)) $table = $this->table[0];
            return 
                $this->escapeTable($table)
                .'.'
                .$this->escapeObject(
                    pdoMap::structure($table)->getField($key)->name
                );
        } 
        public function escapeTable($name) {
            return pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                pdoMap::structure($name)->name, 
                pdoMap::structure($name)->db
            );        
        }
        public function escapeValue($value) {
            return pdoMap_Database_Request_Adapters_MySQL_Builder::escapeValue(
                $value
            );        
        }
    }     