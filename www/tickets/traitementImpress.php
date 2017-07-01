<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/tickets.class.php';
$user_home = new USER();
$impression = new Tickets();

$stmt = $user_home->execReq("SELECT * FROM users WHERE id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
    $idImpress= $_GET['id_impress'];
    $dateImpress = $_GET['date_impress'];
    $agent = $_SESSION['userSession'];
    $vlr=(integer)$_GET['vlr'];
    $qte = $_GET['qte'];
    $totLigne= ($qte*$vlr);
    //insertion de la nouvelle impression
    $impression->ajoutTicket($idImpress,$dateImpress,$totLigne,$agent);
    //création d'une ligne de recharge
    $impression->ajoutLigneImpression($idImpress,$qte,$vlr,$totLigne);
    //recupération de l'ID de la nouvelle ligne impression insérée
    $sql = 'SELECT * FROM ligneimpression WHERE idimpressionTkt = :ligneimpress_id AND valeur = :ligneimpress_vlr';
    $stmt = $impression->execReq($sql);
    $stmt->bindparam(":ligneimpress_id",$idImpress);
    $stmt->bindparam(":ligneimpress_vlr",$vlr);
    $stmt->execute();
    if($stmt->rowCount()>0){
        while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
            extract($ligne);
            $idligne = $ligne['id'];
        }
    }
    //importation des lignes de recharges de la table recharge vers la table lot
    $ajoutligne = $impression->ajoutLotLigneImpression($idligne,$vlr,$qte);
sleep(2);
    header('Location:gererTickets');
    ?>