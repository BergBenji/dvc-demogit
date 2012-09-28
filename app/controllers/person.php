<?php
/**
 * The Person class manage everything that have to do with persons!
 * 
 * 
 * @author BergBenji
 */
class person extends baseController {

    function __construct()
    {
	parent::__construct();
    }
    
    public function index($cid)
    {
	// List all persons from active challenge
	$data = $this->model->loadPersonas($cid);
	return (object) $data;
    }
    
    public function show($id)
    {
	// Show single person single person from active Challenge
	$data = $this->model->loadPersonDetails($id);
	echo json_encode($data);
    }
    
    public function edit($id)
    {
	// edit the person
    }
    
    public function destroy($id)
    {
	// removes the person and removes from challenge
    }
    
    public function update()
    {
	// Updates the person
	$data = $_POST['person'];
	$this->model->savePerson($data);
    }
    
    public function create($id)
    {
	// Creates the person and add it to Challenge
    }
}