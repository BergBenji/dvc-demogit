<?php

class helperChallenge extends model {
    
    function __construct($data) {
	parent::__construct();
	foreach($data as $k => $v) {
	    $this->$k = $v;
	}
    }
    
    function startTitle()
    {
	if(strlen($this->title) > 20)
	    return substr($this->title, 0, 20).'...';
	else 
	    return $this->title;
    }
    
    
    function img()
    {
	if(!empty($this->img)) {
	    $out = '/public/challenge_files/'.$this->img;
	    return $out;
	}
	return '';
    }
    
    
}