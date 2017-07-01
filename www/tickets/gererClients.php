<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/clients.class.php';
$user_home = new USER();
$displayClt = new Client();

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
        <title>Clients</title>
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
            <br>
            <br>
            <figure>
                <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
            </figure>
            <br>
            <a href="newClt">
                <button type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nouveau client
                </button><br>
            </a>
            <?php
            if (isset($_GET['supp_id'])) {
              $suppression = $displayClt->supprimClient($_GET['supp_id']);
              if(!empty($suppression)){
              ?>
              <div class="alert alert-danger alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Suppression Effectuée avec succès !
              </div>
              <?php
            }
          }
            ?>
            <fieldset>
                <legend>Liste des clients</legend>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Téléphone</th>
                      <th>Etat</th>
                      <th>Opérations</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php
                $data = $displayClt->affichClient();
                if($data->rowCount()>0){
                  while ($ligne=$data->fetch(PDO::FETCH_ASSOC)) {
                    extract($ligne);
                    if ($ligne['etat']!='Y') {
                      echo "<tr class=\"bg-danger\">";
                    }
                    else {
                      echo "<tr>";
                    }
                    echo "<td>".$ligne['id']."</td>";
                    echo "<td>".$ligne['name']."</td>";
                    echo "<td>".$ligne['email']."</td>";
                    echo "<td>".$ligne['tel']."</td>";
                    ($ligne['etat']=='Y')?$st='Actif':$st='Inactif';
                    echo "<td>".$st."</td>";
                    echo "<td><a href=\"modifClient?edit_id=".$ligne['id']."\" onclick=\"return confirm('Editer ce client ?')\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Modifier\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a>";
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo "<a href=\"?supp_id=".$ligne['id']."\" onclick=\"return confirm('Etes vous sûre de vouloir supprimer ce client ?')\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Supprimer\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></a></td>";
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
