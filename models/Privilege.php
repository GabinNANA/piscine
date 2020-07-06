<?php
Class Privilege_role extends BaseModel{
	public static $tableName = 'privilege_role';
	 public function __construct()
	{

	}
}
Class Privilege extends BaseModel{
	public static $tableName = 'privilege';
	 public function __construct()
	{

	}

	public static function ajouter()
	{
		global $BD;
		if (isset($_POST["action"]) && $_REQUEST["action"] == "addprivilege") {
			$result = array();
		  	$result['state'] = "success";
		  	$sql = $BD->query("INSERT INTO privilege_role (idrole,idprivilege) VALUES(".$_REQUEST['role'].",".$_REQUEST["privilege"].")");
		  	
	      	echo json_encode($result);
		}

		if (isset($_POST["action"]) && $_REQUEST["action"] == "removeprivilege") {
			$result = array();
		  	$result['state'] = "success";
		  	$sql = $BD->query("DELETE FROM privilege_role WHERE  idrole = ".$_REQUEST['role']." AND idprivilege=".$_REQUEST["privilege"]);
		  	
	      	echo json_encode($result);
		}
	}
}

?>