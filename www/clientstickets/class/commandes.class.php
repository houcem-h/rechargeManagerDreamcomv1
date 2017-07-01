<?php
require_once 'class/connectdb.class.php';

class Commande{
    private $cnx;

    public function __construct(){
        $database = new Database();
        $db = $database->cnxBD();
        $this->cnx = $db;
    }

    public function execReq($sql){
        $stmt = $this->cnx->prepare($sql);
        return $stmt;
    }

    public function redirect($url){
        header("Location: $url");
    }

    public function ajoutCommande($id,$dateComm,$valeur,$idClient){
        try{
            $sql = "INSERT INTO commande(id,dateComm,valeur,idClient) VALUES(:comm_id, :comm_dateComm, :comm_valeur, :comm_idClient)";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":comm_id",$id);
            $stmt->bindparam(":comm_dateComm",$dateComm);
            $stmt->bindparam(":comm_valeur",$valeur);
            $stmt->bindparam(":comm_idClient",$idClient);
            $stmt->execute();
            return $stmt;

        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function ajoutLigneCommande($idComm,$qte,$valeur,$totalLigne){
        try{
            $sql = "INSERT INTO lignecommande(quantite,valeur,totalLigne,idCommande) VALUES(:ligneComm_qte, :ligneComm_valeur, :ligneComm_totalLigne, :ligneComm_idCommande)";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":ligneComm_qte",$qte);
            $stmt->bindparam(":ligneComm_valeur",$valeur);
            $stmt->bindparam(":ligneComm_totalLigne",$totalLigne);
            $stmt->bindparam(":ligneComm_idCommande",$idComm);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function ajoutLotLigneCommande($idLigneComm,$valeur,$qte){
      try {
        $sql = 'SELECT * FROM recharge WHERE vlr = ';
        $sql.= $valeur;
        $sql.= ' ORDER BY nserie ASC LIMIT ';
        $sql .= $qte;
        $reponse=$this->execReq($sql);
        $reponse->execute();
        $contentInsert = '';
        $contentDelete = '';
        if($reponse->rowCount()>0){
           while ($ligne=$reponse->fetch(PDO::FETCH_ASSOC)){
             extract($ligne);
             $contentInsert.= "INSERT INTO lotlignecommande (idLigneCommande,nserie, code, valeur, dateExpr) VALUES ('".$idLigneComm."', '".$ligne['nserie']."', '".$ligne['code']."', '".$ligne['vlr']."', '".$ligne['dateExp']."'); ";
             $contentDelete.= "DELETE FROM recharge WHERE nserie = ";
             $contentDelete.= $ligne['nserie'].';';
          }
        }
        $req = $this->execReq($contentInsert);
        $insertion = $req->execute();
        if (!empty($insertion)) {
          $req = $this->execReq($contentDelete);
          $req->execute();

        }
      }
      catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    public function ajoutLotLigneCommandeHistorique($idComm){
      try {
        $sql = 'SELECT * FROM lotlignecommande WHERE idLigneCommande IN (SELECT id FROM lignecommande WHERE idCommande = :comm_id) ';
        $stmt = $this->execReq($sql);
        $stmt->bindparam(":comm_id",$idComm);
        $stmt->execute();
        if($stmt->rowCount()>0){
          $contentInsert = '';
          $contentDelete = '';
           while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
             extract($ligne);
             $contentInsert.= "INSERT INTO historyvendu (idLigneCommande,nserie, code, valeur, dateExp) VALUES ('".$idLigneCommande."', '".$ligne['nserie']."', '".$ligne['code']."', '".$ligne['valeur']."', '".$ligne['dateExpr']."'); ";
             $contentDelete.= "DELETE FROM lotlignecommande WHERE nserie = ";
             $contentDelete.= $ligne['nserie'].';';
          }
        }
        $req = $this->execReq($contentInsert);
        $insertion = $req->execute();
        if (!empty($insertion)) {
          $req = $this->execReq($contentDelete);
          $req->execute();

        }
      }
      catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    public function affichCommande(){
        try{
            $sql = 'SELECT * FROM commande ORDER BY dateComm DESC, etat ASC, id';
            $req = $this->cnx->prepare($sql);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichCommandeSpecifiq($id){
        try{
            $sql = 'SELECT * FROM commande WHERE id = :comm_id';
            $req = $this->execReq($sql);
            $req->bindparam(":comm_id",$id);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichLigneCommande($idComm){
        try{
            $sql = 'SELECT * FROM lignecommande WHERE idCommande = :ligncom_idcom';
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":ligncom_idcom",$idComm);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichCommandeClient($idClient){
        try{
            $sql = 'SELECT * FROM commande WHERE idClient = :comm_idClt ORDER BY etat ASC, dateComm DESC';
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":comm_idClt",$idClient);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function imprimerCommandeClient($idCommande){
      try {
        $sql = 'SELECT * FROM lotlignecommande WHERE idLigneCommande IN (SELECT id FROM lignecommande WHERE idCommande = :comm_id)';
        $stmt = $this->execReq($sql);
        $stmt->bindparam(":comm_id",$idCommande);
        $stmt->execute();
        return $stmt;
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

    }

    public function modifEtatCommande($id){
        try{
          $sql = "UPDATE commande SET etat = :comm_etat WHERE id = :comm_id";
          $stmt = $this->execReq($sql);
          $etat = 'Imprimee';
          $stmt->bindparam(":comm_id",$id);
          $stmt->bindparam(":comm_etat",$etat);
          $stmt->execute();
          return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    //Permet de modifier l'état d'une commmande client de l'état "Imprimee" à l'état "Reactivee"
    //par l'administrateur suite à une demande du client, pour pouvoir la réimprimer
    public function reactiverCommande($id){
        try{
          $sql = "UPDATE commande SET etat = :comm_etat WHERE id = :comm_id";
          $stmt = $this->execReq($sql);
          $etat = 'Reactivee';
          $stmt->bindparam(":comm_id",$id);
          $stmt->bindparam(":comm_etat",$etat);
          $stmt->execute();
          return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    //Permet de réimprimer une commmande client qui a été réactivée par l'administrateur suite à une demande du client,
    //la commande est imprimée à partir de l'historique
    public function imprimerCommandeClientHistorique($idCommande){
      try {
        $sql = 'SELECT * FROM historyvendu WHERE idLigneCommande IN (SELECT id FROM lignecommande WHERE idCommande = :comm_id)';
        $stmt = $this->execReq($sql);
        $stmt->bindparam(":comm_id",$idCommande);
        $stmt->execute();
        return $stmt;
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

    }
}
?>
