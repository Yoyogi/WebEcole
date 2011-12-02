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
     * Integration :   
     * @author         Ioan CHIRIAC <i dot chiriac at yahoo dot com>
     * @license        http://www.opensource.org/licenses/lgpl-2.1.php LGPL
     * @package        pdoMap
     * @subpackage     Core
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
     
    /**
     * Original version :    
     * @package package.exceptions.errors
     * @author Johan Barbier <barbier_johan@hotmail.com>
     * @version 20071017
     * @desc package transforming all php errors into catchable exceptions
     *
     */
         
    /**
     * @name exceptionErrorGeneric
     * @desc Generic exceptionError class. Overload Exception::__toString() method and Exception::__construct() method
     *
     */
    abstract class pdoMap_Exceptions_System 
        extends 
            pdoMap_Core_Exception 
    {
        /**
         * @desc translation between context error and exceptionError type of class
         *
         * @var array
         */
        public static $aTrans = array (
        	E_ERROR            => 'pdoMap_Exceptions_System_FatalError',
        	E_WARNING          => 'pdoMap_Exceptions_System_Warning',
        	E_PARSE            => 'pdoMap_Exceptions_System_ParseError',
        	E_NOTICE           => 'pdoMap_Exceptions_System_Notice',
        	E_CORE_ERROR       => 'pdoMap_Exceptions_System_CoreError',
        	E_CORE_WARNING     => 'pdoMap_Exceptions_System_CoreWarning',
        	E_COMPILE_ERROR    => 'pdoMap_Exceptions_System_CompileError',
        	E_COMPILE_WARNING  => 'pdoMap_Exceptions_System_CompileWarning',
        	E_USER_ERROR       => 'pdoMap_Exceptions_System_UserError',
        	E_USER_WARNING     => 'pdoMap_Exceptions_System_UserWarning',
        	E_USER_NOTICE      => 'pdoMap_Exceptions_System_UserNotice',
        	E_STRICT           => 'pdoMap_Exceptions_System_StrictError'
        );
        
        /**
         * @desc is context enabled or not
         *
         * @var boolean
         */
        public static $bContext = false;
            
    	/**
    	 * @desc Error type
    	 *
    	 * @var string
    	 */
    	protected $sType;
    	
    	/**
    	 * @desc Error file
    	 *
    	 * @var string
    	 */
    	protected $sErrFile;
    	
    	/**
    	 * @desc Error line
    	 *
    	 * @var int
    	 */
    	protected $iErrLine;
    	
    	/**
    	 * @desc Error context
    	 *
    	 * @var mixed
    	 */
    	protected $mVars;
    	
    	protected $template = '
    	   <p>
            <strong>%1$s</strong><br />
    		%2$s [%3$s]
           </p>        
        ';
    	
    	/**
    	 * @desc constructor
    	 *
    	 * @param constant $cErrno
    	 * @param string $sErrStr
    	 * @param string $sErrFile
    	 * @param int $iErrLine
    	 * @param mixed $mVars
    	 * @param boolean $bContext
    	 */
    	public function __construct($cErrno, $sErrStr, $sErrFile, $iErrLine, $mVars) {
            parent::__construct(
                $this->sType, 
                $sErrStr, 
                $cErrno
            );
    	}

        
        /**
         * @desc initialize, optional bContext boolean can be given if you want context to be displayed or not
         *
         * @param boolean $bContext (optional, default = false)
         */
        public static function initialize($bContext = false) {
        	self::$bContext = $bContext;
        	set_error_handler(array('pdoMap_Exceptions_System', 'errorHandler'));
        }
        
        /**
         * @desc error handler
         *
         * @param constant $cErrno
         * @param string $sErrStr
         * @param string $sErrFile
         * @param int $iErrLine
         * @param mixed $mVars
         */
        public static function errorHandler($cErrno, $sErrStr, $sErrFile, $iErrLine, $mVars) {
        	if(!isset(self::$aTrans[$cErrno])) {
        		throw new pdoMap_Exceptions_System_NotHandledYet($cErrno, $sErrStr, $sErrFile, $iErrLine, $mVars);
        	} else {
        		throw new self::$aTrans[$cErrno]($cErrno, $sErrStr, $sErrFile, $iErrLine, $mVars);
        	}
        }    	
    }

    /**
     * @desc exceptionErrors for Fatal errors
     *
     */
    class pdoMap_Exceptions_System_FatalError 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Fatal error';
    }

    /**
     * @desc exceptionErrors for Warnings
     *
     */
    class pdoMap_Exceptions_System_Warning 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Warning';
    }

    /**
     * @desc exceptionErrors for Parse errors
     *
     */
    class pdoMap_Exceptions_System_ParseError 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Parse error';
    }

    /**
     * @desc exceptionErrors for Notice
     *
     */
    class pdoMap_Exceptions_System_Notice 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Notice';
    }

    /**
     * @desc exceptionErrors for Core errors
     *
     */
    class pdoMap_Exceptions_System_CoreError 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Core error';
    }

    /**
     * @desc exceptionErrors for Core warnings
     *
     */
    class pdoMap_Exceptions_System_CoreWarning 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Core warning';
    }

    /**
     * @desc exceptionErrors for Compile errors
     *
     */
    class pdoMap_Exceptions_System_CompileError 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Compile error';
    }

    /**
     * @desc exceptionErrors for Compile warnings
     *
     */
    class pdoMap_Exceptions_System_CompileWarning 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Compile warning';
    }

    /**
     * @desc exceptionErrors for User errors
     *
     */
    class pdoMap_Exceptions_System_UserError 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'User error';
    }

    /**
     * @desc exceptionErrors for User warnings
     *
     */
    class pdoMap_Exceptions_System_UserWarning 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'User warning';
    }

    /**
     * @desc exceptionErrors for User notices
     *
     */
    class pdoMap_Exceptions_System_UserNotice 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'User notice';
    }

    /**
     * @desc exceptionErrors for Strict errors
     *
     */
    class pdoMap_Exceptions_System_StrictError 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Strict error';
    }
    
    /**
     * @desc exceptionErrors for not handled yet errors
     *
     */
    class pdoMap_Exceptions_System_NotHandledYet 
        extends 
            pdoMap_Exceptions_System 
    {
    	protected $sType = 'Not handled yet';
    }
