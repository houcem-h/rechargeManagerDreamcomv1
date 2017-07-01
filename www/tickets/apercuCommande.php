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
        <script type="text/javascript" src="js/perso.js"></script>
        <style>.alert-danger,.alert-success,.traitement{display: none;}</style>

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
                <center>
                    <img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px">
                </center>
            </figure>
            <br>
            <?php
            if (isset($_POST)) {
              if (($_POST['qte1']>0 && $_POST['vlr1'] <> '-- Choisir la valeur --') || ($_POST['qte2']>0 && $_POST['vlr2'] <> '-- Choisir la valeur --') || ($_POST['qte3']>0 && $_POST['vlr3'] <> '-- Choisir la valeur --')){
                $dateCom = $_POST['date'];
                $client = $_POST['client'];
                $totalcommande = 0;
                $nomclt = explode(" ",$_POST['client']);
                $codeCom = "";
                foreach ($nomclt as $value) {
                  $codeCom.= $value[0];
                }
                $date = getdate();
                $codeCom.=$date[0];
                ?>
                <fieldset>
                    <legend>
                        Aperçu de la Commande N° <strong><?php echo $codeCom; ?></strong>
                        <br>Date : <strong><?php echo $dateCom; ?></strong>
                        <br> Client : <strong><?php echo $client; ?></strong>
                    </legend>
                    <div class="traitement" id="gears">
                        <center>
                            <h3>Traitement de la commande en cours ... veuillez patienter</h3>
                            <img src="gears.gif" alt="loading">
                        </center>
                    </div>
                    <div class="text-center  alert alert-success">
                        Commande <strong><?php echo $codeCom; ?></strong> ajoutée avec succées !
                    </div>
                    <div class="text-center  alert alert-danger">
                        Une erreur est survenue lors de traitement de la commande <strong><?php echo $codeCom; ?></strong>, veuillez réessayer de nouveau
                    </div>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Valeur</th>
                          <th>Quantité</th>
                          <th>Total ligne (DT)</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php
                if ($_POST['qte1']>0 && $_POST['vlr1'] <> '-- Choisir la valeur --') {
                  $vlr1 = $_POST['vlr1'];
                  $qte1 = $_POST['qte1'];
                  ?>
                  <tr>
                    <td><?php echo $vlr1; ?></td>
                    <td><?php echo $qte1; ?></td>
                    <td><?php echo $vlr1*$qte1; $totalcommande += $vlr1*$qte1;?></td>
                  </tr>
                  <?php
                }
                if ($_POST['qte2']>0 && $_POST['vlr2'] <> '-- Choisir la valeur --') {
                  $vlr2 = $_POST['vlr2'];
                  $qte2 = $_POST['qte2'];
                  ?>
                  <tr>
                    <td><?php echo $vlr2; ?></td>
                    <td><?php echo $qte2; ?></td>
                    <td><?php echo $vlr2*$qte2; $totalcommande += $vlr2*$qte2; ?></td>
                  </tr>
                  <?php
                }
                if ($_POST['qte3']>0 && $_POST['vlr3'] <> '-- Choisir la valeur --') {
                  $vlr3 = $_POST['vlr3'];
                  $qte3 = $_POST['qte3'];
                  ?>
                  <tr>
                    <td><?php echo $vlr3; ?></td>
                    <td><?php echo $qte3; ?></td>
                    <td><?php echo $vlr3*$qte3; $totalcommande += $vlr3*$qte3; ?></td>
                  </tr>
                  <?php
                }
              }
              else {
                echo '<script>alert("Erreur dans la sélection des quantités");</script>';
              }
            }
            else {
              header ('Location:gererCommandes');
            }
            ?>
                    <tr>
                        <td>
                          <a href="newCommande" onclick="return confirm('Etes vous sûre de vouloir annuler la commande ?')">
                            <button type="button" name="annuler" value="annuler" class="btn btn-default">Annuler</button>
                          </a>
                        </td>
                        <?php
                        //creation du lien vers la page de traitement de la commande avec les paramètres de la commande en $_GET
                          $balisea = "<a href=\"traitementCmd?id_comm=".$codeCom."&date_comm=".$dateCom."&client=".$client;
                          if(isset($qte1)){
                            $balisea.= "&qte1=".$qte1;
                          }
                          if(isset($qte2)){
                            $balisea.= "&qte2=".$qte2;
                          }
                          if(isset($qte3)){
                            $balisea.= "&qte3=".$qte3;
                          }
                          $balisea.= "\" onclick=\"return confirm('Etes vous sûre de vouloir confirmer la commande ?')\">";
                        ?>
                        <td>
                           <?php echo $balisea; //affichage du lien vers la page de traitement?>
                            <button type="button" name="confirmer" value="confirmer" class="btn btn-warning confirmation">Confirmer</button>
                          </a>
                        </td>
                        <td>Total commande : <strong><?php echo $totalcommande.' (DT)'; ?></strong></td>
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
