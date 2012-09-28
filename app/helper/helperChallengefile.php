<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperChallengefile
 * 
 *
 * @author BergBenji
 */
class helperChallengefile {

 function __construct($data) {

	foreach($data as $k => $v) 
	    $this->$k = $v;

    
    }
    
    
//    public static function getFileType($filepath)
//    {
//	if(file_exists($filepath) && is_readable($filepath)) {
//	    $info = pathinfo($filepath);
//	    if(isset($info['extension']))
//		return $info['extension'];
//	}
//	
//	return '';
//    }
    
    function extension()
    {
	if(isset($this->img))	    { 
	    return core::getFileType(PUBLICDIR.'challenge_files/'.$this->img); 
	}
	
	if(isset($this->filename))  { 
	    return core::getFileType(PUBLICDIR.'challenge_files/'.$this->filename); 
	}
    }
    
    
    
    
    
    function isImg()
    {
	$ext = $this->extension();
	if($ext == 'jpg' || $ext == 'gif' || $ext == 'png')
	    return '1';
	return '0';
    }
    
    
    function isPdf()
    {
	$ext = $this->extension();
	if($ext == 'pdf')
	    return '1';
	return '0';
    }
    
}

?>
