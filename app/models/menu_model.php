<?php

class menu_model extends model {

    var $menu, $level, $menusrc;
    
    
    function __construct() {
	parent::__construct();
    }
    
    
    
    public function getMenuItems() {
	$array = array('status' => 'visible');
	$SQL = 'SELECT * FROM pages WHERE status = :status order by pid, sorting';
	$this->menusrc = $this->db->select($SQL, $array);
//	$ret = $this->buildMenuArray();
//	#$ret = $this->showmenu();
//	$this->reformatMenu();
	#echo '<pre>';
	$ret = $this->fetchMenus();
	
	
	
//	print_r($ret);
////	
	
	
	return $ret;
    }
   
    
    public function fetchMenus() {
	// Select all entries from the menu table
	#$result=mysql_query("SELECT id, label, link, parent FROM menu ORDER BY parent, sort, label");
	// Create a multidimensional array to conatin a list of items and parents
	
	$menuItems = $this->db->select('SELECT id, status, title, pid FROM pages ORDER BY pid, sorting, title');
	
	$newMenu = array();
	foreach($menuItems as $k => $v) {
	    $newMenu[$v['id']] = $v;
	}
	$menuItems = $newMenu;
	// Each node starts with 0 children
	foreach ($menuItems as &$menuItem)
	    $menuItem['Children'] = array();
	

	// If menu item has ParentID, add it to parent's Children array    
	foreach ($menuItems as $id => &$menuItem)
	{
	    if (isset($menuItem['pid']) && $menuItem['pid'] != null) {
		$menuItems[$menuItem['pid']]['Children'][$id] = &$menuItem;
	    }
	}

	
	
	
	// Remove children from $menuItems so only top level items remain
	foreach (array_keys($menuItems) as $id)
	{
	    if (isset($menuItems[$id]) && isset($menuItems[$id]['pid']) && $menuItems[$id]['pid'] != '0') {
		unset($menuItems[$id]);
	    }
	}
	
	unset($menuItems['0']);
	
	
	return $menuItems;
    }
    
    
    
    

}

?>
