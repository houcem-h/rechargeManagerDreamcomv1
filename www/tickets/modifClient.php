<?php
session_start();
require_once 'class/clients.class.php';
require_once 'class/users.class.php';
$user_home = new USER();
$displayClt = new Client;

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
        <title>Modifier client</title>
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
            <a id="boutonAffichTous" href="gererClients">
                <button type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Afficher tous les clients
                </button><br>
            </a>
            <br>
            <fieldset class="col-md-8">
                <legend>Modifier client

                    <?php
                        if(isset($_POST["btmodif"])){
                            $id = $_GET['edit_id'];
                            $nom = $_POST['nom'];
                            $email =  $_POST['email'];
                            $etat = $_POST['etat'];
                            $tel = $_POST['tel'];
                            $adr = $_POST['adr'];
                            $modification = $displayClt->modifClient($id,$nom,$email,$etat,$tel,$adr);
                            if(!empty($modification)){
                    ?>
                        <div class="alert alert-success alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Client modifié avec succès !
                        </div>
                        <?php
                                    }
                        }
                        $data = $displayClt->affichClientSpecifiq($_GET['edit_id']);
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
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom et prénom" required value="<?php echo $ligne['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Adresse email" required value="<?php echo $ligne['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tel">Téléphone(s)</label>
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="Numéro(s) de téléphone de contact" required value="<?php echo $ligne['tel']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="adr">Adresse</label>
                        <input type="text" class="form-control" id="adr" name="adr" placeholder="Adresse" required value="<?php echo $ligne['adresse']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="etat">Etat</label>
                        <select name="etat" id="etat" class="form-control">
                          <?php if($ligne['etat']=='Y'){
                            ?>
                            <option value="Y" checked>Actif</option>
                            <option value="N">Inactif</option>
                            <?php
                          }else{
                            ?>
                            <option value="N" checked>Inactif</option>
                            <option value="Y">Actif</option>
                            <?php
                          }
                          ?>

                        </select>
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
