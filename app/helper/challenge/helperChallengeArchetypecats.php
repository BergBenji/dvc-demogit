<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperChallengeArchetypeCats
 * 
 *
 * @author BergBenji
 */
class helperChallengeArchetypecats {

    function __construct($data) {
	foreach($data as $k => $v) {
	    $this->$k = $v;
	}
    }
    
    function icon()
    {
	if(isset($this->icon)) {
	    $file = basename($this->icon);
	    return 'public/cats/'.$file;
	}
    }
    
    
    
}

?>
