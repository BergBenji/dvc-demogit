<?php
/**
 * Description of solution
 * 
 *
 * @author BergBenji
 */
class solution extends baseController {

    function __construct()
    {
	parent::__construct();
    }
    
    public function index()
    {
//	Show all exessible solutions for 1 Challenge
	$data = $this->model->loadAllSolutions($id);
	foreach($data as $k => $v) {
	    if($v['id'] == $active) {
		$data[$k]['ischecked'] = 1;
	    }
	    else {
		$data[$k]['ischecked'] = 0;
	    }
	}
	return $data;
    }
    
    public function show($id)
    {
	// show the selected solution
	$data = $this->model->loadSolution(NULL, $id);
	echo json_encode($data[0]);
    }
    
    public function update($id)
    {
	// Updates the solution
    }
    
    public function create($cid)
    {
	// creates a solution for the challenge
    }
    
    public function save()
    {
	$data = $_POST['solution'];
	echo json_encode(array('url' => $this->model->saveSolution($data)) );
    }
    
    public function setrating($sid)
    {
	$this->model->setRating($sid, $_POST['val']);
    }
}
    
 /*
  *     public function saveSolution() {
	    $data = $_POST['solution'];
	    echo json_encode(array('url' => $this->model->saveSolution($data)) );
	}
    
    public function getSolutionDetail($sid) {
	$data = $this->model->loadSolution(NULL, $sid);
	echo json_encode($data[0]);
    }
  */
