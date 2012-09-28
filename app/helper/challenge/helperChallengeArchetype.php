<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperChallengeArchetype
 * 
 *
 * @author BergBenji
 */
class helperChallengeArchetype {


    var $original_image = '';
    var $target = '';
    
    
    function __construct($data) {
	foreach($data as $k => $v) {
	    $this->$k = $v;
	}
	
	$this->catimg();
	
	
    }
    
    function catimg() {
	
	$path = $this->catimg;
	$realpath = 'public/cats/'.basename($this->catimg);
	$this->catimg = $realpath;
	return $realpath;
    }
    
    
    
    function image()
    {
	
	$force = false;
	
	$this->targetdir = PUBLICDIR.'archetypes/'.$this->id.'/';
	if(!is_dir($this->targetdir)) {
	    mkdir($this->targetdir);
	}
	
	$this->target = $this->targetdir.$this->id.'.jpg';
	
	
	$this->original_image = PUBLICDIR.'modules/'.basename($this->image);
	
	$max_height = 150;
	$max_width = 200;
	$quality = 85;
	
	if(file_exists($this->target) && $force == false) {
	    return str_replace(PUBLICDIR, '/public/', $this->target);
	} elseif(file_exists($this->original_image)) {
	    switch (exif_imagetype($this->original_image)) {
		case 1:
		    $imgOld= imagecreatefromgif($this->original_image); 
		    break;
		case 2:
		    $imgOld= imagecreatefromjpeg($this->original_image); 
		    break;
		case 3:
		    $imgOld= imagecreatefrompng($this->original_image); 
		    break;
		default:
		    $imgOld= imagecreatefromjpeg($this->original_image); 
		    break;
	    }

	    
	    $imageInfo = getimagesize($this->original_image); 
	    
	    $width = $imageInfo[0]; 
	    $height = $imageInfo[1];
	    
	    
	    $widthA  = $max_width; 
	    $scale   = $max_width/$width; 
	    $new_height = round($height * $scale);
	    
	    $heightA  = $max_height; 
	    $scale    = $max_height/$height; 
	    $new_width   = round($width * $scale); 
	    
	    
	    if($new_width >= $max_width) {
		$widthA = $max_width;
		$heightA = $new_height;
	    } else if($new_height >= $max_height) {
		$widthA = $new_width;
		$heightA = $max_height;
	    }
	    
	    $img = imagecreatetruecolor($widthA,$heightA); 
	    //imagecopyresized($img, $imgOld, 0,0, 0,0, $widthA,$heightA, ImageSX($imgOld),ImageSY($imgOld)); 
	    imagecopyresampled($img, $imgOld, 0,0, 0,0, $widthA,$heightA, ImageSX($imgOld),ImageSY($imgOld)); 

		
	    if(imagejpeg($img, $this->target, $quality)) {
		$this->target = str_replace(PUBLICDIR, '/public/', $this->target);
		
		#file_put_contents(SYSROOT.'dentsuvaluecreator.manifest', $target."\n", FILE_APPEND);
		
		return $this->target;
		
	    } else {
		
		$this->original_image = str_replace(PUBLICDIR, '/public/', $this->original_image);;
		
		echo 'FILE B: '. $this->original_image.'<br />';
		
		return $this->original_image;
	    }
	}  
	
    }
    
    
    
    
    function title()
    {
	return substr($this->title, 0, 25);
    }
    
}

?>
