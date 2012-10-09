<?php

class form_val {

    function __construct() {}
    
    public static function val($data = null, $func = null, $arg1 = null, $arg2 = null) {
	$val = new form_val();
	if($data) {
	    if($arg2) return $val->$func($data, $arg1, $arg2);
	    if($arg1) return $val->$func($data, $arg1);
	    if($data) return $val->$func($data);   
	}
    }
    
    public function minimum($data, $arg) {
	if((float)$data < $arg) {
	    return 'Minimum not reached';
	}
    }
    
    public function maximum($data, $arg) {
	if((float)$data > $arg) {
	    return 'Maximum exceeded';
	}
    }
    
    
    public function minlength($data, $arg)
    {
	if(strlen($data) < $arg) {
	    return 'Your string is to short!';
	}
    }
    
    public function maxlength($data, $arg) {
	
	if(strlen($data) > $arg) {
	    return 'Your string is to long!';
	}
    }
    
    public function digit($data) {
	if(!ctype_digit($data)) {
	    return 'Your input need to be a Digit!';
	}
    }
    
    public function alphdigit($data) {
	if(!ctype_alnum($data)) {
	    return 'Only Alphabetical and Digital chars';
	}
    }
    
    
    public function length($data, $minchars, $maxchars) {
	if(strlen($data) < $minchars)
	    return "Your string is to short (min. $minchars)!";
	
	if(strlen($data) > $maxchars)
	    return "Your string is to long (max. $maxchars)!";
    }
    
    
    public function contains($data, $vars) {
	if(strstr($vars, ';')) {
	    $vars = explode(';', $vars);
	} else {
	    $vars = array($vars);
	}
	
	
	if(!in_array($data, $vars)) {
	    return "The value you give ($data) is not allowed!";
	}
	
    }
    
    
    public function __call($function, $args) {
	if(function_exists($function)) {
	    if(count($args) == 3) $res = $function($args[0], $args[1], $args[2]);
	    if(count($args) == 2) $res = $function($args[0], $args[1]);
	    if(count($args) == 1) $res = $function($args[0]);
	    if( !$res ) {
		return "The check $function throw an error for value '$args[0]'!";
	    }
	} else {
	    throw new Exception('This validator or function ('.$function.') does not exists');
	}
    }
}
