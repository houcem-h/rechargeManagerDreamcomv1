<?php
session_start();
require_once 'class/clients.class.php';
require_once 'class/users.class.php';
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
            <a id="boutonAffichTous" href="gererClients">
                <button type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Afficher tous les clients
                </button><br>
            </a>
            <br>
            <fieldset>
                <legend>Ajouter un nouveau client

                    <?php
                        if(isset($_POST["btajout"])){
                            $newClient = new Client;
                            $nom = $_POST['nom'];
                            $email =  $_POST['email'];
                            $passwd = $_POST['pwd'];
                            $etat = $_POST['etat'];
                            $tel = $_POST['tel'];
                            $adr = $_POST['adr'];
                            $insertion = $newClient->ajoutNew($nom,$email,$passwd,$etat,$tel,$adr);
                            if(!empty($insertion)){
                    ?>
                        <div class="alert alert-success alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Nouveau client inséré avec succès !
                        </div>
                        <?php
                              }
                        }
                        ?>
                </legend>
                <form method="post" action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom et prénom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Adresse email" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mot de passe</label>
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">Téléphone(s)</label>
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="Numéro(s) de téléphone de contact" required>
                    </div>
                    <div class="form-group">
                        <label for="adr">Adresse</label>
                        <input type="text" class="form-control" id="adr" name="adr" placeholder="Adresse" required>
                    </div>
                    <div class="form-group">
                        <label for="etat">Etat</label>
                        <select name="etat" id="etat" class="form-control">
                            <option value="Y" checked>Actif</option>
                            <option value="N" checked>Inactif</option>
                        </select>
                    </div>
                    <button type="reset" class="btn btn-default">Annuler</button>
                    <button type="submit" name="btajout" class="btn btn-warning">Ajouter</button>
                </form>
            </fieldset>
            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
