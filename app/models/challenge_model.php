<?php
/**
 * Description of challenge_model
 * 
 *
 * @author BergBenji
 */
class challenge_model extends model {

    function __construct() 
    {
	parent::__construct();
    }
    
    public function loadChallenge($id) 
    {
	$SQL = 'SELECT * FROM sys_challenges WHERE id=:id LIMIT 1';
	$data = $this->db->select($SQL, array('id' => $id));
	if(empty($data)) return false;
	
	$data = new helperChallenge($data[0]);
	return $data;
    }
    
    public function loadAllChallenges() {
	$SQL = 'SELECT * FROM sys_challenges WHERE deleted = 0 ORDER BY ch_date';
	return $this->db->select($SQL);
    }
    
    public function saveSolution($data) 
    {	
	$cid = $data['challenge_id'];
	if(isset($data['solution_id']) && $data['solution_id'] != 0) {
	    //UPDATE
	    $sid = $data['solution_id'];
	    $data['where'] = 'id = '.$sid;
	    unset($data['solution_id'], $data['challenge_id']);
	    $this->db->update('sys_solution', $data, '');
	} else {
	    // INSERT
	    unset($data['solution_id']);
	    $this->db->insert('sys_solution', $data);
	    $sid = $this->db->lastInsertId();
	}
	return '/challenge/show/'.$cid.'/'.$sid;
    }
    
    public function updateChallenge($data) 
    {
	return $this->db->update('sys_challenges', $data, '');
    }
    
    public function addFile($table, $data) 
		{
	$this->db->insert($table, $data);
    }
    
    public function saveChallenge($data) 
    {
	if(isset($data['id']) && $data['id'] != 0) {
	    //UPDATE
	    $data['where'] = 'id = '.$data['id'];
	    unset($data['id']);
	    $this->db->update('sys_challenges', $data, '');
	} else {
	    //ADD
	    unset($data['id']);
	    $this->db->insert('sys_challenges', $data);
	    return $this->db->lastInsertId();
	}
    }
    
    public function loadChallengeDetails($id)
    {
	$SQL = 'SELECT * FROM sys_challenges WHERE id = :id ORDER by cr_date';
	return $this->db->selectSingle($SQL, array('id'=>$id));
    }
    
    public function removeChallenge($id) 
    {
	$this->db->update('sys_challenges', array('where' => 'id = '.$id, 'deleted' => 1), '');
    }
}



//    public function getArchetypes() {
//	$SQL = 'SELECT	A.id, 
//			A.image, 
//			A.module as title, 
//			B.title as category, 
//			B.icon as catimg,
//			B.id as catid,
//			C.title as typename, 
//			C.id as typeid
//		 FROM 
//		    sys_mods A
//		 LEFT JOIN 
//		    sys_mods_cat B
//		 ON 
//		    A.cat_id = B.id
//		 LEFT JOIN 
//		    sys_mods_type C
//		 ON 
//		    A.type_id = C.id
//		 WHERE 
//		    A.deleted = 0
//		 ORDER BY
//		    A.module';
//	return $this->db->select($SQL);
//    }
//    
    
    
//    
//    
//    public function saveContainer($data) {
//	$cid = $data['container_id'];
//	$sid = $data['solution_id'];
//	
//	if($cid != 0) {
//	    // UPDATE
//	    unset($data['container_id'], $data['solution_id']);
//	    $data['where'] = 'id = '.$cid;
//	    $this->db->update('sys_solution_container', $data, '');
//	} else {
//	    // INSERT
//	    unset($data['container_id']);
//	    $this->db->insert('sys_solution_container', $data);
//	}
//    }
//    
//    
//    
//    public function loadContainerDetail($id) {
//	$SQL = 'SELECT * FROM sys_solution_container where id = :id';
//	return $this->db->select($SQL, array('id' => $id));
//    }

    
    
//    public function setRating($sid, $val) {
//	$this->db->update('sys_solution', array('where' => 'id = '.$sid, 'rating' => $val),'');
//    }
    
    
    
    
    
    
    
//    public function loadPersonDetails($id) {
//	$SQL = 'SELECT * FROM sys_person where id = :id';
//	return $this->db->selectSingle($SQL, array('id' => $id));
//    }
    
//    public function savePerson($data) {
//	
//	$challenge_id = $data['challenge_id'];
//	unset($data['challenge_id']);
//	
//	if(isset($data['id']) && $data['id'] != 0) {
//	    //UPDATE
//	    $data['where'] = 'id = '.$data['id'];
//	    unset($data['id']);
//	    $this->db->update('sys_person', $data, '');
//	} else {
//	    //ADD
//	    unset($data['id']);
//	    $this->db->insert('sys_person', $data);
//	    $id = $this->db->lastInsertId();
//	    $this->db->insert('sys_person2challenge', array('challenge_id' => $challenge_id, 'person_id' => $id));    
//	}
//    }
    
    
//    
    
    
    
