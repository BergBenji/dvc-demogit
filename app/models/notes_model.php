<?php
/**
 * Description of notes_model
 * 
 *
 * @author BergBenji
 */
class notes_model extends model {

    function __construct()
    {
	parent::__construct();
    }

    public function loadChallengeNotesFiles($id)
    {
	$SQL = 'SELECT filename FROM sys_notes_files WHERE challenge_id = :id ORDER by cr_date';
	$data = $this->db->select($SQL, array('id'=>$id));
	
	if(empty($data)) {
	    return 0;
	}
	
	$out = array();
	foreach ($data as $k => $v) 
	    $out[] = new helperChallengefile($v);
	
	return $out;
    }	
    
    public function addFile($table, $data)
    {
	$this->db->insert($table, $data);
    }
}