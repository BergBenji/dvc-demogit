<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperChallengeSolutioncontainer(
 * 
 *
 * @author BergBenji
 */
class helperChallengeSolutioncontainer {

   function __construct($data) {
	foreach($data as $k => $v) {
	    $this->$k = $v;
	}
    }
}

?>
