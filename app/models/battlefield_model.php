<?php
/**
 * Description of battlefield_model
 * 
 *
 * @author BergBenji
 */
class battlefield_model extends model {

    function __construct()
    {
	parent::__construct();
    }

    public function loadChallengeBattlefieldFiles($id)
    {
	$SQL = 'SELECT filename FROM sys_battlefield_files WHERE challenge_id = :id ORDER by cr_date';
	
	$data = $this->db->select($SQL, array('id'=>$id));
	
	if($data === false) return 0;
	
	$out = array();
	foreach ($data as $k => $v) {
	    $out[] = new helperChallengefile($v);
	}
	
	return $out;
    }
    
    public function addFile($table, $data) {
	$this->db->insert($table, $data);
    }
}