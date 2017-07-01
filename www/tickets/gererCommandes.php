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
    <title>Commandes</title>
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
           <a href="newCommande">
           <button type="button" class="btn btn-warning">
               <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nouvelle commande
            </button>
          </a>
          <?php
          if (isset($_GET['id_comm'])) {
            $reactivation = $commande->reactiverCommande($_GET['id_comm']);
            if(!empty($reactivation)){
            ?>
            <div class="alert alert-success alert-dismissable fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              Réactivation de la commande <strong><?php echo $_GET['id_comm']; ?></strong> Effectuée avec succès !
            </div>
            <?php
          }
        }
          ?>
          <fieldset>
              <legend>Liste des commandes</legend>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Etat</th>
                    <th>Valeur</th>
                    <th>Client</th>
                    <th>Opérations</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              $data = $commande->affichCommande();
              if($data->rowCount()>0){
                while ($ligne=$data->fetch(PDO::FETCH_ASSOC)) {
                  extract($ligne);
                  if ($ligne['etat']=='En cours') {
                    echo "<tr class=\"bg-success\">";
                  }
                  elseif ($ligne['etat']=='Reactivee') {
                    echo "<tr class=\"bg-warning\">";
                  }
                  else {
                    echo "<tr>";
                  }
                  echo "<td>".$ligne['id']."</td>";
                  echo "<td>".$ligne['dateComm']."</td>";
                  echo "<td>".$ligne['etat']."</td>";
                  echo "<td>".$ligne['valeur']."</td>";
                  echo "<td><a href=\"modifClient?edit_id=".$idClient."\">".$idClient."</a></td>";
                  echo '<td><a href="detailsCommande?id_comm='.$ligne['id'].'"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Détails"></span></a>';
                  if ($ligne['etat']=='Imprimee') {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<a href="?id_comm='.$ligne['id'].'" onclick="return confirm(\'Etes vous sûre de vouloir réactiver la commande '.$ligne['id'].' ?\')" data-toggle="tooltip" data-placement="top" title="Réactiver"><span class="glyphicon glyphicon-retweet" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Réactiver"></span></a>';
                  }
                  else {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<span class="glyphicon glyphicon-retweet" aria-hidden="true" data-toggle="tooltip" title="Réactiver"></span>';
                  }
                  echo "</td>";
                  echo "</tr>";
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
