<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbox_model
 * 
 *
 * @author BergBenji
 */
class dbox_model extends model {

    function __construct() {
	parent::__construct();
    }
    
    
    public function getCategories() {
	$SQL = 'SELECT * FROM sys_mods_cat';
	return $this->db->select($SQL);
    }
    
    
    public function getValueByTitle($title) {
	$SQL = 'SELECT * FROM sys_mpds where title=:title';
	return $this->db->select($SQL, array('title' => $title));
    }
    
    
    

}

?>
