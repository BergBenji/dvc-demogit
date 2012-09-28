<?php

class dashboard_model extends model {

    function __construct() {
	parent::__construct();
    }
    
    function addData()
    {
	$this->db->insert('databox', array('data' => $_POST['text']));
    }

    function delRow()
    {
	$this->db->delete('databox', array('id' => $_POST['id']));
	echo 'success';
    }
}