<?php
/**
 * Description of archetype_model
 * 
 *
 * @author BergBenji
 */
class archetypes_model extends model {

    function __construct()
    {
	parent::__construct();
    }
    
    public function loadarchetypeFilter($str)
    {
	$SQL = 'SELECT A.id FROM  
		    sys_mods A
		LEFT JOIN 
		    sys_mods_type B
		ON 
		    A.type_id = B.id
		WHERE
		    A.tech_func LIKE :sstring OR
		    A.benefit LIKE :sstring OR
		    A.module LIKE :sstring OR
		    A.keywords LIKE :sstring OR
		    B.title LIKE :sstring
		GROUP BY A.id';
	return $this->db->select($SQL, array('sstring' => '%'.$str.'%'));
    }
    
    public function loadArchetype($id)
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
		 WHERE 
		    A.deleted = 0 AND
		    A.id = :aid
		 ORDER BY
		    A.module
		 LIMIT 1';
	$data = $this->db->select($SQL, array('aid' => $id));
	return $data;
    }
    
    public function getArchetypes()
    {
	$SQL = 'SELECT	A.id, 
			A.image, 
			A.module as title, 
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
		 WHERE 
		    A.deleted = 0
		 ORDER BY
		    A.module';
	return $this->db->select($SQL);
    }
    
    public function loadArcheTypeCats()
    {
	$SQL = 'SELECT * FROM sys_mods_cat order by id';
	$data = $this->db->select($SQL);
	
	if($data === false) return 0;

	$out = array();
	foreach($data as $k => $v)
	    $out[] = new helperChallengeArchetypecats($v);

	return $out;
    }   
}