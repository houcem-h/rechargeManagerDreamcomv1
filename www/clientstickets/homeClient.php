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
    <title>Bievenue chez Dreamcom-Recharge</title>
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
          <fieldset>
              <legend>Liste de mes commandes en cours</legend>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID commande</th>
                    <th>Date</th>
                    <th>Etat</th>
                    <th>Valeur</th>
                    <th>Opérations</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              $data = $commande->affichCommandeClient($_SESSION['clientSession']);
              $nbEnCours = 0;
              if($data->rowCount()>0){
                while ($ligne=$data->fetch(PDO::FETCH_ASSOC)) {
                  extract($ligne);
                  if ($ligne['etat']=='En cours') {
                    $nbEnCours++;
                    echo "<tr>";
                    echo "<td>".$ligne['id']."</td>";
                    echo "<td>".$ligne['dateComm']."</td>";
                    echo "<td>".$ligne['etat']."</td>";
                    echo "<td>".$ligne['valeur']."</td>";
                    echo '<td><a href="detailsCommandeClient?id_comm='.$ligne['id'].'" data-toggle="tooltip" data-placement="top" title="Détails"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a>';
                    echo '&nbsp;&nbsp;&nbsp;<a href="imprimerCommande?id_comm='.$ligne['id'].'" data-toggle="tooltip" data-placement="top" title="Télécharger"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a></td>';
                    echo "</tr>";
                  }
                }
              }
              if ($nbEnCours == 0) {
                echo '<tr><td class="text-center" colspan="5">Vous n\'avez aucune commande en cours</td></tr>';
              }
              ?>
            </tbody>
          </table>
          </fieldset>
          <br><br>
          <fieldset>
              <legend>Historique de mes commandes</legend>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID commande</th>
                    <th>Date</th>
                    <th>Etat</th>
                    <th>Valeur</th>
                    <th>Opérations</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              $data = $commande->affichCommandeClient($_SESSION['clientSession']);
              if($data->rowCount()>0){
                while ($ligne=$data->fetch(PDO::FETCH_ASSOC)) {
                  extract($ligne);
                  if ($ligne['etat']!='En cours') {
                    echo "<tr>";
                    echo "<td>".$ligne['id']."</td>";
                    echo "<td>".$ligne['dateComm']."</td>";
                    echo "<td>".$ligne['etat']."</td>";
                    echo "<td>".$ligne['valeur']."</td>";
                    echo '<td><a href="detailsCommandeClient?id_comm='.$ligne['id'].'" data-toggle="tooltip" data-placement="top" title="Détails"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a>';
                    if ($ligne['etat']=='Imprimee'){
                      echo '&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-download" aria-hidden="true"></span>';
                    }
                    else {
                      echo '&nbsp;&nbsp;&nbsp;<a href="imprimerCommandeHistorique?id_comm='.$ligne['id'].'" data-toggle="tooltip" data-placement="top" title="Télécharger"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';
                    }

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
