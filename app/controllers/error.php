<?php


class error extends controller {

    function __construct() {
	parent::__construct();
	$this->view->msg = 'This is my message...<br />';
	$this->view->render('error/index');
    }

}