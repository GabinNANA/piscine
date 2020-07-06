<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
        case 'entree':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/piscine/entree/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    include("views/piscine/entree/addform.php");
                    break;
                }
                case 'search':{
                    include("views/piscine/entree/search.php");
                    break;
                }
                case 'ajouter':{
                    Mouvement::entree();
                    break;
                }	
                default:{
                    head('location: ../home');
                }
            }
            break;
        }
        case 'formation':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/piscine/formation/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    include("views/piscine/formation/addform.php");
                    break;
                }
                case 'update':{
                    include("views/piscine/formation/editform.php");
                    break;
                }
                case 'search':{
                    include("views/piscine/formation/search.php");
                    break;
                }
                case 'detail':{
                    include("views/piscine/formation/detail.php");
                    break;
                }
                case 'ajouter':{
                    Souscription::ajouter();
                    break;
                }
                case 'modifier':{
                    Souscription::modifier();
                    break;
                }
                case 'delete':{
                    Souscription::supprimer();
                    break;
                }		
                default:{
                    head('location: ../home');
                }
            }
            break;
        }
        case 'abonnement':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/piscine/abonnement/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/piscine/abonnement/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/piscine/abonnement/editform.php');
                    break;
                }
                case 'search':{
                    include("views/piscine/abonnement/search.php");
                    break;
                }
                case 'ajouter':{
                    Souscription::ajouter();
                    break;
                }
                case 'modifier':{
                    Souscription::modifier();
                    break;
                }
                case 'delete':{
                    Souscription::supprimer();
                    break;
                }
            }
            break;
        }
        case 'seance':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/piscine/formation/addseance.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/piscine/formation/editseance.php');
                    break;
                }
                case 'ajouter':{
                    Seance::ajouter();
                    break;
                }
                case 'modifier':{
                    Seance::modifier();
                    break;
                }
                case 'delete':{
                    Seance::supprimer();
                    break;
                }
            }
            break;
        }
        case 'maillot':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/piscine/maillot/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/piscine/maillot/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/piscine/maillot/editform.php');
                    break;
                }
                case 'search':{
                    include("views/piscine/maillot/search.php");
                    break;
                }
                case 'ajouter':{
                    Maillot::ajouter();
                    break;
                }
                case 'modifier':{
                    Maillot::modifier();
                    break;
                }
                case 'delete':{
                    Maillot::supprimer();
                    break;
                }
            }
            break;
        }
        case 'stock':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/piscine/stock/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/piscine/stock/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/piscine/stock/editform.php');
                    break;
                }
                case 'ajouter':{
                    Stock::ajouter();
                    break;
                }
                case 'modifier':{
                    Stock::modifier();
                    break;
                }
                case 'delete':{
                    Stock::supprimer();
                    break;
                }
            }
            break;
        }
        case 'location':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/piscine/location/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/piscine/location/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/piscine/location/editform.php');
                    break;
                }
                case 'ajouter':{
                    Location::ajouter();
                    break;
                }
                case 'modifier':{
                    Location::modifier();
                    break;
                }
                case 'delete':{
                    Location::supprimer();
                    break;
                }
            }
            break;
        }
        case 'vente':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/piscine/vente/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/piscine/vente/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/piscine/vente/editform.php');
                    break;
                }
                case 'ajouter':{
                    Stock::ajouter();
                    break;
                }
                case 'modifier':{
                    Stock::modifier();
                    break;
                }
                case 'delete':{
                    Stock::supprimer();
                    break;
                }
            }
            break;
        }
        case 'inventaire':{
            $action = isset($_GET['action'])? trim($_GET['action']) : "load";
            switch($action){
                case 'load':{
                    $page_title = "Gestion des rôles";
                    include("views/head.php");
                    include("views/navbar.php");
                    include("views/sidebar.php");
                    include("views/piscine/inventaire/home.php");
                    include("views/footer.php");
                    break;
                }
            }
            break;
        }
        default:{
            head('location: ../home');
        }
        
    }

?>