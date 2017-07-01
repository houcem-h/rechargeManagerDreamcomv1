<?php
require_once 'class/connectdb.class.php';

class Tickets{
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

    public function ajoutTicket($id,$dateImp,$valeur,$idAgent){
        try{
            $sql = "INSERT INTO impressiontkt(id,dateImpression,valeur,idAgent) VALUES(:tkt_id, :tkt_dateImp, :tkt_valeur, :tkt_idAgent)";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":tkt_id",$id);
            $stmt->bindparam(":tkt_dateImp",$dateImp);
            $stmt->bindparam(":tkt_valeur",$valeur);
            $stmt->bindparam(":tkt_idAgent",$idAgent);
            $stmt->execute();
            return $stmt;

        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function ajoutLigneImpression($idTkt,$qte,$valeur,$totalLigne){
        try{
            $sql = "INSERT INTO ligneimpression(quantite,valeur,totalLigne,idImpressionTkt) VALUES(:ligneComm_qte, :ligneComm_valeur, :ligneComm_totalLigne, :ligneComm_idCommande)";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":ligneComm_qte",$qte);
            $stmt->bindparam(":ligneComm_valeur",$valeur);
            $stmt->bindparam(":ligneComm_totalLigne",$totalLigne);
            $stmt->bindparam(":ligneComm_idCommande",$idTkt);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function ajoutLotLigneImpression($idLigneImp,$valeur,$qte){
      try {
        $sql = 'SELECT * FROM recharge WHERE vlr = ';
        $sql.= $valeur;
        $sql.= ' ORDER BY nserie ASC LIMIT ';
        $sql.= $qte;
        $stmt=$this->execReq($sql);
        $stmt->execute();
        $contentInsert = '';
        $contentDelete = '';
        if($stmt->rowCount()>0){
           while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
             extract($ligne);
             $contentInsert.= "INSERT INTO lotligneimpression (idLigneImpression,nserie, code, vlr, dateExpr) VALUES ('".$idLigneImp."', '".$ligne['nserie']."', '".$ligne['code']."', '".$ligne['vlr']."', '".$ligne['dateExp']."'); ";
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
        // echo $contentInsert;
        // echo $contentDelete;
      }
      catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    public function ajoutLotLigneImpressionHistorique($idImpressTkt){
      try {
        $sql = 'SELECT * FROM lotligneimpression WHERE idLigneImpression IN (SELECT id FROM ligneimpression WHERE idImpressionTkt = :impress_id)';
        $stmt = $this->execReq($sql);
        $stmt->bindparam(":impress_id",$idImpressTkt);
        $stmt->execute();
        if($stmt->rowCount()>0){
          $contentInsert = '';
          $contentDelete = '';
           while ($ligne=$stmt->fetch(PDO::FETCH_ASSOC)){
             extract($ligne);
             $contentInsert.= "INSERT INTO historyprint (idLigneImpression,nserie, code, valeur, dateExp) VALUES ('".$idLigneImpression."', '".$ligne['nserie']."', '".$ligne['code']."', '".$ligne['vlr']."', '".$ligne['dateExpr']."'); ";
             $contentDelete.= "DELETE FROM lotligneimpression  WHERE nserie = ";
             $contentDelete.= $ligne['nserie'].';';
          }
        }
        $req = $this->execReq($contentInsert);
        $insertion = $req->execute();
        if (!empty($insertion)) {
          $req = $this->execReq($contentDelete);
          $suppression = $req->execute();
        }
      }
      catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    public function affichTicket(){
        try{
            $sql = 'SELECT * FROM impressiontkt ORDER BY dateImpression DESC, id DESC';
            $req = $this->cnx->prepare($sql);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichTicketSpecifiq($id){
        try{
            $sql = 'SELECT * FROM impressiontkt WHERE id = :impress_id';
            $req = $this->execReq($sql);
            $req->bindparam(":impress_id",$id);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichLigneImpression($idImp){
        try{
            $sql = 'SELECT * FROM ligneimpression WHERE idImpressionTkt = :lignimp_idtkt';
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":lignimp_idtkt",$idImp);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichImpressionAgent($idAgent){
        try{
            $sql = 'SELECT * FROM impressiontkt WHERE idAgent = :imp_idAgent ORDER BY dateImpression ASC';
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":imp_idAgent",$idAgent);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function imprimerTicketAgent($idImpress){
      try {
        $sql = 'SELECT * FROM lotligneimpression WHERE idLigneImpression IN (SELECT id FROM ligneimpression WHERE idImpressionTkt = :impress_id)';
        $stmt = $this->execReq($sql);
        $stmt->bindparam(":impress_id",$idImpress);
        $stmt->execute();
        return $stmt;
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

    }

    public function modifEtatTicket($id){
        try{
          $sql = "UPDATE impressiontkt SET etat = :impress_etat WHERE id = :impress_id";
          $stmt = $this->execReq($sql);
          $etat = 'Imprimee';
          $stmt->bindparam(":impress_id",$id);
          $stmt->bindparam(":impress_etat",$etat);
          $stmt->execute();
          return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function archiverTicket($id){
        try{
          $sql = "UPDATE impressiontkt SET etat = :impress_etat WHERE id = :impress_id";
          $stmt = $this->execReq($sql);
          $etat = 'Archivee';
          $stmt->bindparam(":impress_id",$id);
          $stmt->bindparam(":impress_etat",$etat);
          $stmt->execute();
          return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function reactiverTicket($id){
        try{
          $sql = "UPDATE impressiontkt SET etat = :impress_etat WHERE id = :impress_id";
          $stmt = $this->execReq($sql);
          $etat = 'Reactivee';
          $stmt->bindparam(":impress_id",$id);
          $stmt->bindparam(":impress_etat",$etat);
          $stmt->execute();
          return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function imprimerTicketHistorique($idImpress){
      try {
        $sql = 'SELECT * FROM historyprint WHERE idLigneImpression IN (SELECT id FROM ligneimpression WHERE idImpressionTkt = :impress_id)';
        $stmt = $this->execReq($sql);
        $stmt->bindparam(":impress_id",$idImpress);
        $stmt->execute();
        return $stmt;
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

    }
}
?>
