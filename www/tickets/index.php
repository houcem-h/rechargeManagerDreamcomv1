<?php
	session_start();
	require_once 'class/users.class.php';
    $user = new USER();

	//Si l'utilisateur est déjà connecté on le redirige vers la page d'accueil
	if($user->is_logged_in()!="") {
		$user->redirect('home');
	}

	if(isset($_POST['btn-login'])) {
		//récupération des informations du formulaire
		$email = trim($_POST['email']);
		$pwd = trim($_POST['password']);

		//On essaie de connecter l'utilisateur
 		if ($user->login($email,$pwd))  {
			//Si les inforamtions sont correctes
			// alors son id sera ajouté dans la session
			// puis on le rederige vers la page d'accueil
			$user->redirect('home');
 		}
	}
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bienvenue chez Recharge-Dreamcom</title>
    <link rel="shortcut icon" href="dreamcom.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css" type="text/css"  />
    <style>body{background-color:#FCF8E3}</style><?php include 'style.html'; ?>

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="signin-form">

	<div class="container">
            <figure>
        <center><img src="dreamcom.png" alt="Dreamcom.tn" width="150px" height="150px"></center>
    </figure>
           <br>

       <form class="form-signin" method="post">
          <?php
                if(isset($_GET['error']))
                  {
        ?>
                <div class='alert alert-danger'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Paramètres eronnés !</strong>
                </div>
          <?php
             unset($_GET['error']);
                  }
          ?>
        <h2 class="form-signin-heading" style="color:#F45B04;">Connexion</h2><hr />


        <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Adresse email" />
        <span id="check-e"></span>
        </div>

        <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Mot de passe" />
        </div>

     	<hr />

        <div class="form-group">
            <button type="submit" name="btn-login" class="btn btn-default">
                	<i class="glyphicon glyphicon-log-in"></i> &nbsp; Connexion
            </button>
        </div>
      	<!--<br />
            <label>Vous n'avez pas un compte ! <a href="">Inscription</a></label>-->
      </form>

    </div>
<?php include 'footer.html' ?>
</div>
</body>
</html>
