<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperChallengePerson
 * 
 *
 * @author BergBenji
 */
class helperChallengePerson {

    function __construct($data) {
	foreach($data as $k => $v) {
	    $this->$k = $v;
	}
    }

}

?>
