<?php
class Seance extends BaseModel {
    public static $tableName='seance';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        if($_REQUEST["heuredeb"]<$_REQUEST["heurefin"]){
            $sql = $BD->prepare("INSERT INTO `seance`(`idsouscription`, `date`, `heuredeb`, `heurefin`, `statut`) VALUES (?,?,?,?,?)");
            $sql->execute(array($_REQUEST["souscription"],$_REQUEST["date"],$_REQUEST["heuredeb"],$_REQUEST["heurefin"],$_REQUEST["statut"]))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $result['state'] = "success";
        }else{

            $result['state'] = "error";
            $result['reason'] = "L'heure de debut doit etre inferieure a l'heure de fin";
        }
        echo json_encode($result);
    }

    public static function modifier()
    {
        global $BD;

        $id=$_REQUEST["id"];

        if($_REQUEST["heuredeb"]<$_REQUEST["heurefin"]){
            $sql = $BD->prepare("UPDATE `seance` SET `idsouscription`=?,`date`=?, `heuredeb`=?, `heurefin`=?, `statut`=? WHERE `id`=?");
            $sql->execute(array($_REQUEST["souscription"],$_REQUEST["date"],$_REQUEST["heuredeb"],$_REQUEST["heurefin"],$_REQUEST["statut"],$id))
            or die("Erreur : " . $sql->errorInfo()[2]);
            $result['state'] = "success";
        }else{

            $result['state'] = "error";
            $result['reason'] = "L'heure de debut doit etre inferieure a l'heure de fin";
        }
        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM seance WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}