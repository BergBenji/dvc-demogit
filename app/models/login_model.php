<?php

class login_model extends model {

    public function __construct()
    {
	parent::__construct();
    }
    
    public function run($form)
    {	
	$sth = $this->db->prepare("SELECT loginid, role FROM sys_login WHERE login= :login AND password = :password");
	$sth->execute(array(
		'login' => $form->fetch('login'), 
		'password'=>hash::create($form->fetch('password'), 'sha256',SaltHash)
	    ));
	$count = $sth->rowCount();
	
	if($count) {
	    // login
	    $data = $sth->fetch();
	    session::set('loggedIn', true);
	    session::set('role', $data['role']);
	    header('location: /dashboard');
	} else {
	    header('location: /login');
	}
    }
}