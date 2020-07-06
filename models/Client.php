<?php
class Client extends BaseModel {
    public static $tableName='client';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $sql = $BD->prepare("INSERT INTO `client`(`nom`, `email`, `telephone`) VALUES (?,?,?)");
        $sql->execute(array($_REQUEST["nom"],$_REQUEST["email"],$_REQUEST["telephone"]))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";
       
        echo json_encode($result);
    }

    public static function modifier()
    {
        global $BD;
        $id=$_REQUEST["id"];

        $sql = $BD->prepare("UPDATE `client` SET `nom`=?,`email`=?, `telephone`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["nom"],$_REQUEST["email"],$_REQUEST["telephone"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";
       
        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM client WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}