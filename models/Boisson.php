<?php
class Boisson extends BaseModel {
    public static $tableName='boisson';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $result = array();
        $image=""; 

        $string = bin2hex(openssl_random_pseudo_bytes(5));
            
        if (isset($_FILES["imageadd"]) and strlen($_FILES["imageadd"]["name"])>0) {
            $folder = 'image/boisson/';

            $tmp_name = $_FILES["imageadd"]["tmp_name"];

            $name = $_FILES["imageadd"]["name"];

            $img = pathinfo($_FILES["imageadd"]['name']);
            $image = "mediatech".$string.'.'.$img["extension"];

            move_uploaded_file($tmp_name, $folder.$image);

        }
        
        $sql = $BD->prepare("INSERT INTO `boisson`(`idcategorie`,`intitule`,`quantite`,`prix`,`image`) VALUES (?,?,?,?,?)");
        $sql->execute(array($_REQUEST["categorie"],$_REQUEST["intitule"],$_REQUEST["quantite"],$_REQUEST["prix"],$image))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        $result = array();
        $boisson=boisson::get($id);

        $image="";
        $string = bin2hex(openssl_random_pseudo_bytes(5));
        
        if (isset($_FILES["imageadd"]) and strlen($_FILES["imageadd"]["name"])>0) {
            $folder = 'image/boisson/';

            $tmp_name = $_FILES["imageadd"]["tmp_name"];

            $name = $_FILES["imageadd"]["name"];

            $img = pathinfo($_FILES["imageadd"]['name']);
            $image = "mediatech".$string.'.'.$img["extension"];

            move_uploaded_file($tmp_name, $folder.$image);

        }else{
            $image=$boisson->image;
        }

        $sql = $BD->prepare("UPDATE `boisson` SET `idcategorie`=?,`intitule`=?,`quantite`=?,`prix`=?,`image`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["categorie"],$_REQUEST["intitule"],$_REQUEST["quantite"],$_REQUEST["prix"],$image,$id))
        or die("Erreur : " . $sql->errorInfo()[2]);
        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM boisson WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}