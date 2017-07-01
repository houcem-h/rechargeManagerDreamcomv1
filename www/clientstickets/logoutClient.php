<?php
session_start();
require_once 'class/clients.class.php';
$client = new Client();

if(!$client->is_logged_in())
{
 $client->redirect('index');
}

if($client->is_logged_in()!="")
{
 $client->logout();
 $client->redirect('index');
}
?>
