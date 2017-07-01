<?php
session_start();
require_once 'class/users.class.php';
$user = new USER();

if(!$user->is_logged_in())
{
 $user->redirect('index');
}

if($user->is_logged_in()!="")
{
 $user->logout(); 
 $user->redirect('index');
}
?>