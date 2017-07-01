<?php
session_start();
require_once 'class/users.class.php';
require_once 'class/commandes.class.php';
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
        <script type="text/javascript" src="js/perso.js">
        <style>#failure,#success,.traitement{display: none;}</style>

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
            <?php
            if (isset($_POST)) {
              if (($_POST['qte']>0 && $_POST['valeur'] <> '-- Choisir la valeur --')){
                $dateImp = $today = date("Y-m-d");;
                $agent = $_SESSION['userSession'];
                $nomprenom = $row['prenom'].' '.$row['nom'];
                $nomagent = explode(" ",$nomprenom);
                $codeImp = "";
                foreach ($nomagent as $value) {
                  $codeImp.= $value[0];
                }
                $date = getdate();
                $codeImp.=$date[0];
                ?>
                <fieldset>
                    <legend>
                        Aperçu de l'impression N° <strong><?php echo $codeImp; ?></strong>
                        <br>Date : <strong><?php echo $dateImp; ?></strong>
                    </legend>
                    <div class="traitement" id="gears" style="display: none;">
                        <center>
                            <h3>Traitement des tickets en cours ... veuillez patienter</h3>
                            <img src="gears.gif" alt="loading">
                        </center>
                    </div>
                    <div class="text-center  alert alert-success" id="success" style="display: none;">
                        Impression <strong><?php echo $codeImp; ?></strong> ajoutée avec succées !
                    </div>
                    <div class="text-center  alert alert-danger" id="failure" style="display: none;">
                        Une erreur est survenue lors de traitement de l'impression <strong><?php echo $codeImp; ?></strong>, veuillez réessayer de nouveau
                    </div>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Valeur</th>
                          <th>Quantité</th>
                          <th>Total(DT)</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php
                if (($_POST['qte']>0) && ($_POST['valeur'] <> '-- Choisir la valeur --')) {
                  $vlr = $_POST['valeur'];
                  $qte = $_POST['qte'];
                  ?>
                  <tr>
                    <td><?php echo $vlr; ?></td>
                    <td><?php echo $qte; ?></td>
                    <td><?php echo $vlr*$qte;?></td>
                  </tr>
                  <?php
                }
              }
              else {
                echo "<script>alert('Veuillez remplir tous les champs! ')</script>";
                header('Location:newTicket');
              }
            }else {
              header('Location:newTicket');
            }
            ?>
                <tr>
                    <td>
                        <a href="newTicket" onclick="return confirm('Etes vous sûre de vouloir annuler la commande ?')">
                            <button type="button" name="annuler" value="annuler" class="btn btn-default">Annuler</button>
                        </a>
                        <?php
                        //creation du lien vers la page de traitement de l'impression avec les paramètres de l'impression en $_GET
                        $balisea = "<a href=\"traitementImpress?id_impress=".$codeImp."&date_impress=".$dateImp."&qte=".$qte."&vlr=".$vlr;
                        $balisea.= "\" onclick=\"return confirm('Etes vous sûre de vouloir confirmer la création du fichier d'impression ?')\">";
                        ?>

                        <?php echo $balisea; //affichage du lien vers la page de traitement?>
                        <button type="button" name="confirmer" value="confirmer" class="btn btn-warning confirmation">Confirmer</button>
                        </a>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                      </tbody>
                    </table>
            </fieldset>
            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/trt_cmd.js "></script>
    </body>

    </html>
