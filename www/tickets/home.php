<?php
session_start();
require_once 'class/users.class.php';
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
    <title>Accueil</title>
    <link rel="shortcut icon" href="dreamcom.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <?php include 'style.html'; ?><?php include 'footer.html' ?>
    <!--<style>body{padding-top:50px;max-width:1100px;margin:auto;padding-bottom: 70px;}.starter-template{padding:40px 15px;text-align:center;}</style>*/

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <div class="container"
    <!--nav-->
<?php include 'navbar.php'; ?>
    <!--end nav-->
    <br><br><br>
    <figure>
        <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px">
        </center>
    </figure>
    <br><br>
    <!--panels-->
        <div class="panel-group">
           <div class="raw">
             <?php if ($row['role']=='boss') {
               ?>
               <!-- panel du personnem -->
             <div class="col-md-4">
              <div class="panel panel-warning">
               <div class="panel-heading text-center">
                   <span class="glyphicon glyphicon-knight btn-lg" aria-hidden="true"></span><h2 style="display:inline-block;">Personnel</h2>
                </div>
                <div class="panel-body">
                    Accéder à la section de gestion du personnel :
                    <ul>
                        <li>Ajouter un nouvel agent, modifier, valider, supprimer</li>
                        <li>etc.</li>
                    </ul>
                    <br>
                    Cliquer sur le bouton ci-dessous.
                </div>
                <div class="panel-footer text-center">
                   <a href="gererCommandes">
                    <button type="button" class="btn btn-warning">Accéder à la page du personnel</button>
                    </a>
                </div>
                </div>
          </div>
          <!-- fin du panel des clients -->
          <?php
        } ?>
          <!-- panel des recharges -->
              <div class="col-md-4">
                  <div class="panel panel-warning">
                   <div class="panel-heading text-center">
                       <span class="glyphicon glyphicon-credit-card btn-lg" aria-hidden="true"></span><h2 style="display:inline-block;">Recharge</h2>
                    </div>
                    <div class="panel-body">
                        Accéder à la section de gestion des recharges :
                        <ul>
                            <li>Ajouter un nouveau fichier</li>
                            <li>Afficher un état</li>
                            <li>etc.</li>
                        </ul><br>
                        Cliquer sur le bouton ci-dessous.
                    </div>
                    <div class="panel-footer text-center">
                        <a href="gererRecharges">
                            <button type="button" class="btn btn-warning">Accéder à la page recharges</button>
                        </a>
                    </div>
                    </div>
              </div>
              <!-- fin du panel des recharges -->
              <!-- ********************************** -->
              <!-- panel des tickets -->
            <div class="col-md-4">
                  <div class="panel panel-warning">
                   <div class="panel-heading text-center">
                       <span class="glyphicon glyphicon-duplicate btn-lg" aria-hidden="true"></span><h2 style="display:inline-block;">Tickets</h2>
                    </div>
                    <div class="panel-body">
                        Accéder à la section de gestion des tickets :
                        <ul>
                            <li>Afficher les tickets, imprimer, modifier, supprimer</li>
                            <li>Afficher un état</li>
                            <li>etc.</li>
                        </ul>
                        Cliquer sur le bouton ci-dessous.
                    </div>
                    <div class="panel-footer text-center">
                        <a href="gererClients">
                            <button type="button" class="btn btn-warning">Accéder à la page des tickets</button>
                        </a>
                    </div>
                    </div>
              </div>
              <!-- fin du panel des tickets -->
              <?php if ($row['role']<>'vendeur') {
                ?>
              <!-- panel des clients -->
            <div class="col-md-4">
                  <div class="panel panel-warning">
                   <div class="panel-heading text-center">
                       <span class="glyphicon glyphicon-user btn-lg" aria-hidden="true"></span><h2 style="display:inline-block;">Clients</h2>
                    </div>
                    <div class="panel-body">
                        Accéder à la section de gestion des clients :
                        <ul>
                            <li>Ajouter un nouveau client, modifier, supprimer</li>
                            <li>Afficher un état</li>
                            <li>etc.</li>
                        </ul>
                        Cliquer sur le bouton ci-dessous.
                    </div>
                    <div class="panel-footer text-center">
                        <a href="gererClients">
                            <button type="button" class="btn btn-warning">Accéder à la page clients</button>
                        </a>
                    </div>
                    </div>
              </div>
              <!-- fin panel des clients -->
              <!-- panel des commandes -->
                 <div class="col-md-4">
                  <div class="panel panel-warning">
                   <div class="panel-heading text-center">
                       <span class="glyphicon glyphicon-list-alt btn-lg" aria-hidden="true"></span><h2 style="display:inline-block;">Commandes</h2>
                    </div>
                    <div class="panel-body">
                        Accéder à la section de gestion des commandes :
                        <ul>
                            <li>Ajouter une nouvelle commande, modifier, valider, supprimer</li>
                            <li>etc.</li>
                        </ul>
                        Cliquer sur le bouton ci-dessous.
                    </div>
                    <div class="panel-footer text-center">
                       <a href="gererCommandes">
                        <button type="button" class="btn btn-warning">Accéder à la page commandes</button>
                        </a>
                    </div>
                    </div>
              </div>
              <!-- fin du panel des commandes -->
              <?php
            } ?>
           </div>

        </div>
    <!--end panels-->
<?php include 'footer.html' ?>
  </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
