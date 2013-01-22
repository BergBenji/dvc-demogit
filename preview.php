<?php

/**
 * Description of client
 * 
 *
 * @author BergBenji
 */
class client extends base_controller {
    
    public function __construct() {
	parent::__construct();
    }
    
    public function index() {
	$this->view->render('client/index');
    }
    
    public function show() {}
    
    
    public function addEinrichtung() {
	$data = $this->model->saveEinrichtung($_POST['einrichtung']);
    }
    
    public function dataexists() {
	$this->model->dataexists();
    }
    
    public function getgpasps() {
	$this->model->getAsps(session::get('uniqueid'));
    }
    
    public function getennumber() {
	$this->model->getennumber(session::get('uniqueid'));
    }
    
    public function getBetreuer($id = false) {
	if(isset($_POST['term'])) {
	    $term = $_POST['term'];
	} else {
	    $term = '';
	}
	$betreuer = $this->model->getBetreuer($term, $id);
	$response = new responder();
	$response->add('betreuer', $betreuer);
	echo $response->outSingle('betreuer');
	exit;
    }
    
    
    
    public function fetchSidebar() {
	$uid = session::get('uniqueid');
	
	$res = new responder();
	
	if($uid === false) {
	    $res->add('sidebar', '<h4>Noch keine Daten vorhanden</h4>');
	} else {

	    $data = $this->model->fetchsidebar($uid);
	    $return = '';
	    if(isset($data['stammdaten']) && !empty($data['stammdaten'])) {
		$this->view->stammdaten = $data['stammdaten'];
		$return .= $this->view->render('client/add/sidebar', 'stammdaten', false, false);
	    }

	    if(isset($data['einrichtungen']) && !empty($data['einrichtungen'])) {
		$this->view->einrichtungen = $data['einrichtungen'];
		$return .= $this->view->render('client/add/sidebar', 'einrichtungen', false, false);
	    }

	 
	    $res->add('sidebar', $return);
	}
	
	echo $res->outSingle('sidebar');
	exit;
    }
    
    
    
    
    public function save($step = array()) {
	if(session::get('uniqueid') == false) {
	    session::set('uniqueid', uniqid());
	    session::set(session::get('uniqueid').'/'.$step[0], 'Meine Stammdaten');
	} else {
	    session::set(session::get('uniqueid').'/'.$step[0], 'data');
	}
	$this->model->saveStep($step[0]);
	core::redirect($_POST['nextstep']);
    }
    
    
    
    
    public function create($step = array()) {
	if(empty($step)) {
	    // Set default form
	    unset($_SESSION['step']);
	    $uid = session::get('uniqueid');
	    if($uid !== false) {
		$this->resetForm();
	    }
	    
	    $step[0] = '1';
//	    session::set('uniqueid', uniqid());
	}
	
	
	
	switch ($step[0]) {
	    case '1':	// Render Form 1;
		    echo 'Stammdaten';
		    $uid = session::get('uniqueid');
		    if($uid !== false) {
			$data = $this->model->getStammdaten($uid);
			foreach($data as $k => $v) {
			    $k = 'sd_'.$k;
			    $this->view->$k = $v;
			}
		    }
		    $this->view->render('client/add/stammdaten');
		break;
	    
	    case '2':	// Render Form 2;
		    echo 'Einrichtungen';
		    $args = func_get_arg(0);
		    if(count($args) >=2) {
			// load existing with this id
			$id = $args[1];
			$data = $this->model->getEinrichtung($id);
			foreach($data as $k => $v) {
			    $k = 'er_'.$k;
			    $this->view->$k = $v;
			}
		    } else {
			// load clear form
		    }
		    if(session::get('uniqueid') && session::get(session::get('uniqueid').'/stammdaten') ) {
			$this->view->stammdaten = session::get(session::get('uniqueid').'/stammdaten');
		    }
		    
		    $this->view->branchen = $this->model->getBranchen();
		    $this->view->render('client/add/einrichtungen');
		break;
	    
	    case '3':	// Render Form 3;
		    echo 'Kennzahlen';
		// Fetch Einrichtungen
		    $data = $this->model->getEinrichtungen(session::get('uniqueid'));
		    if(!empty($data['einrichtungen']) ) {
			$this->view->einrichtungen = $data['einrichtungen'];
		    }
		    $this->view->render('client/add/kennzahlen');
		break;
	    
	    case '4':	// Render Form 4;
		    echo 'step4';
		
		    $data = $this->model->getEinrichtungen(session::get('uniqueid'));
		    if(!empty($data['einrichtungen']) ) {
			$this->view->stammdaten = $data['stammdaten'];
			$this->view->einrichtungen = $data['einrichtungen'];
			$this->view->einrichtungencount = count($data['einrichtungen']);
		    }
		    
		    // FINALIZE> Step - Remove Temp Anchor | Add User Passes | Send Mails.... (Remove Temp anchor!)
		    
		    
		    $this->view->render('client/add/kunde_angelegt');
		break;
	    
	    default:	// Render NOTHING;
		    echo 'default';
		break;
	}
	$var = sysservices::destroy_client('hello');
	
    }
    
    public function resetForm() {
	session::destroy(session::get('uniqueid').'/1');
	session::destroy(session::get('uniqueid').'/2');
	session::destroy(session::get('uniqueid').'/3');
	session::destroy(session::get('uniqueid').'/stammdaten');
	session::destroy('uniqueid');
	core::redirect('/client/create');
    }
    
    
    
    
    public function saveKennzahlen() {
	$this->model->addKennzahlen();
    }
    
    
    
    
    public function edit() {
	
    }
    
    public function destroy() {
	
    }
    
    public function update() {
	
    }
    
    public function check($param = array()) {
	$this->model->checkdata();
    }
    
    
}
