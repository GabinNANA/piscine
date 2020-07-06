<?php
class Table extends BaseModel {
    public static $tableName='tables';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;
        $sql = $BD->prepare("INSERT INTO `tables`(`idespace`, `intitule`, `nbre_place`) VALUES (?,?,?)");
        $sql->execute(array($_REQUEST["espace"],$_REQUEST["intitule"],$_REQUEST["nbre"]))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function modifier()
    {
        global $BD;

        $id=$_REQUEST["id"];

        $sql = $BD->prepare("UPDATE `tables` SET `idespace`=?,`intitule`=?,`nbre_place`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["espace"],$_REQUEST["intitule"],$_REQUEST["nbre"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM tables WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}