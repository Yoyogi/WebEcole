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
     * @subpackage     Parsing::Mapping
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
          
    /**
     * Parse a adapter tag
     */
    class pdoMap_Parsing_Mapping_Adapter 
        extends 
            pdoMap_Parsing_Mapping_Node 
    {
        /**
         * Get the connection using name
         */                 
        public function getUse() {
            if (isset($this->use)) {
                return $this->use;
            } else return $this->getDefaultUse();
        }
        /**
         * Get the default use tag
         */                 
        public function getDefaultUse() {
            if (isset($this->getRoot()->use)) {
                return $this->getRoot()->use;
            } else return '*';
        }
        /**
         * Get the table name
         */                 
        public function getTableName() {
            if (isset($this->table)) {
                return $this->table;
            } else return $this->name;
        }
        /**
         * Get current adapter class name
         */                 
        public function getClassName() {
            if (isset($this->generate_as)) {
                return $this->generate_as;
            } else return ucfirst($this->name).'AdapterImpl';
        }
        /**
         * Get the class name to implement
         */                 
        public function getImplements() {
            return array(
                'pdoMap_Dao_IAdapter',
                $this->getGeneratedInterface()
            );
        }
		/**
		 * Get the generated interface name
		 */
		public function getGeneratedInterface() {
			return 'I'.ucfirst($this->name).'Adapter';	
		}
		/**
		 * Get the generated interface name
		 */
		public function getInterface() {
			return $this->implements;	
		}		
        /**
         * Get the parent class name
         */                 
        public function getExtends() {
            return 'pdoMap_Dao_Adapter';
        }
        /**
         * Generate the mapping interface
         */                 
        public function GenerateInterface($name = null) {
			if (!$name) $name = $this->getGeneratedInterface();        
			$this->writeLine('interface '.$name.' {');  
            if (isset($this->select_one)) 
                foreach($this->select_one as $rq) 
                    $rq->writeSignature(true);                  
            if (isset($this->select)) 
                foreach($this->select as $rq) 
                    $rq->writeSignature(true);
            if (isset($this->insert)) 
                foreach($this->insert as $rq) 
                    $rq->writeSignature(true);
            if (isset($this->update)) 
                foreach($this->update as $rq) 
                    $rq->writeSignature(true);
            if (isset($this->delete)) 
                foreach($this->delete as $rq) 
                    $rq->writeSignature(true);                    
            $this->writeLine('}');
        }  
        /**
         *  Generate the adapter code
         */
        public function GenerateAdapter() {
            $this->writeLine(
                'class '.$this->getClassName()
            );
            $this->writeLine(
                    'extends '.$this->getExtends()
            ); 
            $this->writeLine('implements ');
            $this->writeLine(
                    implode(', ', $this->getImplements())
            ); 
            $this->writeLine('{');
            $this->writeLine(
                'public static $adapter = \''.$this->name.'\';'
            );
            $this->writeLine('public function __construct() {');    
            $this->writeLine('parent::__construct(\''.$this->name.'\');');
            $this->writeLine('}');
            if (isset($this->select_one)) 
                foreach($this->select_one as $rq) 
                    $rq->toPhp(true);
            if (isset($this->select)) 
                foreach($this->select as $rq) 
                    $rq->toPhp(true);
            if (isset($this->insert)) 
                foreach($this->insert as $rq) 
                    $rq->toPhp(true);
            if (isset($this->update)) 
                foreach($this->update as $rq) 
                    $rq->toPhp(true);
            if (isset($this->delete)) 
                foreach($this->delete as $rq) 
                    $rq->toPhp(true);
            $this->writeLine('}');             
        }     
        /**
         * Get the class name
         */                 
        public function getAdapterClassName() {
            if ($this->class) {
                return $this->class;
            } elseif (!$this->getInterface()) {
                return $this->getClassName();
            } else return null;
        }
        /**
         * Generate the entity code
         */
        public function GenerateEntity() {
            return $this->entity->Generate();
        }   
        /**
         * Generate the structure array
         */                            
        public function GenerateStructure() {
            // WRITE CONSTRUCTOR
            $this->writeLine(
                sprintf(
                    '$return = new pdoMap_Dao_Metadata_Table(
                        \'%1$s\',\'%2$s\',\'%3$s\',
                        \'%4$s\',\'%5$s\',\'%6$s\');',
                    $this->name,                        // adapter name
                    $this->getTableName(),              // table name
                    $this->entity->getClassName(),      // entity class name
                    $this->getInterface(),              // interface service name
                    $this->getAdapterClassName(),       // adapter class name (if set)
                    $this->getUse()                     // database connection
                )
            );
            // WRITE PROPERTIES
            $this->entity->GenerateProperties();                    
            $this->writeLine('return $return;');
        }                           
    }
    