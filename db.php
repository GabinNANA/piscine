<?php
	try{
      $BD = new PDO('mysql:host=localhost;dbname=piscine', 'root','');
      $BD->exec("SET CHARACTER SET UTF8");
      $BD->exec("SET NAMES 'UTF8'");
      $BD->exec("SET CHARACTER SET_CLIENT='UTF8'");
      $BD->exec("set collation_connection='utf8mb4_bin'");
      /*$BD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $BD->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);*/
	}catch(Exception $e){
		die('Erreur : '.$e->getMessage());
	}
?>
