<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperChallengeSolution
 * 
 *
 * @author BergBenji
 */
class helperChallengeSolution {

    var $activesolution = NULL;
    
    function __construct($data, $activeSolution = NULL) {
	
	foreach($data as $k => $v) {
	    $this->$k = $v;
	    if($k == 'id' && $v == $activeSolution) $this->activesolution = $v; 
	}
//	if(isset(fw::registry('_get')->gsid)) {
//		$this->activesolution = fw::registry('_get')->gsid;
//	}
    }
    
    
    function ischecked()
    {
	if($this->activesolution == $this->id) {
	    return '1';
	}
	return '0';
    }
    
    function isRatingValue($v)
    {
	if(isset($this->ratset)) return 0;
	if(isset($this->rating) && $this->rating !='') {
	    if(	$this->rating >= (float)$v-0.6 && $this->rating <= (float)$v+0.4 ) {
		$this->ratset = 1;
		return 1; 
	    }
	} else {
	    return 0;
	}
    }
 
}

?>
