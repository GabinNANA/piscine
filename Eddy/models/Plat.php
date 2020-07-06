<?php
class Plat extends BaseModel {
    public static $tableName='plat';
    public function __construct(){
    	
    }

    public static function ajouter()
    {
    	global $BD;

        $result = array();
        $image=""; 

        $string = bin2hex(openssl_random_pseudo_bytes(5));
            
        if (isset($_FILES["imageadd"]) and strlen($_FILES["imageadd"]["name"])>0) {
            $folder = 'image/plat/';

            $tmp_name = $_FILES["imageadd"]["tmp_name"];

            $name = $_FILES["imageadd"]["name"];

            $img = pathinfo($_FILES["imageadd"]['name']);
            $image = "mediatech".$string.'.'.$img["extension"];

            move_uploaded_file($tmp_name, $folder.$image);

        }
        
        $sql = $BD->prepare("INSERT INTO `plat`(`idcategorie`,`intitule`,`description`,`prix`,`image`,`etat`) VALUES (?,?,?,?,?,?)");
        $sql->execute(array($_REQUEST["categorie"],$_REQUEST["intitule"],$_REQUEST["description"],$_REQUEST["prix"],$image,$_REQUEST["etat"]))
        or die("Erreur : " . $sql->errorInfo()[2]);

        $result['state'] = "success";

        echo json_encode($result);

    }

    public static function modifier()
    {
        global $BD;

        $id = $_REQUEST["id"];
        $result = array();
        $plat=plat::get($id);

        $image="";
        $string = bin2hex(openssl_random_pseudo_bytes(5));
        
        if (isset($_FILES["imageadd"]) and strlen($_FILES["imageadd"]["name"])>0) {
            $folder = 'image/plat/';

            $tmp_name = $_FILES["imageadd"]["tmp_name"];

            $name = $_FILES["imageadd"]["name"];

            $img = pathinfo($_FILES["imageadd"]['name']);
            $image = "mediatech".$string.'.'.$img["extension"];

            move_uploaded_file($tmp_name, $folder.$image);

        }else{
            $image=$plat->image;
        }

        $sql = $BD->prepare("UPDATE `plat` SET `idcategorie`=?,`intitule`=?,`description`=?,`prix`=?,`image`=?,`etat`=? WHERE `id`=?");
        $sql->execute(array($_REQUEST["categorie"],$_REQUEST["intitule"],$_REQUEST["description"],$_REQUEST["prix"],$image,$_REQUEST["etat"],$id))
        or die("Erreur : " . $sql->errorInfo()[2]);
        $result['state'] = "success";

        echo json_encode($result);
    }

    public static function supprimer()
    {
        global $BD;
        $result = array();

        $insert = $BD->query("DELETE FROM plat WHERE id IN (".$_REQUEST["id"].")");
        $result['state'] = "success";

        echo json_encode($result);
        
    }

}