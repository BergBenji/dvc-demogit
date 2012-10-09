<?php


/**
 * 
 * - Fill out a form
 *  - POST to PHP
 *  - Sanatize
 *  - Validate Data
 *  - Return Data
 *  - Write to Database
 * 
 */
class form {

    
    /**
     *
     * @var array $_postData Storen the Post data 
     */
    private $_postData = array();
    
    /**
     *
     * @var array $_currentItem the inmediately postet item
     */
    private $_currentItem = null;
    
    /**
     * The validator object
     * @var object 
     */
    private $_val = null;
    
    /**
     * This holds the errors from Validator
     * @var array 
     */
    private $_error = array();
    
    /**
     * Constructor
     * Initiates the valobject
     */
    function __construct() {
	$this->_val = new form_val();
    }
    
    
    /**
     * post - This si to run $_POST
     * @param string $field
     * @return form 
     */
    public function post($field)
    {
	$this->_postData[$field] = $_POST[$field];
	$this->_currentItem = $field;
	return $this;
    }

    
    /**
     * Fetch - Return the post data
     * @param mixed $fieldName
     * @return mixed String or Array
     */
    public function fetch($fieldName = false)
    {
	if($fieldName) {
	    
	    if(isset($this->_postData[$fieldName]))
		return $this->_postData[$fieldName];
	    return false;
	} else {
	    return $this->_postData;
	}
	
    }
    
    
    /**
     * val - This si to Validate
     * @param strinf $typeOfValidator Name of the validator
     * @param string $arg Argument to be chacked against
     * @return form 
     */
    public function val($typeOfValidator, $arg1 = null, $arg2 = null)
    {
	if ($arg2)
	    $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $arg1, $arg2);
	else if($arg1)
	    $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $arg1);
	else
	    $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem]);
	
	
	if($error) {
	    $this->_error[$this->_currentItem] = $error;
	}
	    
	return $this;
    }
    
    
    
    
    public function fetchErrors($type = 'full') {
	if($type == 'keys') {
	    return array_keys($this->_error);
	} else {
	    return $this->_error;
	}
    }
    
    
    /**
     * Submit - handles the form, and throws an exception upon error
     * 
     * @return boolean
     * 
     * @throws Exception 
     */
    public function submit() {
	if(empty($this->_error)) {
	    return true;
	}
	else
	{
	    $str = '';
	    foreach ($this->_error as $k => $v)  $str .= $k . ' => '. $v ."\n";
	    throw new Exception($str);
	}
    }
    
    
    
    
}