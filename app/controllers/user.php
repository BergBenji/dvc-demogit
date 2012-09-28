<?php

class user extends controller {

    function __construct() {
	parent::__construct();
	
	/** Checks if user is logged in **/
	if(!session::get('loggedIn')) {
	    header('location: /login');
	    exit();
	}
	
	$this->loadModel(__CLASS__);
	
	
	
    }
    
    
    
    
    public function index() {
	
	$this->view->userlist = $this->loadmodel(__CLASS__)->userList();
	$this->view->render('user/index');
    }
    
    
    function logout()
    {
	session::destroy();
	header('location: /');
	
    }
    
   
    
    
    public function create() {
	if($this->model->create($_POST)) {
	    header('location: /user');
	}
	
    }
    
    public function edit($id)
    {
	// FetchUser by ID
	$u = $this->model->userSingleList($id);
	
	
	$this->view->user = $u;
	$this->view->render('user/edit');
    }
    
    public function editSave($id) {
	if($this->model->editSave($id)) {
	    header('location: /user');
	}
	
    }
    
    
    
    
    public function delete($id)
    {
	$this->model->delete($id);
	header('location: /user');
    }

    

}
