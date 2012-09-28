<?php
/**
 * Description of archetypes
 * 
 *
 * @author BergBenji
 */
class archetypes extends baseController {

    function __construct()
    {
	parent::__construct();
    }

    public function index()
    {
	$data = $this->model->getArchetypes();
	if(empty($data)) return 0;
	
	$out = array();
	foreach($data as $k => $v) {
	    $out[] = new helperChallengeArchetype($v);
	}
	
	$this->view->archetypes = $out;
	$cont = $this->view->render('challenge/show', 'archetype', false);
	
	echo "	$('body > section#archetypes > article > ul').html(".str_replace(array("\t", "\n", '\t','\n'), '', json_encode(($cont))).");
		reinit_drags();
		$('body > section#archetypes .archetype a[rel]').defaultOverlay();
		$('#loading_overlay .close').trigger('click');";
	exit;
    }

    public function show($id = NULL)
    {
	if($id == NULL) {
	    $str = $_POST['string'];
	    $data = $this->model->loadarchetypeFilter($str);
	    if($data === false) {
		echo 'alert("No searchresult exists");';
		return 0;
	    }

	    $idstoshow = array();
	    foreach($data as $k => $v) {
		$idstoshow[] = $v['id'];
	    }
	    echo json_encode($idstoshow);
	} else {
	    // show detail of single
	    $data = $this->model->loadArchetype($id);
	    $data = new helperChallengeArchetype($data[0]);
	    $data->image = $data->image();
	    $data->title = $data->title();
	    echo json_encode($at);
	}
    }
}

?>
