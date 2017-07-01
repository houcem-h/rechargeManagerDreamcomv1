<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/commandes.class.php';
require_once 'class/clients.class.php';
$user_home = new USER();
$commande = new Commande();

#test sur la session pour afficher le nom de l'utilisateur dans le navbar
if(!$user_home->is_logged_in()){
    $user_home->redirect('index');
}
$stmt = $user_home->execReq("SELECT * FROM users WHERE id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
    <!DOCTYPE html>
    <html lang="">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Traitement commande</title>
        <link rel="shortcut icon" href="dreamcom.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <?php include 'style.html'; ?>
        <style>
            body {padding-top: 50px;padding-bottom: 50px;}fieldset{margin: 0 20%;}#boutonAffichTous{margin-left: 20%;}.starter-template {padding: 40px 15px;text-align: center;}</style>
        <script type="text/javascript" src="js/perso.js">

        </script>

        <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body>
        <div class="container">
            <!--nav-->
            <?php include 'navbar.php'; ?>
            <!--end nav-->
            <br>
            <center>
              <figure>
                  <img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px">
              </figure>
              <br>
              <h3>Traitement de la commande en cours ... veuillez patienter</h3>
              <img src="gears.gif" alt="loading">
            </center>
            <?php
            /*$idComm = $_GET['id_comm'];
            $dateComm = $_GET['date_comm'];
            $client = $_GET['client'];
            //recupération de l'ID du client qui a passé la commande
            $sql = 'SELECT * FROM customers WHERE name = :comm_idClt';
            $stmt = $commande->execReq($sql);
            $stmt->bindparam(":comm_idClt",$client);
            $stmt->execute();
            if($stmt->rowCount()>0){
              while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
                extract($ligne);
                $idClient = $ligne['id'];
              }
            }
            //---------------------------------
            $vlr=0;
            if (isset($_GET['qte1'])) {
              $qte1 = $_GET['qte1'];
              $vlr1 = 1;
              $totLigne1= ($qte1*1);
              $vlr+= ($qte1*1);
            }
            if (isset($_GET['qte2'])) {
              $qte2 = $_GET['qte2'];
              $vlr2 = 5;
              $totLigne2= ($qte2*5);
              $vlr+= ($qte2*5);
            }
            if (isset($_GET['qte3'])) {
              $qte3 = $_GET['qte3'];
              $vlr3 = 10;
              $totLigne3= ($qte3*10);
              $vlr+= ($qte3*10);
            }
            //insertion de la nouvelle commande
            $commande->ajoutCommande($idComm,$dateComm,$vlr,$idClient);
            //création d'une ligne de la recharge de 1dt
            if (isset($qte1)) {
              $commande->ajoutLigneCommande($idComm,$qte1,$vlr1,$totLigne1);
              //recupération de l'ID de la nouvelle ligne commande insérée
              $sql = 'SELECT * FROM lignecommande WHERE idCommande = :lignecom_id AND valeur = :lignecom_vlr';
              $stmt = $commande->execReq($sql);
              $stmt->bindparam(":lignecom_id",$idComm);
              $stmt->bindparam(":lignecom_vlr",$vlr1);
              $stmt->execute();
              if($stmt->rowCount()>0){
                while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
                  extract($ligne);
                  $idligne1 = $ligne['id'];
                }
              }
            }
            //création d'une ligne de la recharge de 5dt
            if (isset($qte2)) {
              $commande->ajoutLigneCommande($idComm,$qte2,$vlr2,$totLigne2);
              //recupération de l'ID de la nouvelle ligne commande insérée
              $sql = 'SELECT * FROM lignecommande WHERE idCommande = :lignecom_id AND valeur = :lignecom_vlr';
              $stmt = $commande->execReq($sql);
              $stmt->bindparam(":lignecom_id",$idComm);
              $stmt->bindparam(":lignecom_vlr",$vlr2);
              $stmt->execute();
              if($stmt->rowCount()>0){
                while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
                  extract($ligne);
                  $idligne2 = $ligne['id'];
                }
              }
            }
            //création d'une ligne de la recharge de 10dt
            if (isset($qte3)) {
              $commande->ajoutLigneCommande($idComm,$qte3,$vlr3,$totLigne3);
              //recupération de l'ID de la nouvelle ligne commande insérée
              $sql = 'SELECT * FROM lignecommande WHERE idCommande = :lignecom_id AND valeur = :lignecom_vlr';
              $stmt = $commande->execReq($sql);
              $stmt->bindparam(":lignecom_id",$idComm);
              $stmt->bindparam(":lignecom_vlr",$vlr3);
              $stmt->execute();
              if($stmt->rowCount()>0){
                while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
                  extract($ligne);
                  $idligne3 = $ligne['id'];
                }
              }
            }
            //importation des lignes de recharges de la table recharge vers la table lot
            if (isset($qte1)) {
              $commande->ajoutLotLigneCommande($idligne1,$vlr1,$qte1);
            }

            if (isset($qte2)) {
              $commande->ajoutLotLigneCommande($idligne2,$vlr2,$qte2);
            }

            if (isset($qte3)) {
              $commande->ajoutLotLigneCommande($idligne3,$vlr3,$qte3);
            }

          header('Location:gererCommandes.php');*/
            ?>
            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/trt_cmd.js"></script>
    </body>

    </html>
