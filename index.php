<?php
    header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
    header("Cache-Control: post-check=0, pre-check=0", false); 
    header("Cache-Control: private");
    header("Pragma: no-cache");
    header('Content-Type:text/html; Charset=UTF-8');
	
	ob_start();

	session_start();

	define("BASEURL", "/piscine/");
	require_once("fonctions.php");  
	require("db.php");
	include 'models/classes.php';
	$query = array();
	$parts = parse_url($_SERVER["REQUEST_URI"]);
	if(isset($parts['query'])){
		parse_str($parts['query'], $query);
		if(isset($query) && count($query)>0){
			foreach ($query as $key => $value) {
				$_REQUEST[$key] = $value;
			}
		}
	}
	//$_SESSION['annee']="1";
	$defautColor = "#61b47c";
	$ctrl = "home"; // Page de connexion par défaut

	// Par défaut on affiche le TABLEAU DE BORD
	if(isset($_REQUEST['page'])){
		$ctrl = $_REQUEST['page'];
	}

	if (isset($_SESSION["idpiscine"])) {
		switch($ctrl){
			case 'home':{ 
				$page_title = "Dashboard";
				include("views/head.php");
				include("views/navbar.php");
				include("views/sidebar.php");
				include("views/home.php");
				include("views/footer.php");
				break;
			}

			case 'parametre':{ 
				include("controller/ParametreController.php");
				break;
			}
			case 'comptabilite':{ 
				include("controller/ComptabiliteController.php");
				break;
			}
			case 'piscine':{ 
				include("controller/PiscineController.php");
				break;
			}
			case 'client':{ 
				include("controller/ClientController.php");
				break;
			}
			case 'bar':{ 
				include("controller/BarController.php");
				break;
			}
			case 'restaurant':{ 
				include("controller/RestaurantController.php");
				break;
			}
			case 'commande':{ 
				include("controller/CommandeController.php");
				break;
			}
			case 'reservation':{ 
				include("controller/ReservationController.php");
				break;
			}
			case 'espace':{ 
				include("controller/EspaceController.php");
				break;
			}
			case 'logout':{
				Utilisateur::logout();
				break;
			}

			case 'logoutpage':{ 
				include("views/logout.php");
				break;
			}

			default:{
				header("Location: home");
			}
		}
	} else {
		switch($ctrl){
			case 'login':{ 
				$page_title = "Login";
				include("views/login.php");
				break;
			}
			case 'parametre':{ 
				include("controller/ParametreController.php");
				break;
			}
			case 'logout':{
				Utilisateur::logout();
				break;
			}
			default:{
				header("Location:login");
			}
		}
	}
	
	
ob_end_flush();
?>