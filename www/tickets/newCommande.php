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
            <a id="boutonAffichTous" href="gererCommandes">
                <button type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Afficher toutes les commandes
                </button><br>
            </a>
            <br>
            <fieldset>
                <legend>
                    Ajouter une nouvelle commande
                </legend>
                <form method="post" action="apercuCommande" class="form-horizontal">
                  <table class="table">
                    <tr>
                      <td>
                    <span class="form-group">
                        <label for="nom">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </span>
                  </td>
                  <td colspan="2">
                    <span class="form-group">
                        <label for="client">Client</label>
                        <select class="form-control" id="client" name="client" required>
                          <option>-- Choisir le client --</option>
                          <?php
                            $displayClt = new Client();
                            $data = $displayClt->affichClient();
                            if($data->rowCount()>0){
                              while ($ligne=$data->fetch(PDO::FETCH_ASSOC)) {
                                extract($ligne);
                                if($ligne['etat']=='Y'){
                                  echo "<option>".$ligne['name']."</option>";
                                }
                              }
                            }
                          ?>
                        </select>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="form-group">
                        <label>Valeur</label>
                          <select class="form-control" id="vlr1" name="vlr1">
                            <option value="-- Choisir la valeur --">-- Choisir la valeur --</option>
                              <option value="1">1 dinar</option>
                              <option value="5">5 dinars</option>
                              <option value="10">10 dinars</option>
                          </select>

                    </span>
                  </td>
                  <td>
                    <span class="form-group">
                      <label>Quantité</label>
                        <input type="number" class="form-control" id="qte1" name="qte1" value="0" required onchange="calculTotalLigne1()">
                    </span>
                  </td>
                  <td>
                    <span class="form-group">
                      <label>Total ligne</label>
                      <input type="number" class="form-control" id="totalLigne1" name="totalLigne1" value="0" disabled>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="form-group">
                          <select class="form-control" id="vlr2" name="vlr2">
                            <option>-- Choisir la valeur --</option>
                              <option value="1">1 dinar</option>
                              <option value="5">5 dinars</option>
                              <option value="10">10 dinars</option>
                          </select>

                    </span>
                  </td>
                  <td>
                    <span class="form-group">
                        <input type="number" class="form-control" id="qte2" name="qte2" value="0" required onchange="calculTotalLigne2()">
                    </span>
                  </td>
                  <td>
                    <span class="form-group">
                      <input type="number" class="form-control" id="totalLigne2" name="totalLigne2" value="0" disabled>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="form-group">
                          <select class="form-control" id="vlr3" name="vlr3">
                            <option>-- Choisir la valeur --</option>
                              <option value="1">1 dinar</option>
                              <option value="5">5 dinars</option>
                              <option value="10">10 dinars</option>
                          </select>

                    </span>
                  </td>
                  <td>
                    <span class="form-group">
                        <input type="number" class="form-control" id="qte3" name="qte3" value="0" required onchange="calculTotalLigne3()">
                    </span>
                  </td>
                  <td>
                    <span class="form-group">
                      <input type="number" class="form-control" id="totalLigne3" name="totalLigne3" value="0" disabled>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span class="form-group">
                      <button type="reset" class="btn btn-default">Annuler</button>
                      <button type="submit" name="btajout" class="btn btn-warning">Valider</button>
                    </span>
                  </td>
                  <td style="text-align:right">
                    <span class="form-group">
                      <label>Total commande (DT)</label>
                    </span>
                  </td>
                  <td>
                    <span class="form-group">
                      <input type="number" class="form-control" id="totalcommande" name="totalcommandee" value="0" disabled>
                    </span>
                  </td>
                </tr>
              </table>
                </form>
            </fieldset>
            <?php include 'footer.html' ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
