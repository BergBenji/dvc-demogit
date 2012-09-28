<?php
/**
 * Description of containers
 * 
 *
 * @author BergBenji
 */
class containers extends baseController {

    function __construct()
    {
	parent::__construct();
    }

    public function index($id = NULL)
    {	// List all containers of 1 solution
	if ($id === NULL) {
	    $c = $this->model->loadSolutionContainer($id);
	    return $c;
	} else {
	    // get Container Details
	    $this->view->displaytype = 1;
	    $this->view->archetype = array('getContainerHeadline' => $this->model->loadContainerHeadline($id));
	    $this->view->archetypes = $this->model->loadContainerArchetypes($id);
	    $this->view->render('challenge/archetype');
	}
    }

    public function show($id)
    {   // get the details of the container
	$data = $this->model->loadContainerDetail($id);
	echo json_encode($data[0]);
    }

    public function update($action)
    {	// update the container with id X
	switch ($action) {
	    case 'setOrder':
		$this->setOrder();
		break;
	    default:
		break;
	}
    }

    public function save()
    {
	$data = $_POST['solutioncontainer'];
	$this->model->saveContainer($data);
    }

    public function create($challengeid)
    {	// Create a container for challengeid
    }

    public function destroy($id)
    {	// Removes the container with all archetypes.
    }

    public function updateOrder()
    {
	$sid = $_POST['group'];
	$order = $_POST['order'];
	$data = explode(',', $order);
	$this->model->deleteArchitype2solutioncontainer($sid);
	$x = 1;
	foreach ($data as $k => $v) {
	    $this->model->addArchitype2solutioncontainer($sid, $v, $x);
	    $x++;
	}
    }

    private function setOrder()
    {
	$order = $_POST['order'];
	$orderarray = explode(',', $order);
	if (is_array($orderarray) && !empty($order)) {
	    $x = 1;
	    foreach ($orderarray as $k => $v) {
		$this->model->setContainerOrder($x, $v);
		$x++;
	    }
	}
    }
}