//    public function loadAllSolutions($id) {
//	$SQL = 'SELECT * FROM sys_solution where challenge_id=:cid ORDER BY id DESC';
//	$data = $this->db->select($SQL, array('cid'=>$id));
//	if($data === false) return 0;
//	
//	return $data;
//    }
    
    
    
//    public function loadSolution($id, $sid = NULL) {
//	if($sid !== NULL) {
//	    $SQL = 'SELECT * FROM sys_solution where id=:id ORDER BY id DESC LIMIT 1';
//	    $data = $this->db->select($SQL, array('id'=>$sid));
//	} else {
//	    $SQL = 'SELECT * FROM sys_solution where challenge_id=:cid ORDER BY id DESC LIMIT 1';
//	    $data = $this->db->select($SQL, array('cid'=>$id));
//	}
//	
//	if($data === false) return 0;
//	
//	return $data;
//    }
//    
    
    
//    public function loadArchetype($id) {
//	$SQL = 'SELECT	A.id, A.image, A.module as title, A.tech_func as functext, A.benefit, A.keywords, A.type_id, A.complexity,
//			B.title as category, B.icon as catimg,B.id as catid,
//			C.title as typename, C.id as typeid
//		 FROM 
//		    sys_mods A
//		 LEFT JOIN 
//		    sys_mods_cat B
//		 ON 
//		    A.cat_id = B.id
//		 LEFT JOIN 
//		    sys_mods_type C
//		 ON 
//		    A.type_id = C.id
//		 WHERE 
//		    A.deleted = 0 AND
//		    A.id = :aid
//		 ORDER BY
//		    A.module
//		 LIMIT 1';
//	$data = $this->db->select($SQL, array('aid' => $id));
//	return $data;
//    }
//    
//    
//    public function loadarchetypeFilter($str) {
//	$SQL = 'SELECT A.id FROM  
//		    sys_mods A
//		LEFT JOIN 
//		    sys_mods_type B
//		ON 
//		    A.type_id = B.id
//		WHERE
//		    A.tech_func LIKE :sstring OR
//		    A.benefit LIKE :sstring OR
//		    A.module LIKE :sstring OR
//		    A.keywords LIKE :sstring OR
//		    B.title LIKE :sstring
//		GROUP BY A.id';
//	return $this->db->select($SQL, array('sstring' => '%'.$str.'%'));
//    }
    
    
    
    
    
//    public function loadPersonas($id) {
//	$SQL = 'SELECT * FROM 
//		    sys_person2challenge A 
//		LEFT JOIN 
//		    sys_person B 
//		ON 
//		    A.person_id = B.id
//		WHERE 
//		    A.challenge_id=:cid ';
//	$data = $this->db->select($SQL, array('cid' => $id));
//	
//	if(empty($data)) return 0;
//	
//	return $data;
//	
//	
//    }
    
    
    
    
    
    
    
    
    
//    public function loadContainerArchetypes($cid) {
//	
//	$SQL = 'SELECT	A.id, 
//			A.image, 
//			A.module as title, 
//			A.tech_func as functext, 
//			A.benefit, 
//			A.keywords, 
//			A.type_id, 
//			A.complexity,
//			B.title as category, 
//			B.icon as catimg,
//			B.id as catid,
//			C.title as typename, 
//			C.id as typeid
//		 FROM 
//		    sys_mods A
//		 LEFT JOIN 
//		    sys_mods_cat B
//		 ON 
//		    A.cat_id = B.id
//		 LEFT JOIN 
//		    sys_mods_type C
//		 ON 
//		    A.type_id = C.id
//		 LEFT JOIN
//		    sys_architype2solutioncontainer D
//		 ON
//		    A.id=D.archetype_id
//		 WHERE 
//		    A.deleted = 0 AND
//		    D.solutioncontainer_id = :cid
//		 ORDER BY
//		    A.module';
//	return $this->db->select($SQL, array('cid' => $cid));
//    }
//    
//    public function loadContainerHeadline($cid)
//    {
//	$SQL = 'SELECT title, info FROM sys_solution_container WHERE id = :id';
//	return $this->db->select($SQL, array('id'=>$cid));
//    }
//    
    
    
    
    
    
    
    
//
//    
//    
//    public function deleteArchitype2solutioncontainer($gid) {
//	$this->db->delete('sys_architype2solutioncontainer', array('solutioncontainer_id' => $gid), 1000);
////	$SQL = 'DELETE FROM sys_architype2solutioncontainer WHERE solutioncontainer_id = :groupid';
////	#echo $SQL.' -> '. $group;
////	dbcon::prep($SQL, array('groupid' => $group));
////	dbcon::execute('',__FILE__,__LINE__);
//    }
//
//    public function addArchitype2solutioncontainer($sid, $aid, $sorting) {
//	$this->db->insert('sys_architype2solutioncontainer', array('solutioncontainer_id' => $sid, 'archetype_id' => $aid, 'sorting' => $sorting));
////	$SQL = 'INSERT INTO sys_architype2solutioncontainer SET solutioncontainer_id = :groupid, archetype_id = :archid, sorting=:sorting';
//    }
//    
