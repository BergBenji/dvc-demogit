<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of form_example
 * 
 *
 * @author BergBenji
 */
class form_example {

    function __construct() {
	
    }
    
    
    
    
    
    function validateForm()
    {
	
	$form = new form();		// Init new Form Object
	$form
	    ->post('fieldname')		// Add a variable from Post Form
	    ->val('minlength', 3)	// Check the min length
	    ->val('maxlength', 19)	// Check the max length
	    ->val('length', 3, 19)	// check min and max length
	    ->val('digit')		// check if value is digit
	    ->val('alphadigit')		// check is value is alpha digit
	    ->val('minimum', 10)	// checks if value is min x
	    ->val('maximum', 100)	// checks if value is max x
	    ->val('contains','string1;string2;string3;etc');	// check is value contains one of the stringparts string1 or string2 etc..
	$form
	    ->post('other_field')
	    ->val('minlength', 12)
	    ->post('fieldthree')
	    ->val('digit');

	try {
	    $form->submit(); // initialize the validation routines
	    
	    $fieldname = $form->fetch('fieldname'); // value wich is secured through the Form class
	    $other_field = $form->fetch('other_field'); // value wich is secured through the Form class
	    $fieldthree = $form->fetch('fieldthree'); // value wich is secured through the Form class
	    $formvalues = $form->fetch(); // array('fieldname' => 'value, 'other_field' => 'value2', 'fieldthree' => '121');
	    
	} catch (Exception $exc) {
	    $error_keys = $form->fetchErrors('keys'); // Only the keys
	    $error = $form->fetchErrors('full'); // Keys with full description
	}
	
	
    }

}

?>
