<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperValuesGenerator
 * 
 *
 * @author BergBenji
 */
class helperValuesGenerator extends model {

    public  $title = NULL,
	    $basename = NULL, 
	    $fullpath = NULL,
	    $thumbnail = NULL,
	    $category = array(), 
	    $additional = array();
    
    private $keywords = NULL, 
	    $benefit = NULL, 
	    $tech_func = NULL;
    
    
    function __construct() {
	parent::__construct();
    }
    
    
    public function setFilepath($name) {
	$this->fullpath = $name;
	return $this;
    }
    
    public function setCategory($name) {
	$this->category[] = $name;
	return $this;
    }
    
    
    public function setModule($name) {
	$this->basename = basename($name);
	$this->title = substr(basename($name), 0, strrpos(basename($name), '.'));;
	return $this;
    }
    
    
    public function addAdditional($name) {
	
	if(is_array($name)) {
	    foreach($name as $k => $v) {
		if(strstr($v, '-image')) {
		    $this->thumbnail = $v;
		} else {
		    $this->additional[] = $v;
		}
	    }
	} else {
	    if(strstr($name, '-image')) {
		$this->thumbnail = $name;
	    } else {
		$this->additional[] = $name;
	    }
	    
	}
	return $this;
    }
    
    
    
    public function downloadFiles($dropbox, $tdir) {
	
	
	// Get Base File
	$dropbox->getFile($this->fullpath, $tdir.basename($this->fullpath));
	$this->mainfile = $tdir.basename($this->fullpath);
	

	
	// Get Thumb
	if($this->thumbnail !== NULL) {
	    $ret1 = $dropbox->getFile($this->thumbnail, $tdir.basename($this->thumbnail));
//	    print_r($ret1);
//	    echo 'Ret1 finisched<br />';
	    $ret2 = $dropbox->move($this->thumbnail, '/dvc/imported/'.basename($this->thumbnail));
//	    print_r($ret2);
//	    echo 'Ret2 finisched<br />';
	}
	
	
//		
//echo 'Download start:';
//	
//	return $this;

	
	
	// GetAddition Files	
	foreach($this->additional as $k => $v) {
	    $dropbox->getFile($v, $tdir.basename($v));
	    $dropbox->move($v, '/dvc/imported/'.basename($v));
	    
	}

	return $this;
    }
    
    
    
    
    
    
    
    public function fetchContent($src, &$r) {
	if(file_exists($src))
	    $r = trim(file_get_contents($src), "\n \t");
	
    }
    
    
    
    
    
    
    public function generateContents($srcdir) {
	foreach($this->additional as $k => $v) {
	    $src = $srcdir.basename($v);
	    
	    if(strstr($v, '-benefit')) {
		$this->fetchContent($src, $this->benefit);	//$this->getBenefit($src);
	    }
	    
	    if(strstr($v, '-keywords')) {
		$this->fetchContent($src, $this->keywords);	//$this->getKeywords($src);	
	    }
	    
	    if(strstr($v, '-functions')) {
		$this->fetchContent($src, $this->tech_func);	//$this->getTech_Func($src);
	    }
	}
	
    }
    
    
    
    public function modExists() {
	$SQL = 'SELECT * FROM sys_mods where module=:title LIMIT 1';
	return $this->db->select($SQL, array('title' => $this->title));
    }
    
    
    public function getCatBTitle($title) {
	$SQL = 'SELECT id FROM sys_mods_cat WHERE title = :title';
	$data = $this->db->selectSingle($SQL, array('title' => $title));
	return $data;
    }
    
    
    public function addToDb() {
	$data = array('id' => '999');
	
	if(isset($this->category[0])) {
	    $data = $this->getCatBTitle(basename($this->category[0]));
	}
	
	$available = $this->modExists();
	
	
	
	if(!empty($available)) {
	    // Modul existiert!
	    $params = array();
	    
	    if($this->benefit != NULL) $params['benefit'] = $this->benefit;
	    if($this->keywords != NULL) $params['keywords'] = $this->keywords;
	    if($this->tech_func != NULL) $params['tech_func'] = $this->tech_func;
	    if($available[0]['cat_id'] != $data['id']) $params['cat_id'] = $data['id'];
	    
	    if($this->thumbnail != NULL) {
		
		if($available[0]['image'] != '' && file_exists(PUBLICDIR.'modules/'.basename($available[0]['image']))) {
		    @unlink(PUBLICDIR.'modules/'.basename($available[0]['image']));
		}
		if(file_exists(PUBLICDIR.'archetypes/'.$available[0]['id'].'/'.$available[0]['id'].'jpg') && is_readable(PUBLICDIR.'archetypes/'.$available[0]['id'].'/'.$available[0]['id'].'jpg')) {
		    @unlink(PUBLICDIR.'archetypes/'.$available[0]['id'].'/'.$available[0]['id'].'jpg');
		}
		
		$thumbsrc =	PUBLICDIR.'downloads/'  .basename($this->thumbnail);
		$thumbtarget =  PUBLICDIR.'modules/'    .time().basename($this->thumbnail);
		core::file_move($thumbsrc, $thumbtarget);//		    rename($thumbsrc, $thumbtarget);

		$params['image'] = $thumbtarget;
	    }
	    
	    
	    if(!empty($params)) {
		$this->db->update('sys_mods', $params, 'id = '.$available[0]['id']); 
		echo '<script type="text/javascript">console.log("UPDATED!"); </script>';
	    } else {
		echo '<script type="text/javascript">console.log("Nothing changed!");</script>';
	    }
	    $id = $available[0]['id'];
	    
	    
	} else {
	
	    if($this->thumbnail != NULL) {
		$thumbsrc =	PUBLICDIR.'downloads/'  .basename($this->thumbnail);
		$thumbtarget =  PUBLICDIR.'modules/'    .basename($this->thumbnail);
//		rename($thumbsrc, $thumbtarget);
		core::file_move($thumbsrc, $thumbtarget);
	    }

	    $params = array();
	    $params['module'] = $this->title;
	    $params['tech_func'] = $this->tech_func;
	    $params['benefit'] = $this->benefit;
	    $params['keywords'] = $this->keywords;
	    if($this->thumbnail !== NULL) $params['image'] = $thumbtarget;
	    $params['cat_id'] = $data['id'];

	    $this->db->insert('sys_mods', $params);
	    $id = $this->db->lastInsertId();
	
	    echo '<script type="text/javascript">console.log("ADDED!!");</script>';
	
        }
	
	
	// Add Base File
	
	if(isset($id) && $id != '' && is_numeric($id)) {
	    $basetargetfolder = PUBLICDIR.'archetypes/'.$id.'/';
	    // If folder does not exists, generate it!
	    if(!is_dir($basetargetfolder)) mkdir($basetargetfolder);
	    
	    core::file_move($this->mainfile, $basetargetfolder.basename($this->mainfile));
	    
	    
	    
	    
	    
	    $params = array();
	    $params['modfile'] = $basetargetfolder.basename($this->mainfile);
	    $params['where'] = 'id = '.$id;
	    $this->db->update('sys_mods', $params,'');
	    
	}
	
	
	// Datei / Ordner verschieben!
    }
    
    
    
    
    
}

?>
