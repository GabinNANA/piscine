<?php
class Employe extends BaseModel {
    public static $tableName='employe';
    public function __construct(){
    	
    }
    public static function ajouter()
    {
    	global $BD;

        $result = array();
        
        $sql = $BD->prepare("INSERT INTO `employe`(`nom`,`adresse`,`telephone`,`poste`, `date_recrutement`) VALUES (?,?,?,?,?)");
        $sql->execute(array($_REQUEST["nom"],$_REQUEST["adresse"],null($_REQUEST["telephone"]),$_REQUEST["poste"],$_REQUEST["date"]))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";
       
        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        $result = array();

        $sql = $BD->prepare("UPDATE `employe` SET `nom`=?,`adresse`=?,`telephone`=?,`poste`=?, `date_recrutement`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["nom"],$_REQUEST["adresse"],null($_REQUEST["telephone"]),$_REQUEST["poste"],$_REQUEST["date"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM employe WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}