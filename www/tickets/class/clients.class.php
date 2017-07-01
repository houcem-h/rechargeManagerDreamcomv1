<?php
require_once 'class/connectdb.class.php';

class Client{
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

    public function is_logged_in(){
        if(isset($_SESSION['clientSession'])){
            return true;
        }
    }

    public function logout(){
        session_destroy();
        $_SESSION['clientSession'] = false;
    }

    public function login($email,$pwd){
        try{
            $stmt = $this->cnx->prepare("SELECT * FROM customers WHERE email=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1){
                $pwdVerif = password_verify($pwd, $userRow['pass']);
                if($pwdVerif){
                    $_SESSION['clientSession'] = $userRow['id'];
                    return true;
                } else{
                    $this->redirect("indexClient?error");
                    exit;
                }
            }else{
                    $this->redirect("indexClient?error");
                    exit;
                }
        } catch (PDOException $ex){
            echo $ex->getMessage();
        }

    }

    public function ajoutNew($nom,$email,$passwd,$etat,$tel,$adr){
        try{
            $pwd = password_hash($passwd,PASSWORD_DEFAULT);
            $id = mt_rand();
            $sql = "INSERT INTO customers(id,name,email,pass,etat,tel,adresse) VALUES(:user_id, :user_name, :user_mail, :user_pass, :user_status, :user_tel, :user_adress)";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":user_id",$id);
            $stmt->bindparam(":user_name",$nom);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_pass",$pwd);
            $stmt->bindparam(":user_status",$etat);
            $stmt->bindparam(":user_tel",$tel);
            $stmt->bindparam(":user_adress",$adr);
            $stmt->execute();
            return $stmt;

        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichClient(){
        try{
            $sql = 'SELECT * FROM customers ORDER BY etat, id DESC';
            $req = $this->cnx->prepare($sql);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichClientSpecifiq($id){
        try{
            $sql = 'SELECT * FROM customers WHERE id = :user_id';
            $req = $this->cnx->prepare($sql);
            $req->bindparam(":user_id",$id);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function modifClient($id,$nom,$email,$etat,$tel,$adr){
        try{
            $sql = "UPDATE customers SET name = :user_name, email = :user_mail, etat = :user_status, tel = :user_tel, adresse = :user_adress WHERE id = :user_id";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":user_id",$id);
            $stmt->bindparam(":user_name",$nom);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_status",$etat);
            $stmt->bindparam(":user_tel",$tel);
            $stmt->bindparam(":user_adress",$adr);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }

    }

    public function modifProfil($id,$passwd){
        try{
            $pwd = password_hash($passwd,PASSWORD_DEFAULT);
            $sql = "UPDATE customers SET pass = :user_pwd WHERE id = :user_id";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":user_id",$id);
            $stmt->bindparam(":user_pwd",$pwd);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }

    }

    public function supprimClient($id){
        try{
            $sql = "DELETE FROM customers WHERE id = :user_id";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":user_id",$id);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
}
?>
