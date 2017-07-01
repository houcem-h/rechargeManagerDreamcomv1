<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/tickets.class.php';

$user_home = new USER();
$ticket = new Tickets();
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
    <title>Tickets</title>
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
           <a href="newTicket">
           <button type="button" class="btn btn-warning" id="newImpress">
               <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nouvelle impression
            </button>
          </a>
          <?php
          if (isset($_GET['id_impress'])) {
            $reactivation = $ticket->reactiverTicket($_GET['id_impress']);
            if(!empty($reactivation)){
            ?>
            <div class="alert alert-success alert-dismissable fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              Réactivation de l'impression' <strong><?php echo $_GET['id_impress']; ?></strong> effectuée avec succès !
            </div>
            <?php
              }
            }
            if (isset($_GET['archiver_id']) && isset($_GET['id_ticket'])) {
              $ticket->ajoutLotLigneImpressionHistorique($_GET['id_ticket']);
              $ticket->archiverTicket($_GET['id_ticket']);
              ?>
              <div class="alert alert-success alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Dépelacement à l'archive de <strong><?php echo $_GET['id_ticket']; ?></strong> effectué avec succès !
              </div>
              <?php
                }
            ?>
            <div class="traitement" id="gears" style="display: none;">
                <center>
                    <h3>Traitement des tickets en cours ... veuillez patienter</h3>
                    <img src="gears.gif" alt="loading">
                </center>
            </div>
          <fieldset>
              <legend>Liste des tickets imprimés</legend>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date impression</th>
                    <th>Etat</th>
                    <th>Valeur</th>
                    <th>Agent</th>
                    <th>Opérations</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              $data = $ticket->affichTicket();
              if($data->rowCount()>0){
                while ($ligne=$data->fetch(PDO::FETCH_ASSOC)) {
                  extract($ligne);
                  if ($ligne['etat']=='En cours') {
                    echo "<tr class=\"bg-success\">";
                  }
                  elseif ($ligne['etat']=='Reactivee') {
                    echo "<tr class=\"bg-warning\">";
                  }
                  elseif ($ligne['etat']=='Imprimee') {
                    echo "<tr class=\"bg-info\">";
                  }
                  else {
                    echo "<tr>";
                  }
                  echo "<td>".$ligne['id']."</td>";
                  echo "<td>".$ligne['dateImpression']."</td>";
                  echo "<td>".$ligne['etat']."</td>";
                  echo "<td>".$ligne['valeur']."</td>";
                  echo "<td>";
                  if ($row['role']=='boss') {
                    echo "<a href=\"modifAgent?edit_id=".$ligne['idAgent']."\">".$ligne['idAgent']."</td>";
                  }else {
                    echo $ligne['idAgent']."</td>";
                  }
                  echo '<td><a href="detailsTicket?id_impress='.$ligne['id'].'"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Détails"></span></a>';
                  if (($ligne['etat']!='Imprimee')&&($ligne['etat']!='Archivee')) {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<a href="imprimerTicket?id_impress='.$ligne['id'].'" onclick="return confirm(\'Etes vous sûre de vouloir lancer le téléchargement de l\'impression '.$ligne['id'].' ?\')" data-toggle="tooltip" title="Télécharger" class="btnDownload"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';
                  }
                  else {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<span class="glyphicon glyphicon-download" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Télécharger"></span>';
                  }
                  if (($ligne['etat']=='Imprimee')&&($row['role']=='boss')) {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<a href="?id_impress='.$ligne['id'].'" onclick="return confirm(\'Etes vous sûre de vouloir réactiver l\'impression '.$ligne['id'].' ?\')" data-toggle="tooltip" title="Réactiver"><span class="glyphicon glyphicon-retweet" aria-hidden="true"></span></a>';
                  }
                  else {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<span class="glyphicon glyphicon-retweet" aria-hidden="true" data-toggle="tooltip" title="Réactiver"></span>';
                  }
                  if ($ligne['etat']=='Imprimee') {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<a href="?archiver_id='.$ligne['id'].'&id_ticket='.$ligne['id'].'" onclick="return confirm(\'Etes vous sûre de vouloir déplacer vers l\'archive '.$ligne['id'].' ?\')" data-toggle="tooltip" title="Archiver"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>';
                  }
                  else {
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo '<span class="glyphicon glyphicon-export" aria-hidden="true" data-toggle="tooltip" title="Archiver"></span>';
                  }
                  echo "</td>";
                  echo "</tr>";
                }
              }
              ?>
            </tbody>
          </table>
          </fieldset>
    </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <script src="js/preparePdf.js"></script>
</body>

</html>
