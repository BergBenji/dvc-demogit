<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dropbox
 * 
 *
 * @author BergBenji
 */
class dbox extends baseController {

    public $dropbox = NULL,
	   $categories = array(),
	   $additions = array(' -benefit',' -functions',' -image',' -keywords');
    
    private $values = array(),
	    $basepath = '/dvc/';
    
    
    
    
    
    
    function __construct() {
	parent::__construct(true);
	
    }
    
    
    public function connect() {
	$vendor = new vendor();
	$this->dropbox = $vendor->loadVendor('dropbox');
	
//	Sandbox
//	$dropbox->setKey('');
//	$dropbox->setSecret('');
//	Dropbox
	$this->dropbox->setKey('');
	$this->dropbox->setSecret('');
	$this->dropbox->setCType('');
	$this->dropbox->connect();
	return $this->dropbox;
    }
    
    
    public function getFileList() {
	$dbox = $this->connect();
	$filelist = $dbox->getFileList('/');
	
	
	echo 'Files</br />';
	echo '<pre>';
	var_dump($filelist);
	echo '</pre>';
    }
    
    public function getMeta() {
	$this->connect();
	$accountInfo = $this->dropbox->getAccountInfo();
	echo 'ACC Info<br />';
	echo '<pre>';
	var_dump($accountInfo);
	echo '</pre>';
    }
    
    public function getFile() {
	$this->connect();
	
	$target = PUBLICDIR.'downloads/TARGETNAME';
	$src = '/FILENAME';
	$this->dropbox->getFile($src, $target);
	
    }
    
    public function getFiles($type='', $basedir = '/dvc') {
	
	$this->connect();
	$meta = $this->dropbox->getFileList($basedir);
	
	$categories = array();
	$files = array();
	
	$this->getDbCategories('/dvc')	// Save all Categories to the categroies var
	     ->getCatFiles('/dvc');	// Get all files for an categorie
	
	echo '<pre>';
	var_dump($this->categories);
	echo '</pre>';
    }   
    
    
    public function getQueue($type='', $basedir = '/dvc') {
	
	$this->connect();
	$this->getDbCategories($basedir);	// Save all Categories to the categroies var
	$this->getCatFiles();		// Get all files for an categorie
	$this->buildQueueGroups();
	$this->workQueue();
	
	
	
//	echo '<pre>';
//	var_dump($this->categories);
//	echo '</pre>';
    }   
    
    
    
    
    
    
    public function workQueue() {
	$target = PUBLICDIR.'downloads/';
	
	foreach($this->values as $k => $v) {    
	    $v->downloadFiles($this->dropbox, $target);//	    echo 'Alle Dateien herunterladen<br /><br />';
	    $v->generateContents($target);//	    echo 'Alle Dateigruppen abarbeiten (Object fuer Object)<br /><br />';
	    $v->addToDb();//	    echo 'Inahlte in die Datenbank eintragen! Dateien in die Finalen Ziele Verschieben Dateien in der DropBpx verschieben!<br />';
	}
	
	echo '<pre>';
	print_r($this->values);
	echo '</pre>';
	echo 'Import Finished!';
    }
    
    
    
    
    
    public function buildQueueGroups() 
    {
	foreach($this->categories as $cat => $files) {
	    foreach($files as $key => $name) {
		$fname = substr(basename($name), 0, strrpos(basename($name), '.'));
		

		if( !($this->isAddionalFile($fname) ) ) {
		    if(isset($this->values[basename($name)])) {
			$value = $this->values[basename($name)];
		    } else {
			$value = new helperValuesGenerator();
			$value->setModule($name);
			$value->setFilepath($name);
		    }
		    $value->setCategory($cat);
		    foreach($files as $filekey => $filename) {
			$basename = substr($name, 0, strrpos($name, '.'));
//			if( $basename.' -benefit.txt' == $filename || $basename.' -functions.txt' == $filename || $basename.' -image.jpeg' == $filename ) {
			if($this->isAddionalFile($filename, $basename)) {
			    $value->addAdditional($filename);
			}
		    }
		    
		    $this->values[basename($name)] = $value;
		}
	    }
	}
	return $this;
    }
    
    
    
    
    public function getCatFiles() {
	foreach($this->categories as $k => $v) {
	    $meta = $this->dropbox->getFileList($k);
	    $files = $meta->body->contents;
	    foreach($files as $key => $file) {
		$this->categories[$k][] = $file->path;
	    }
	}
	
	return $this;
    }
    
    
    
    public function getDbCategories($basedir = '/dvc') {

	$meta = $this->dropbox->getFileList($basedir);
	$filelist = $meta->body->contents;
	foreach($filelist as $k => $v) {
	    if($v->is_dir) {
		if(basename($v->path) == 'imported' || basename($v->path) == 'example') continue;
		$cat = $v->path;
		$this->categories[$cat] = array();
	    }
	}
	
	
	
	
	
	return $this;
    }
    
    
    private function isAddionalFile($filename, $basename = NULL) {
	if($basename !== NULL) {
	    foreach($this->additions as $k => $v) 
		if(strstr($filename, $basename.$v)) 
		    return true;
	} else {
	    foreach($this->additions as $k => $v) 
		if(strstr($filename, $v)) 
		    return true;
	}
	return false;
    }
    
    
    
    
    
    public function initializeDropBox() {
	// CreateDirs
	$this->connect();
	$data = $this->model->getCategories();
	$cats = array();
	$meta = $this->dropbox->getFileList($this->basepath);
	$files = $meta->body->contents;
	foreach($files as $k => $v) $cats[] = $v->path;
	foreach($data as $k => $v) {
	    if(!in_array($this->basepath.$v['title'], $cats)) {
		$this->dropbox->create($this->basepath.$v['title']);
	    }
	}
	
    }
    
    
    
    
}

?>
