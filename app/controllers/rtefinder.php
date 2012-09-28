<?php

ini_set('max_execution_time', 10);

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of elfinder
 * 
 *
 * @author BergBenji
 */
class rtefinder extends controller {

    function __construct() {
	parent::__construct();
	
	
    }
    
    public function index() {
	$vars = func_get_args();
	
//	echo 'Vars:<br />';
//	print_r($vars);
//	
//	echo 'GET:<br />';
//	print_r($_GET);
//	
//	echo 'POST:<br />';
//	print_r($_POST);
//	
//	echo 'REQUEST:<br />';
//	print_r($_REQUEST);
//	
    }
    
    
    public function connector() {
	
	if(isset($_POST['cmd']) && $_POST['cmd'] == 'upload' ) {
	    $this->clearThumbs(PUBLICDIR.'useruploads/.tmb/');
	}
	
	vendor::load('elfinder/connector');
	
	
	$opts = array(
	    'debug' => true,
	    'bind' => array(
		'mkdir mkfile rename rm paste' => 'removeUnallowedFiles'
	    ),
	    'roots' => array(
		array(
		    'mimeDetect'    => 'internal',
		    'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
		    'path'          => PUBLICDIR.'useruploads/',         // path to files (REQUIRED)
		    'URL'           => dirname($_SERVER['PHP_SELF']) . 'public/useruploads/', // URL to files (REQUIRED)
		    'alias'	    => 'Home',
		    'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)
		    'uploadOrder'   => 'deny, allow',
		    'uploadDeny'    => array('all'),
		    'uploadAllow'   => array('image','application/pdf', 'pdf'),
		    'attributes' => array(
			array( // hide readmes
			    'pattern' => '/(README|PHP|php|sh|exe|bin|bat)/',
			    'read' => false,
			    'write' => false,
			    'hidden' => true,
			    'locked' => true
			),
			array( // restrict access to png files
			    'pattern' => '/\.(php|png|sh|bat|bin|exe)$/',
			    'write' => false,
			    'locked' => true
			)
		    )
		)
	    )
	);

	
	
	// run elFinder
	$connector = new elFinderConnector(new elFinder($opts));
	$connector->run();
	
	
    }
    
    
    public function clearThumbs($dir) {
	
	#echo 'Clean: '. $dir;
	
	foreach (scandir($dir) as $item) {
	    if ($item == '.' || $item == '..') continue;
	    unlink($dir.DIRECTORY_SEPARATOR.$item);
	}
    }
    
    
    
    
    // cmd=open&target=&init=1&tree=1&_=1343377592666
    
    
    

}

?>
