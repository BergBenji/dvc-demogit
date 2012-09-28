<?php
/**
 * Description of solution_model
 * 
 *
 * @author BergBenji
 */
class solution_model extends model {

    function __construct()
    {
	parent::__construct();
    }

    public function loadSolution($id, $sid = NULL)
    {
	if($sid !== NULL) {
	    $SQL = 'SELECT * FROM sys_solution where id=:id ORDER BY id DESC LIMIT 1';
	    $data = $this->db->select($SQL, array('id'=>$sid));
	} else {
	    $SQL = 'SELECT * FROM sys_solution where challenge_id=:cid ORDER BY id DESC LIMIT 1';
	    $data = $this->db->select($SQL, array('cid'=>$id));
	}
	
	if($data === false) return 0;
	
	return $data;
    }
    
    public function loadAllSolutions($id, $active = NULL)
    {
	$SQL = 'SELECT * FROM sys_solution where challenge_id=:cid ORDER BY id DESC';
	$data = $this->db->select($SQL, array('cid'=>$id));
	if($data === false) return 0;
	
	foreach($data as $k => $v) {
	    if($v['id'] == $active) {
		$data[$k]['ischecked'] = 1;
	    }
	    else {
		$data[$k]['ischecked'] = 0;
	    }
	}
	return $data;
    }
    
    public function loadSolutionObject($id, $sid)
    {
	$data = $this->loadSolution($id, $sid);
	if(empty($data)) 
	    return false;

	$solution = (object)$data[0];
	$solution->rating = $this->getSolutionRating($solution);
	
	return $solution;
    }
    
    public function getSolutionRating($solution)
    {
	if(isset($solution->rating) && $solution->rating !='') {
	    return round($solution->rating); 
	} else {
	    return 0;
	}
    }
    
    public function setRating($sid, $val)
    {
	$this->db->update('sys_solution', array('where' => 'id = '.$sid, 'rating' => $val),'');
    }
}