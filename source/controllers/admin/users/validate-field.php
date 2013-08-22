<?php
/*
	User Admin validate-field controller

	Validates the given field:value pairs
*/

// get field, value
$field = trim(@$_GET['field']);
$value = trim(@$_GET['value']);

// validate it
die(User::ValidateField($field, $value));
?>
