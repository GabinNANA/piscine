<?php
class Caisse extends BaseModel {
    public static $tableName='caisse';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $sql = $BD->prepare("INSERT INTO `caisse`(`intitule`,`solde_initial`,`solde`) VALUES (?,?,?)");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["solde"],$_REQUEST["solde"]))
        or die("Erreur : " . $sql->errorInfo()[2]);
        
        $result['state'] = "success";
       
        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        
        $sql = $BD->prepare("UPDATE `caisse` SET `intitule`=?,`solde_initial`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["solde"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);
        $result['state'] = "success";
       
        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM caisse WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";
       
        echo json_encode($result);
    }

}