<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
        case 'categorie':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/bar/categorie/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/bar/categorie/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/bar/categorie/editform.php');
                    break;
                }
                case 'search':{
                    include("views/bar/categorie/search.php");
                    break;
                }
                case 'ajouter':{
                    categorie::ajouter();
                    break;
                }
                case 'modifier':{
                    categorie::modifier();
                    break;
                }
                case 'delete':{
                    categorie::supprimer();
                    break;
                }
            }
            break;
        }
        case 'boisson':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/bar/boisson/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/bar/boisson/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/bar/boisson/editform.php');
                    break;
                }
                case 'search':{
                    include("views/bar/boisson/search.php");
                    break;
                }
                case 'ajouter':{
                    Boisson::ajouter();
                    break;
                }
                case 'modifier':{
                    Boisson::modifier();
                    break;
                }
                case 'delete':{
                    Boisson::supprimer();
                    break;
                }
            }
            break;
        }
        case 'entree':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/bar/entree/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/bar/entree/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/bar/entree/editform.php');
                    break;
                }
                case 'search':{
                    include("views/bar/entree/search.php");
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
        case 'sortie':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/bar/sortie/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/bar/sortie/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/bar/sortie/editform.php');
                    break;
                }
                case 'search':{
                    include("views/bar/sortie/search.php");
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
                    include("views/bar/inventaire/home.php");
                    include("views/footer.php");
                    break;
                }
                case 'search':{
                    include("views/bar/inventaire/search.php");
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