<?php
$form = new Form_Handler_User(!$user->exists() || !empty($_POST['password']) ? true : false);
$form->validate();
$errors = $form->errors();
if ($errors) {
	$pm->setVariable('errors', $errors);
	$pm->setVariable('user', $form->input());
} else {
	$user->setArray($_POST, false);
	$user['password'] = $_POST['password'];
	$user->save();
	Typeframe::Redirect('User saved.', Typeframe::CurrentPage()->applicationUri());
}
