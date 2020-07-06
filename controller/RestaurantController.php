<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
        case 'menu':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/restaurant/menu/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/restaurant/menu/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/restaurant/menu/editform.php');
                    break;
                }
                case 'search':{
                    include("views/restaurant/menu/search.php");
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
        case 'plat':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/restaurant/plat/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/restaurant/plat/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/restaurant/plat/editform.php');
                    break;
                }
                case 'search':{
                    include("views/restaurant/plat/search.php");
                    break;
                }
                case 'ajouter':{
                    Plat::ajouter();
                    break;
                }
                case 'modifier':{
                    Plat::modifier();
                    break;
                }
                case 'delete':{
                    Plat::supprimer();
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