<?php
/**
 * Description of containers_model
 * 
 *
 * @author BergBenji
 */
class containers_model extends model {

    function __construct()
    {
	parent::__construct();
    }
    
    public function setContainerOrder($pos, $cid)
    {
	$SQL = 'UPDATE sys_solution_container SET sorting = :order WHERE id = :containerid LIMIT 1';
	$data = array();
	$data['sorting'] = $pos;
	$data['where'] = 'id = '.$cid;
	return $this->db->update('sys_solution_container', $data, '');
    }
    
    public function saveContainer($data)
    {
	$cid = $data['container_id'];
	$sid = $data['solution_id'];
	
	if($cid != 0) {
	    // UPDATE
	    unset($data['container_id'], $data['solution_id']);
	    $data['where'] = 'id = '.$cid;
	    $this->db->update('sys_solution_container', $data, '');
	} else {
	    // INSERT
	    unset($data['container_id']);
	    $this->db->insert('sys_solution_container', $data);
	}
    }
    
    public function loadContainerDetail($id)
    {
	$SQL = 'SELECT * FROM sys_solution_container where id = :id';
	return $this->db->select($SQL, array('id' => $id));
    }
    
    public function loadSolutionContainer($gsid)
    {
	$SQL = 'SELECT * FROM sys_solution_container WHERE solution_id = :gsid order by sorting, id';
	$data = $this->db->select($SQL, array('gsid' => $gsid));

	if($data === false) return 0;

	$out = array();
	foreach($data as $k => $v) {
	    $v['archetype'] = array();
	    $SQL = 'SELECT 
			A.id, 
			A.image, 
			A.module as title, 
			B.title as category, 
			B.icon as catimg,
			B.id as catid,
			C.title as typename, 
			C.id as typeid
		    FROM 
			sys_architype2solutioncontainer D
		    LEFT JOIN
			sys_mods A
		    ON
			D.archetype_id = A.id
		    LEFT JOIN 
			sys_mods_cat B
		    ON 
			A.cat_id = B.id
		    LEFT JOIN 
			sys_mods_type C
		    ON 
			A.type_id = C.id
		    WHERE 
			A.deleted = 0 AND
			D.solutioncontainer_id = :scid
		    ORDER BY
			D.sorting';
	    $archetypes = $this->db->select($SQL, array('scid' => $v['id']));

	    if($archetypes !== false) {

	    foreach($archetypes as $key => $val)
		$v['archetype'][] = new helperChallengeArchetype($val);

	    }

	    $out[] = (object) $v;
	}
	return $out;
    }
    
    public function loadContainerArchetypes($cid)
    {
	$SQL = 'SELECT	A.id, 
			A.image, 
			A.module as title, 
			A.tech_func as functext, 
			A.benefit, 
			A.keywords, 
			A.type_id, 
			A.complexity,
			B.title as category, 
			B.icon as catimg,
			B.id as catid,
			C.title as typename, 
			C.id as typeid
		 FROM 
		    sys_mods A
		 LEFT JOIN 
		    sys_mods_cat B
		 ON 
		    A.cat_id = B.id
		 LEFT JOIN 
		    sys_mods_type C
		 ON 
		    A.type_id = C.id
		 LEFT JOIN
		    sys_architype2solutioncontainer D
		 ON
		    A.id=D.archetype_id
		 WHERE 
		    A.deleted = 0 AND
		    D.solutioncontainer_id = :cid
		 ORDER BY
		    A.module';
	$data = $this->db->select($SQL, array('cid' => $cid));
	if($data === false) return '0';
	$out = array();
	foreach($data as $k => $v)
	    $out[] = new helperChallengeArchetype($v);
	return $out;
    }
    
    public function loadContainerHeadline($cid)
    {
	$SQL = 'SELECT title, info FROM sys_solution_container WHERE id = :id';
	$data = $this->db->select($SQL, array('id'=>$cid));
	if($data === false) return 0;
	
	$out = array();
	$out['title'] = $data[0]['title'];
	$out['info'] = $data[0]['info'];
	return $out;
    }
     
    public function deleteArchitype2solutioncontainer($gid)
    {
	$this->db->delete('sys_architype2solutioncontainer', array('solutioncontainer_id' => $gid), 1000);
    }

    public function addArchitype2solutioncontainer($sid, $aid, $sorting)
    {
	$this->db->insert('sys_architype2solutioncontainer', array('solutioncontainer_id' => $sid, 'archetype_id' => $aid, 'sorting' => $sorting));
    }
}