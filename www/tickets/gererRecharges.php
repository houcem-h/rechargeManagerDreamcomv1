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
    <title>Recharges</title>
    <link rel="shortcut icon" href="dreamcom.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <?php include 'style.html'; ?>

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php
        require_once 'class/recharge.class.php';
        ?>
        <div class="container">
            <!--nav-->
            <?php include 'navbar.php'; ?>
            <!--end nav-->
            <br><br>
            <figure>
        <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
    </figure>
           <br>
           <a href="newFichier">
           <button type="button" class="btn btn-warning">
               <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Uploader un nouveau fichier
            </button>
          </a>

            <?php
            //récupération des nombres de lignes de chaques valeurs de recharges dans la BD
                    $stkRech = new Recharge();
                    $nb1d = $stkRech->stkRecharge(1);
                    $nb5d = $stkRech->stkRecharge(5);
                    $nb10d = $stkRech->stkRecharge(10);
                ?>

                <fieldset id="disponible"><!--affichage de l'état de stock des recharges selon la valeur-->
                    <legend>Afficher les recharges disponibles en stock </legend>
                    <div class="col-sm-10">
                        <table class="table table-condensed">

                        <tr><!--affichage quantité en stock des recharges de 1 dinar-->
                            <td class="col-sm-3">
                                <label>Recharges de 1 dinar</label>
                            </td>
                            <td>
                                <div class="progress ">
                                    <?php
                                    //calcul du pourcentage des recharges de 1dt pour le progress bar
                $prcg1 = $nb1d*100/10000;
             echo '<div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="'.$prcg1.'"aria-valuemin="0" aria-valuemax="100" style="width:'.$prcg1.'%">'.$nb1d.' : '.$prcg1.'%</div>';?>

                                </div>
                            </td>
                        </tr><!--fin de l'affichage quantité en stock des recharges de 1 dinar-->

                        <tr><!--affichage quantité en stock des recharges de 1 dinar-->
                            <td class="col-sm-3">
                                <label>Recharges de 5 dinars</label>
                            </td>
                            <td>
                                <div class="progress ">
                                    <?php
                $prcg5 = $nb5d*100/10000;
             echo '<div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="'.$prcg5.'"aria-valuemin="0" aria-valuemax="100" style="width:'.$prcg5.'%">'.$nb5d.' : '.$prcg5.'%</div>';?>

                                </div>
                            </td>
                        </tr><!--fin de l'affichage quantité en stock des recharges de 1 dinar-->
                        <tr><!--affichage quantité en stock des recharges de 1 dinar-->
                            <td class="col-sm-3">
                                <label>Recharges de 10 dinars</label>
                            </td>
                            <td>
                                <div class="progress ">
                                    <?php
                $prcg10 = $nb10d*100/10000;
             echo '<div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="'.$prcg10.'"aria-valuemin="0" aria-valuemax="100" style="width:'.$prcg10.'%">'.$nb10d.' : '.$prcg10.'%</div>';?>

                                </div>
                            </td>
                        </tr><!--fin de l'affichage quantité en stock des recharges de 1 dinar-->
                    </table>

                    </div>

                </fieldset><!--fin de l'affichage de l'état de stock des recharges selon la valeur-->

                <div class="container">
            </tbody>
        </table>
    </div>


<?php include 'footer.html' ?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </div>
</body>

</html>
