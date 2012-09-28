<?php
/**
 * Description of tracker_model
 * 
 *
 * @author BergBenji
 */
class tracker_model extends model {

    function __construct()
    {
	parent::__construct();
    }

    public function addTrack()
    {
	/**
	$qstring = implode('/',$_POST);
	$SQL .= "('".
	 * date("Y-m-d H:i:s")."',
	 * '".$useragent."',
	 * '".$referer."',
	 * '".$_SERVER['REMOTE_ADDR']."',
	 * '".$_SERVER['SCRIPT_FILENAME']."',
	 * '".$_SERVER['REQUEST_URI']."',
	 * '".$qstring."',
	 * '".$_SERVER['REQUEST_METHOD']."');";
	 */
	$referer = (!isset($_SERVER['HTTP_REFERER'])) ? 'not set' : $_SERVER['HTTP_REFERER'] ;
	$useragend = (!isset($_SERVER['HTTP_USER_AGENT'])) ? 'not set' : $_SERVER['HTTP_USER_AGENT'] ;

	$insert = array(
	    'useragent'	=> $useragend,
	    'referer'	=> $referer,
	    'ip'	=> $_SERVER['REMOTE_ADDR'],
	    'filename'	=> $_SERVER['SCRIPT_FILENAME'],
	    'requesturi'=> $_SERVER['REQUEST_URI'],
	    'querystr'	=> 'Post: '.print_r($_POST, true)."\n".'GET: '.print_r($_GET, true),
	    'method'	=> $_SERVER['REQUEST_METHOD'],
	    'loginstatus'	=> 'none'
	);
	
	$this->db->insert('sys_trackertab', $insert);	
    }
}