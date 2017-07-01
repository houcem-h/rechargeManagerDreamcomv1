<?php
session_start();
require_once 'class/clients.class.php';
require_once 'class/commandes.class.php';
$commande = new Commande();
$client_home = new Client();
if(!$client_home->is_logged_in()){
    $client_home->redirect('index');
}
$stmt = $client_home->execReq("SELECT * FROM customers WHERE id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['clientSession']));
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
            <nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation">
                <div class="container">
                   <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="icon-user"></span>
                    <?php echo $row['name'];?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="logoutClient"><span class="glyphicon glyphicon-log-out"></span>Déconnexion</a>
                    </li>
                </ul>
            </li>
        </ul>
                    <div class="navbar-header">
                       <a class="navbar-brand" href="#">

                          </a>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="http://dreamcom.tn" style="margin:auto;">
                            <img style="float:left;" alt="Dreamcom" width="33px" height="33px;" src="dreamcom.png">
                        </a>
                        <a class="navbar-brand" href="#">Dreamcom - Recharge</a>
                    </div>

                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="homeClient">Accueil</a></li>
                            <li ><a href="profilClient">Mon profil</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!--end nav-->
            <br><br>
            <figure>
        <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
    </figure>
           <br>
           <a href="homeClient">
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
