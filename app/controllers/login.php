<?php
/**
 * 
 */
class login extends baseController {

    function __construct()
    {
	parent::__construct();
	
	$this->loadModel(__CLASS__);
	
	if(session::get('loggedIn')) 
	    header('location: /dashboard');
    }
    
    function index()
    {
	$this->view->pagetitle = 'Login';
	$this->view->render('login/index');
    }
    
    function run()
    {
	$form = new form();
	$form->post('login')
		->val('minlength', 3)
		->post('password')
		->val('minlength', 5);

	try {
	    $form->submit();
	    $this->model->run($form);    
	} catch (Exception $exc) {
	    $this->view->errors = $exc->getMessage();
	    $this->view->pagetitle = 'Login';
	    $this->view->render('login/index');
	}
    }
}