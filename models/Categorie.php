<?php
class Categorie extends BaseModel {
    public static $tableName='categorie';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $heuredeb=NULL; $heurefin=NULL;

        if(isset($_REQUEST["heuredeb"])){
            $heuredeb=$_REQUEST["heuredeb"];
        }
        if(isset($_REQUEST["heurefin"])){
            $heurefin=$_REQUEST["heurefin"];
        }
        $sql = $BD->prepare("INSERT INTO `categorie`(`intitule`, `heuredeb`, `heurefin`, `type`) VALUES (?,?,?,?)");
        $sql->execute(array($_REQUEST["intitule"],$heuredeb,$heurefin,$_REQUEST["type"]))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function modifier()
    {
        global $BD;

        $heuredeb=NULL; $heurefin=NULL; $id=$_REQUEST["id"];

        if(isset($_REQUEST["heuredeb"])){
            $heuredeb=$_REQUEST["heuredeb"];
        }
        if(isset($_REQUEST["heurefin"])){
            $heurefin=$_REQUEST["heurefin"];
        }
        $sql = $BD->prepare("UPDATE `categorie` SET `intitule`=?,`heuredeb`=?, `heurefin`=?, `type`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["intitule"],$heuredeb,$heurefin,$_REQUEST["type"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM categorie WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}