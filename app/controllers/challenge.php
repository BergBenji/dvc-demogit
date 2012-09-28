<?php
/**
 * Description of challenge
 *
 * @author BergBenji
 */
class challenge extends baseController {

    function __construct()
    {
	parent::__construct();
    }
    
    public function index()
    {
	    header('Location: /');
    }
    
    public function show($challengeid = NULL, $extend = NULL)
    {
	$activeSolution = NULL;
	
	if($challengeid == NULL) header('Location: /');		// Wenn keine Challengeid vorhanden zurück zum Dashboard
	
	$challenge = $this->model->loadChallenge($challengeid);	// Challenge laden
	
	if(!$challenge) header('Location: /');		// Wenn keine Challengeid vorhanden zurück zum Dashboard
	
	// Solution Laden
	if($extend !== NULL) {
	    $activeSolution = $extend[0];
	    $solution = $this->loadModel('solution')->loadSolutionObject($challengeid, $activeSolution);
	    
	    if($solution === false) $activeSolution = NULL;
	}
	
	if($activeSolution == NULL) {
	    // Get first solution if one exists!
	    $activeSolution = NULL;
	    $solution = $this->loadModel('solution')->loadSolutionObject($challengeid, NULL);
	    
	    if($solution !== false) $activeSolution = $solution->id;
	} 

	$this->view->challenge			= $challenge;	// Challenge Object an View übergeben
	$this->view->persons			= $this->loadModel('person')->loadPersonas($challengeid);		// Personen Object an View übergeben
	$this->view->allSolutions		= $this->loadModel('solution')->loadAllSolutions($challengeid, $activeSolution); // Alle solutions laden für drop down liste! und an View übergeben
	$containers				= $this->loadModel('containers')->loadSolutionContainer($activeSolution);	// alle Solutions laden	
	$this->view->containercount		= count($containers);   // Anzahl der Spalten der activen Solution an View übergeben
	$this->view->solutionContainer		= $containers;   // active Solution Container/Spalten an View übergeben
	$this->view->solution			= $solution; // Aktive Solution an View übergeben
	$this->view->archetypecats		= $this->loadModel('archetypes')->loadArcheTypeCats(); // Archetpe Kategorien an View übergeben
	$this->view->challengeNotesFiles	= $this->loadModel('notes')->loadChallengeNotesFiles($challengeid); // Challenge Notes und Files an View übergeben
	$this->view->challengeBattlefieldFiles	= $this->loadModel('battlefield')->loadChallengeBattlefieldFiles($challengeid);	// Challenge Battlefield an View übergeben
	$this->view->render('challenge/show');	// Template Rendern!
    }
    
    public function edit($id)
    {
	$data = $this->model->loadChallengeDetails($id);
	echo json_encode($data);
    }
    
    public function save()
    {
	$data = $_POST['challenge'];
	$this->model->saveChallenge($data);
    }
    
    public function destroy($id)
    {
	$this->model->removeChallenge($id);
    }
    
    public function fileUpload()
    {
	$targetDir = PUBLICDIR.'challenge_files/challenge/';
	$uploader = new pluploader();
	$uploader->setTargetPath($targetDir)
		 ->addSuccessCall(array('challenge::addFile'))
		 ->startUpload();
    }
    
