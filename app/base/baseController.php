<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of baseController
 * 
 *
 * @author BergBenji
 */
class baseController extends controller {

    function __construct($loginneeded = false) {
	
	if($loginneeded) {
	    if(!session::get('loggedIn')) {
		header('location: /login');
		exit();
	    }
	}
	
	
	if(template::isMobile()) {
	    config::set(array('cssfiles' => config::get('cssfiles.mobile')));
	    config::set(array('jsfiles' => config::get('jsfiles.mobile')));
	} else {
	    config::set(array('cssfiles' => config::get('cssfiles.notmobile')));
	    config::set(array('jsfiles' => config::get('jsfiles.notmobile')));
	}
	
	parent::__construct();
    }

    public function index() {
	
	echo 'Please add "index" action in Class '.get_called_class();
	exit();
	
    }
    
    
    
    
    
    
}

?>
