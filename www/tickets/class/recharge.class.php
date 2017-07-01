<?php
    require_once 'class/connectdb.class.php';

    class Recharge{
        private $conn;
            
        public function __construct(){
            $database = new Database();
            $bd = $database->cnxBD();
            $this->conn = $bd;
        }
        
        
        public function execReq($sql){
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }
        
        public function uploaderFichier($ficher){
        
            //upload du fichier csv dans le serveur  
            $target_dir = "csvFiles/";
            $target_file = $target_dir . basename($ficher["name"]);
            $uploadOk = 1;
            
            // Vérifier si le fichier est bien un fichier csv ou txt
            $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
            if(in_array($ficher['type'],$mimes)){
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                header('Location:gererRecharges.php');
            }
            if($uploadOk == 0) {
            $err =  "Erreur, le fichier n’a pas été uploadé.";
                return $err;
            } else {
                if(move_uploaded_file($ficher["tmp_name"], $target_file)){
                    echo "Le fichier ". basename( $ficher["name"]). " a été uploadé avec succès.";
                    $nomFichier = $ficher["name"];
                    /*setcookie("fileName",$ficher["name"],time()+(3600*24*3));
                    setcookie("fileType",$_FILES['csvRecharge']['type'],time()+(3600*24*60));*/
                    $this->alimenterBd($nomFichier);
                    } else {
                        $err =  "Erreur, le fichier n’a pas été uploadé.";
                        return $err;
                        }
                }
        }  
        
        private function alimenterBd($fichier){
            $myfile = fopen("csvFiles/".$fichier, "r") or die("Unable to open file!");
            // Output one line until end-of-file
            $sql='';
            while(!feof($myfile)) {
                $ligne = explode(",",fgets($myfile));
                $sql.= "INSERT INTO recharge (nserie, code, vlr, dateExp) VALUES ('".$ligne[0]."', '".$ligne[1]."', '".$ligne[2]."', '".$ligne[3]."'); ";
            }
            $req = $this->execReq($sql);
            $req->execute();
            fclose($myfile);
            header('Location:gererRecharges.php');
        }
        
        public function stkRecharge($valeur){
            $sql = 'SELECT count(*) FROM recharge WHERE vlr="'.$valeur.'"';
            $req = $this->execReq($sql);
            $req->execute();
            $stk=$req->fetchColumn();
            return $stk;
            
        }
        
        
    } ?>