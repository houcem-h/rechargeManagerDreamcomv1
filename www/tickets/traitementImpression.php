<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/tickets.class.php';
$user_home = new USER();
$impression = new Tickets();

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
        <title>Traitement Tickets</title>
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
              <h3>Traitement de l'impression en cours ... veuillez patienter</h3>
              <img src="gears.gif" alt="loading">
            </center>
            <?php
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

         header('Location:gererTickets.php');
            ?>
            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
