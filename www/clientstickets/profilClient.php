<?php
session_start();
require_once 'class/clients.class.php';
$client_home = new Client;

#test sur la session pour afficher le nom de l'utilisateur dans le navbar
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
        <title>Modifier client</title>
        <link rel="shortcut icon" href="dreamcom.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <style>body {padding-top: 50px;padding-bottom: 50px;}fieldset{margin: 0 20%;}#boutonAffichTous{margin-left: 20%;}.starter-template {padding: 40px 15px;text-align: center;}</style>
        <?php include 'style.html'; ?>

        <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body>
        <div class="container">
            <!--nav-->
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
            <br>
            <figure>
                <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
            </figure>
            <br>
            <fieldset class="col-md-8">
                <legend>Mon profil

                    <?php
                        if(isset($_POST["btmodif"])){
                            $id = $_SESSION['clientSession'];
                            if ((!empty($_POST['passwd'])) && (!empty($_POST['passwdC']))) {
                              if (($_POST['passwd']==$_POST['passwdC'])) {
                                $passwd =  $_POST['passwd'];
                              }
                              else {
                                ?>
                                <div class="alert alert-danger alert-dismissable fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Les mots de passes ne sont pas identiques !
                                </div>
                                <?php
                              }
                            }
                            else{
                              ?>
                              <div class="alert alert-danger alert-dismissable fade in">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Veuillez remplir tous les champs !
                              </div>
                              <?php
                            }
                            if (isset($passwd)) {
                              $modification = $client_home->modifProfil($id,$passwd);
                            }
                            if(!empty($modification)){
                    ?>
                        <div class="alert alert-success alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Profil modifié avec succès !
                        </div>
                        <?php
                                    }
                        }
                        $data = $client_home->affichClientSpecifiq($_SESSION['clientSession']);
                        if($data->rowCount()>0){
                          while ($ligne=$data->fetch(PDO::FETCH_ASSOC)) {
                            extract($ligne);
                        ?>
                </legend>
                <form method="post" action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="nom">ID</label>
                        <input type="text" class="form-control" id="id" name="id" disabled value="<?php echo $ligne['id']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" disabled value="<?php echo $ligne['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" disabled required value="<?php echo $ligne['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="passwd">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Nouveau mot de passe" required>
                    </div>
                    <div class="form-group">
                        <label for="passwdC">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="passwdC" name="passwdC" placeholder="Confirmer le nouveau mot de passe">
                    </div>
                    <div class="form-group">
                        <label for="tel">Téléphone(s)</label>
                        <input type="text" class="form-control" id="tel" name="tel" disabled value="<?php echo $ligne['tel']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="adr">Adresse</label>
                        <input type="text" class="form-control" id="adr" name="adr" disabled value="<?php echo $ligne['adresse']; ?>">
                    </div>

                    <button type="submit" name="btmodif" class="btn btn-warning">Enregistrer les modifications</button>
                </form>
                <?php
              }
            }
            ?>
            </fieldset>
            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
