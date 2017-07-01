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
        <style>body {padding-top: 50px;padding-bottom: 50px;}fieldset{margin: 0 20%;}#boutonAffichTous{margin-left: 20%;}.starter-template {padding: 40px 15px;text-align: center;}</style>
        <?php include 'style.html'; ?>
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
            <a id="boutonAffichTous" href="gererTickets">
                <button type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Afficher l'historique des tickets
                </button><br>
            </a>
            <br>
            <fieldset id="imprimer"><!--créer un fichier pdf pour impression des tickets de recharges-->
                <legend>Imprimer des tickets de recharges </legend>
                <form action="apercuImpression" method="post" class="form-horizontal col-xs-6">
                    <div class="form-group">
                        <label for="vlr">Valeur du ticket:</label>
                        <select class="form-control" id="vlr" name="valeur">
                            <option value="-- Choisir la valeur --">-- Choisir la valeur --</option>
                            <option value="1dt">1 dinar</option>
                            <option value="5dt">5 dinars</option>
                            <option value="10dt">10 dinars</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="qte">Nombre de lots :</label>
                        <input type="number" class="form-control" id="qte" name="qte" required placeholder="Saisir le nombre de lot de recharge à imprimer">
                    </div> -->
                    <div class="form-group">
                        <label for="qte">Quantité à imprimer :</label>
                        <input type="number" class="form-control" id="qte" name="qte" required placeholder="Saisir la quantité de recharge par lot à imprimer">
                    </div>
                    <div class="form-group">
                      <button type="reset" class="btn btn-default">Annuler</button>
                      <button type="submit" name="btajout" class="btn btn-warning">Valider</button>
                    </div>
                </form>
            </fieldset><!--fin de la création d'un fichier pdf pour impression des tickets de recharges-->
            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
