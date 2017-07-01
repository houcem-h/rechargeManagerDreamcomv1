<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/commandes.class.php';
require_once 'class/clients.class.php';
$user_home = new USER();

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
        <title>Nouveau client</title>
        <link rel="shortcut icon" href="dreamcom.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <?php include 'style.html'; ?>
        <style media="screen">
          fieldset{margin: 0 20%;}#boutonAffichTous{margin-left: 20%;}
        </style>
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
            <figure>
                <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
            </figure>
            <br>
            <a id="boutonAffichTous" href="gererRecharges">
                <button type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Afficher l'état des stocks
                </button><br>
            </a>
            <br>
            <!--Upload d'un nouveau fichier txt ou csv dans le serveur et insertion dans le base de données-->
            <fieldset id="new">
                <legend>Ajouter un nouveau fichier de codes de recharges</legend>
                <form action="uploadFile.php" method="post" enctype="multipart/form-data" class="form-horizontal col-xs-6">
                    <div class="form-group">
                        <label for="sel1">Opérateur:</label>
                        <select class="form-control" id="sel1" name="operator" disabled>
                            <option selected value="orange">Orange</option>
                            <option value="tt">Tunisie Telecom</option>
                            <option value="oreedoo">Oreedoo</option>
                            <option value="lyca">Lyca Mobile</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="" for="csvFile">Fichier de recharges:</label>
                        <input type="file" name="csvRecharge" class="form-control" id="csvFile" required>
                    </div>
                    <input type="submit" class="btn btn-warning" value="Valider">
                </form>
            </fieldset>
            <!--fin de upload d'un nouveau fichier txt ou csv dans le serveur et insertion dans le base de données-->

            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
