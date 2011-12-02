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
     * @subpackage     Database::Adapters
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */


    /**
     * Defines the structure of a table
     */
    interface pdoMap_Database_Request_Adapters_ITable {
        /**
         * Returns the name of database
         */                 
        function getDatabase();
        /** 
         * The table name
         */
        function getName();
        /** 
         * Array of fields typed as IRequestField
         * @returns array
         */
        function getFields();
        /** 
         * Retourns the primary key
         * @returns IRequestField
         */
        function getPrimaryKey();
        /**
         * Retourne la liste des clefs etrangeres sous la forme d'un array de IRequestForeignField
         */
        function getForeignKeys();
        /**
         * Empty this table
         */                 
        function Truncate();
        /**
         * Delete this table
         */                 
        function Drop();        
        /**
         * Create a new table
         */                              
        function Create();        
        /**
         * Join all foreign keys with tables
         */                              
        function JoinAll(); 
        /**
         * Drop the foreign key who references adapter
         */                     
        function DropFk($adapter);   
        /**
         * Drop all foreign keys
         */                     
        function DropAllFk();   
    }