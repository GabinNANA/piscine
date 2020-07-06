<?php
class Utilisateur extends BaseModel {
    public static $tableName='utilisateur';
    public function __construct(){
    	
    }

    public static function Login()
    {
    	global $BD;
            $pwd = $_REQUEST['password'];

            $result = array();
            $res = $BD->prepare("SELECT * FROM utilisateur WHERE (pseudo=?) AND password=?");
            $res->execute(array($_REQUEST["pseudo"],$pwd));
            // echo "SELECT * FROM utilisateur WHERE (pseudo=".$_REQUEST["pseudo"].") AND password=".$pwd." ";
            // die();
            if ($res->rowCount() ==0) {

                $_SESSION["login_error"] = "Mot de passe ou pseudo érroné";
            
                header('Location: ../../login');

            }
            else{
                $list = $res->fetch();
                $_SESSION["idpiscine"] = $list["id"];
                $_SESSION["pseudo"] = $list["pseudo"];
                $_SESSION["idemploye"] = $list["idemploye"];
            
                header('Location: ../../home');
            }
    }


    public static function ajouter()
    {
    	global $BD;

        $result = array();
        $getdossier = $BD->prepare("SELECT * FROM utilisateur WHERE LOWER(pseudo)  = LOWER(?) ");
        $getdossier->execute(array(($_REQUEST['pseudo'])));
        
        if ($getdossier->rowCount() ==0) {

            $sql = $BD->prepare("INSERT INTO `utilisateur`(`idrole`,`pseudo`,`password`, `idemploye`) VALUES (?,?,?,?)");
            $sql->execute(array($_REQUEST["role"],$_REQUEST["pseudo"],$_REQUEST["password"],null($_REQUEST["employe"])))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $result['state'] = "success";
        }
        else{

            $result['state'] = "error";
            $result['reason'] = 'Cet utilisateur existe déjà';
        }

        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        $result = array();

        $getdossier = $BD->prepare("SELECT * FROM utilisateur WHERE LOWER(pseudo)  = LOWER(?) and id!= ?");
        $getdossier->execute(array($_REQUEST['pseudo'],$id));
        
        if ($getdossier->rowCount() ==0) {
            
            $sql = $BD->prepare("UPDATE `utilisateur` SET `idrole`=?,`pseudo`=?,`password`=?, `idemploye`=? WHERE `id`=?");
            $sql->execute(array($_REQUEST["role"],$_REQUEST["pseudo"],$_REQUEST["password"],null($_REQUEST["employe"]),$id))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $result['state'] = "success";
        }
        else{

            $result['state'] = "error";
            $result['reason'] = 'Cet utilisateur existe déjà';
        }

        echo json_encode($result);
    }

    public static function modifierprofil()
    {
        global $BD;

        $id = $_REQUEST["id"];
        $result = array();

        $getdossier = $BD->prepare("SELECT * FROM utilisateur WHERE LOWER(email)  = LOWER(?) and id!= ?");
        $getdossier->execute(array($_REQUEST['email'],$id));
        
        if ($getdossier->rowCount() ==0) {
            if (isset($_FILES["image"]) AND strlen($_FILES["image"]["name"])>0) {
            $folder = 'image/profile/';
            $string=aleatoire(5);
                $tmp_name = $_FILES["image"]["tmp_name"];

                $name = $_FILES["image"]["name"];

                $img = pathinfo($_FILES["image"]['name']);
                $image = "user".$id.$string.'.'.$img["extension"];
                move_uploaded_file($tmp_name, $folder.$image);

            $sql = $BD->prepare("UPDATE `utilisateur` SET `nom`=?,`datenaiss`=?,`tel`=?,`email`=?, `password`=?, `photo`=? WHERE `id`=?");
                $sql->execute(array($_REQUEST["nom"],$_REQUEST["date"],null($_REQUEST["tel"]),$_REQUEST["email"],$_REQUEST["password"],$image,$id))
                or die("Erreur : " . $sql->errorInfo()[2]);
            }
            else
            {
                $sql = $BD->prepare("UPDATE `utilisateur` SET `nom`=?,`datenaiss`=?,`tel`=?,`email`=?, `password`=? WHERE `id`=?");
                $sql->execute(array($_REQUEST["nom"],$_REQUEST["date"],null($_REQUEST["tel"]),$_REQUEST["email"],$_REQUEST["password"],$id))
                or die("Erreur : " . $sql->errorInfo()[2]);
            }
            $result['state'] = "success";
        }
        else{

            $result['state'] = "error";
            $result['reason'] = 'Cet utilisateur existe déjà';
        }

        echo json_encode($result);
    }
    public static function logout()
    {
        session_destroy();

        header('Location: logoutpage');
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM utilisateur WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}