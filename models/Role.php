<?php
class Role extends BaseModel {
    public static $tableName='role';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $sql = $BD->prepare("INSERT INTO `role`(`intitule`,`abr`) VALUES (?,?)");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["abr"]))
        or die("Erreur : " . $sql->errorInfo()[2]);
        
        $result['state'] = "success";
        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        
        $sql = $BD->prepare("UPDATE `role` SET `intitule`=?,`abr`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["intitule"],$_REQUEST["abr"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";
        echo json_encode($result);
        
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM role WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
    }

}