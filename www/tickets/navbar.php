<nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation">
    <div class="container">
       <ul class="nav navbar-nav navbar-right">
<li class="dropdown">
    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="icon-user"></span>
        <?php echo $row['prenom'].' '.$row['nom']; ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li>
        <a href="profilUser"><span class="glyphicon glyphicon-user"></span>&nbsp;Mon profil</a>
      </li>
        <li>
            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Déconnexion</a>
        </li>
    </ul>
</li>
</ul>
        <div class="navbar-header">
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
                <li><a href="home">Accueil</a></li>
                <?php if ($row['role']=='boss') {
                  ?>
                  <li><a href="gererPersonnel">Personnel</a></li>
                  <?php
                } ?>
                <li ><a href="gererRecharges">Recharges</a></li>
                <li><a href="gererTickets">Tickets</a></li>
                <?php if ($row['role']!='vendeur') {
                  ?>
                <li><a href="gererClients">Clients</a></li>
                <li><a href="gererCommandes ">Commandes</a></li>
                <?php
              } ?>
            </ul>
        </div>
    </div>
</nav>
