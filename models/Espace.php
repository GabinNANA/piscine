<?php
class Espace extends BaseModel {
    public static $tableName='espace';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $sql = $BD->prepare("INSERT INTO `espace`(`intitule`, `prix`) VALUES (?,?)");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["prix"]))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function modifier()
    {
        global $BD;

        $id=$_REQUEST["id"];

        $sql = $BD->prepare("UPDATE `espace` SET `intitule`=?,`prix`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["prix"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM espace WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}