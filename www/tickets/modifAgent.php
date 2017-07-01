<?php
session_start();
require_once 'class/clients.class.php';
require_once 'class/users.class.php';
$user_home = new USER();
$displayAgent = new USER();

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
        <title>Modifier agent</title>
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
            <br>
            <figure>
                <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
            </figure>
            <a id="boutonAffichTous" href="gererPersonnel">
                <button type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Afficher tous le personnel
                </button><br>
            </a>
            <br>
            <fieldset class="col-md-8">
                <legend>Modifier agent

                    <?php
                        if(isset($_POST["btmodif"])){
                            $id = $_GET['edit_id'];
                            $nom = $_POST['nom'];
                            $prenom = $_POST['prenom'];
                            $email =  $_POST['email'];
                            $modification = $displayAgent->modifAgent($id,$nom,$prenom,$email);
                            if(!empty($modification)){
                    ?>
                        <div class="alert alert-success alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Agent modifié avec succès !
                        </div>
                        <?php
                                    }
                        }
                        $data = $displayAgent->affichAgentSpecifiq($_GET['edit_id']);
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
                        <input type="text" class="form-control" id="nom" name="nom" required value="<?php echo $ligne['nom']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required value="<?php echo $ligne['prenom']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?php echo $ligne['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="role">Rôle</label>
                        <input type="text" class="form-control" id="role" name="role" required disabled value="<?php echo $ligne['role']; ?>">
                    </div>
                    <div class="form-group">
                      <button type="submit" name="btmodif" class="btn btn-warning">Enregistrer les modifications</button>
                    </div>
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
