<?php
require_once 'class/connectdb.class.php';

class USER{
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

    public function is_logged_in(){
        if(isset($_SESSION['userSession'])){
            return true;
        }
    }

    public function redirect($url){
        header("Location: $url");
    }

    public function logout(){
        session_destroy();
        $_SESSION['userSession'] = false;
    }

    public function login($email,$pwd){
        try{
            $stmt = $this->cnx->prepare("SELECT * FROM users WHERE email=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1){
                $pwdVerif = password_verify($pwd, $userRow['passwd']);
                if(/*$pwd == $userRow['passwd']*/$pwdVerif){
                    $_SESSION['userSession'] = $userRow['id'];
                    return true;
                } else{
                    $this->redirect("index.php?error");
                    exit;
                }
            }else{
                    $this->redirect("index.php?error");
                    exit;
                }
        } catch (PDOException $ex){
            echo $ex->getMessage();
        }

    }

    public function ajoutNew($nom,$prenom,$email,$passwd,$role){
        try{
            $pwd = password_hash($passwd,PASSWORD_DEFAULT);//hashage du password
            //creation de l'id
            // $id = "";
            // $nomAgent = explode(" ",$nom);
            // foreach ($nomAgent as $value) {
            //   $id.= $value[0];
            // }
            // $prenomAgent = explode(" ",$prenom);
            // foreach ($prenomAgent as $value) {
            //   $id.= $value[0];
            // }
            $id= mt_rand();
            $sql = "INSERT INTO users(id,nom,prenom,email,passwd,role) VALUES(:user_id, :user_name, :user_prenom, :user_mail, :user_pass, :user_role)";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":user_id",$id);
            $stmt->bindparam(":user_name",$nom);
            $stmt->bindparam(":user_prenom",$prenom);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_pass",$pwd);
            $stmt->bindparam(":user_role",$role);
            $stmt->execute();
            return $stmt;

        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichPersonnel(){
        try{
            $sql = 'SELECT * FROM users ORDER BY role';
            $req = $this->cnx->prepare($sql);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function affichAgentSpecifiq($id){
        try{
            $sql = 'SELECT * FROM users WHERE id = :user_id';
            $req = $this->cnx->prepare($sql);
            $req->bindparam(":user_id",$id);
            $req->execute();
            return $req;
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function modifAgent($id,$nom,$prenom,$email){
        try{
            $sql = "UPDATE users SET nom = :user_name, prenom = :user_prenom, email = :user_mail WHERE id = :user_id";
            $stmt = $this->execReq($sql);
            $stmt->bindparam(":user_id",$id);
            $stmt->bindparam(":user_name",$nom);
            $stmt->bindparam(":user_prenom",$prenom);
            $stmt->bindparam(":user_mail",$email);
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
            $sql = "UPDATE users SET passwd = :user_pwd WHERE id = :user_id";
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

    public function supprimAgent($id){
        try{
            $sql = "DELETE FROM users WHERE id = :user_id";
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
