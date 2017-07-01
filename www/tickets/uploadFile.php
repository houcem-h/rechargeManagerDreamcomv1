<?php
    require_once 'class/recharge.class.php';
    
    $uploadFichier = new Recharge();
    $uploadFichier->uploaderFichier($_FILES['csvRecharge']);
?>