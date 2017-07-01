<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/commandes.class.php';
$commande = new Commande();
$user_home = new USER();
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
    <title>Starter Template for Bootstrap 3.3.7</title>
    <link rel="shortcut icon" href="dreamcom.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <?php include 'style.html'; ?>

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
            <br><br>
            <figure>
        <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
    </figure>
           <br>
           <a href="gererCommandes">
           <button type="button" class="btn btn-warning">
               <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Retour
            </button>
          </a>
          <fieldset>
              <legend>Détails de la commande N°<strong><?php echo $_GET['id_comm']; ?></strong></legend>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Quantité</th>
                    <th>Valeur</th>
                    <th>Total ligne</th>
                    <th>ID commande</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              if (isset($_GET['id_comm'])) {
                $ligneComm = $commande->affichLigneCommande($_GET['id_comm']);
                if($ligneComm->rowCount()>0){
                  while ($ligne=$ligneComm->fetch(PDO::FETCH_ASSOC)) {
                    extract($ligne);
                    echo "<tr>";
                    echo "<td>".$ligne['id']."</td>";
                    echo "<td>".$ligne['quantite']."</td>";
                    echo "<td>".$ligne['valeur']."</td>";
                    echo "<td>".$ligne['totalLigne']."</td>";
                    echo "<td>".$ligne['idCommande']."</td>";
                    echo "</tr>";
                  }
                }
              }
              ?>
            </tbody>
          </table>
          </fieldset>
          <?php include 'footer.html' ?>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
