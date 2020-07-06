<?php
class Prix extends BaseModel {
    public static $tableName='prix';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $sql = $BD->prepare("INSERT INTO `prix`(`intitule`,`prix`,`idcaisse`) VALUES (?,?,?)");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["prix"],$_REQUEST["caisse"]))
        or die("Erreur : " . $sql->errorInfo()[2]);
        
        $result['state'] = "success";
        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        
        $sql = $BD->prepare("UPDATE `prix` SET `intitule`=?,`prix`=?,`idcaisse`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["prix"],$_REQUEST["caisse"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";
        echo json_encode($result);
        
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM prix WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
    }

}