    public static function addFile($filename)
    {
	$challenge_id = $_POST['challenge_id'];
	$type = $_POST['area'];
	
	$c = new controller(false);
	$file = 'challenge/'.$filename;
	$params = array('where' => 'id = '.$challenge_id);
	$params['img'] = $file;
	$c->loadModel('challenge')->updateChallenge($params);
    }
    
    
    
    
    
//    
//    public function addSortArcheType() {
//	$sid = $_POST['group'];
//	$order = $_POST['order'];
//	$data = explode(',', $order);
//	$this->model->deleteArchitype2solutioncontainer($sid);
//	$x=1;
//	foreach($data as $k => $v) {
//	    $this->model->addArchitype2solutioncontainer($sid, $v, $x);
//	    $x++;
//	}
//    }
    
    
//    private function getChallenge($cid) {
//	$data = $this->model->loadChallenge($cid);
//	if(empty($data)) return false;
//	
//	$data = new helperChallenge($data[0]);
//	return $data;
//    }
//    
//    public function getArcheTypeCats()
//    {
//	$data = $this->model->loadArchetypeCats();
//	if($data === false) return 0;
//
//	$out = array();
//	foreach($data as $k => $v)
//	    $out[] = new helperChallengeArchetypecats($v);
//
//	return $out;
//    }
    
//    public function getContainerDetails($id) {
//	$this->view->displaytype = 1;
//	$this->view->archetype = array('getContainerHeadline' => $this->getContainerHeadline($id));
//	$this->view->archetypes = $this->getContainerArchetypes($id);
//	$this->view->render('challenge/archetype');
//    }
    
    
//    public function getContainerArchetypes($cid)
//    {
//	$data = $this->model->loadContainerArchetypes($cid);
//	
//	if($data === false) return '0';
//	$out = array();
//	foreach($data as $k => $v)
//	    $out[] = new helperChallengeArchetype($v);
//	return $out;
//    }
//    
//    
//    function getContainerHeadline($cid)
//    {
//	
//	$data = $this->model->loadContainerHeadline($cid);
//	if($data === false) return 0;
//	$out = array();
//	$out['title'] = $data[0]['title'];
//	$out['info'] = $data[0]['info'];
//	return $out;
//
//    }
    
//    public function setContainerOrder()
//    {
//	$order = $_POST['order'];
//	$orderarray = explode(',',$order);
//	if(is_array($orderarray) && !empty($order)) {
//	    $x=1;
//	    foreach($orderarray as $k => $v) {
//		$this->model->setContainerOrder($x, $v);
//		$x++;
//	    }
//	}
//    }
    
    
//    public function getSolutionContainer($id) {
//	$c = $this->model->loadSolutionContainer($id);
//	return $c;
//    }
    
    
//    public function saveContainer() {
//	$data = $_POST['solutioncontainer'];
//	$this->model->saveContainer($data);
//    }
    
//    public function getContainerDetail($id) {
//	$data = $this->model->loadContainerDetail($id);
//	echo json_encode($data[0]);
//    }
    
    
//    public function getPersonas($id) {
//	$data = $this->model->loadPersonas($id);
//	if(empty($data)) return 0;
//	foreach($data as $k => $v)
//	    $personas[] = (object) $v;
//	return $personas;
//    }
    
    
//    public function filterarchetypes() {
//	$str = $_POST['string'];
//	$data = $this->model->loadarchetypeFilter($str);
//	if($data === false) {
//	    echo 'alert("No searchresult exists");';
//	    return 0;
//	}
//	
//	$idstoshow = array();
//	foreach($data as $k => $v) {
//	    $idstoshow[] = $v['id'];
//	}
//	
//	echo json_encode($idstoshow);
//    }
    
    
//    public function getArchetypeDetail($id) {
//	$data = $this->model->loadArchetype($id);
//	$at =  new helperChallengeArchetype($data[0]);
//	
//	$data = $at;
//	$data->image = $data->image();
//	$data->title = $data->title();
//	
//	echo json_encode($at);
//    }
    
    
    
//    public function getArcheTypes()
//    {
//	$data = $this->model->getArchetypes();
//	if(empty($data)) return 0;
//	
//	$out = array();
//	foreach($data as $k => $v) {
//	    $out[] = new helperChallengeArchetype($v);
//	}
//	
//	$this->view->archetypes = $out;
//	$cont = $this->view->render('challenge/show', 'archetype', false);
//	
//	echo "	$('body > section#archetypes > article > ul').html(".str_replace(array("\t", "\n", '\t','\n'), '', json_encode(($cont))).");
//		reinit_drags();
//		$('body > section#archetypes .archetype a[rel]').defaultOverlay();
//		$('#loading_overlay .close').trigger('click');
//		";
//	exit; 
//	return $out;
//	
//    }
    

//    public function savePerson() {
//	$data = $_POST['person'];
//	$this->model->savePerson($data);
//    }
//    
//    public function getPersonDetail($id) {
//	$data = $this->model->loadPersonDetails($id);
//	echo json_encode($data);
//    }    

    
    
    
//    public function saveNotes() {
//	$data = array();
//	$data['where'] = 'id = '.$_POST['challengenotes']['id'];
//	$data['notes'] = $_POST['challengenotes']['notes'];
//	$this->model->updateChallenge($data);
//    }
//    
//    public function saveBattlefield() {
//	$data = $_POST['challengebattlefield'];
//	$data['where'] = 'id = '.$data['id'];
//	unset($data['id']);
//	$this->model->updateChallenge($data);
//    }
//    
//    public function saveInfo() {
//	$data = $_POST['challengeinfo'];
//	$data['where'] = 'id = '.$data['id'];
//	unset($data['id']);
//	$this->model->updateChallenge($data);
//    }
 
    
    
    
//    
//    public function setrating($sid) {
//	$this->model->setRating($sid, $_POST['val']);
//    }
//    

    
    
//    public function getAllSolutions($id, $active = NULL)
//    {
//	$data = $this->model->loadAllSolutions($id);
//	foreach($data as $k => $v) {
//	    if($v['id'] == $active) {
//		$data[$k]['ischecked'] = 1;
//	    }
//	    else {
//		$data[$k]['ischecked'] = 0;
//	    }
//	}
//	return $data;
//    }
    
//    public function getSolution($id, $sid) {
//	
//	$data = $this->model->loadSolution($id, $sid);
//	
//	if(empty($data)) 
//	    return false;
//
//	$solution = (object)$data[0];
//	$solution->rating = $this->getSolutionRating($solution);
//	
//	return $solution;
//    }
//    
//    public function getSolutionRating($solution) {
//	if(isset($solution->rating) && $solution->rating !='') {
//	    return round($solution->rating); 
//	} else {
//	    return 0;
//	}
//    }
    
    
//    public function saveSolution() {
//	$data = $_POST['solution'];
//	echo json_encode(array('url' => $this->model->saveSolution($data)) );
//    }
//    
//    public function getSolutionDetail($sid) {
//	$data = $this->model->loadSolution(NULL, $sid);
//	echo json_encode($data[0]);
//    }
    
    
}