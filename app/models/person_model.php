<?php
/**
 * Description of person_model
 * 
 *
 * @author BergBenji
 */
class person_model extends model {

    function __construct()
    {
	parent::__construct();
    }
    
    public function loadPersonas($id)
    {
	$SQL = 'SELECT * FROM 
		    sys_person2challenge A 
		LEFT JOIN 
		    sys_person B 
		ON 
		    A.person_id = B.id
		WHERE 
		    A.challenge_id=:cid ';
	$data = $this->db->select($SQL, array('cid' => $id));
	
	if(empty($data)) return 0;
	
	return $data;
	
	
    }
    
    public function loadPersonDetails($id)
    {
	$SQL = 'SELECT * FROM sys_person where id = :id';
	return $this->db->selectSingle($SQL, array('id' => $id));
    }
    
    public function savePerson($data)
    {
	$challenge_id = $data['challenge_id'];
	unset($data['challenge_id']);
	
	if(isset($data['id']) && $data['id'] != 0) {
	    //UPDATE
	    $data['where'] = 'id = '.$data['id'];
	    unset($data['id']);
	    $this->db->update('sys_person', $data, '');
	} else {
	    //ADD
	    unset($data['id']);
	    $this->db->insert('sys_person', $data);
	    $id = $this->db->lastInsertId();
	    $this->db->insert('sys_person2challenge', array('challenge_id' => $challenge_id, 'person_id' => $id));    
	}
    }
}