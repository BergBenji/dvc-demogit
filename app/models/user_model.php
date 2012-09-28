<?php
/**
 * Description of user_model
 * 
 * @author BergBenji
 */
class user_model extends model {

    function __construct() {
	parent::__construct();
    }
      
    public function userList() {
	return $this->db->select('SELECT * FROM sys_login');
    }
    
    public function userSingleList($id) {
	return $this->db->selectSingle('SELECT * FROM sys_login WHERE loginid =:id', array('id' => $id));
    }
    
    public function create($data) {
	$postdata = array(
	    'login' => $data['login'],
	    'password' => hash::create($data['password'], 'sha256',SaltHash),
	    'role' => $data['role']
	);
	return $this->db->insert('sys_login', $postdata);
    }
    
    public function editSave($id)
    {
	$postData = array(
	    'login' => $_POST['login'],
	    'password' => hash::create($_POST['password'], 'sha256',SaltHash),
	    'role' => $_POST['role'],
	);
	return $this->db->update('sys_login', $postData, 'loginid = '.$id);
    }
    
    public function delete($id)
    {
	$data = $this->db->selectSingle('SELECT role FROM sys_login where loginid = :id', array('id' => $id));
	if($data['role'] == 'owner') 
	    return false;
	return $this->db->delete('sys_login', array('loginid' => $id));
    }
    
}