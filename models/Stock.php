<?php
class Stock extends BaseModel {
    public static $tableName='stock';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $motif='';
        if(isset($_REQUEST["motif"])){
            $motif=$_REQUEST["motif"];
        }
        $sql = $BD->prepare("INSERT INTO `stock`(`idelement`,`motif`,`intitule`,`type_element`,`quantite`,`date`,`type`) VALUES (?,?,?,?,?,?,?)");
        $sql->execute(array($_REQUEST["idelement"],$motif,$_REQUEST["intitule"],$_REQUEST["type_element"],$_REQUEST["quantite"],
        $_REQUEST["date"],$_REQUEST["type"]))
        or die("Erreur : " . $sql->errorInfo()[2]);
        
        $result['state'] = "success";
        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        $motif='';
        if(isset($_REQUEST["motif"])){
            $motif=$_REQUEST["motif"];
        }
        $sql = $BD->prepare("UPDATE `stock` SET `idelement`=?,`motif`=?,`intitule`=?,`type_element`=?,`quantite`=?,`date`=?,`type`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["idelement"],$motif,$_REQUEST["intitule"],$_REQUEST["type_element"],$_REQUEST["quantite"],
        $_REQUEST["date"],$_REQUEST["type"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";
        echo json_encode($result);
        
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM stock WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
    }

}