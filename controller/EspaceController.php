<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
        case 'liste':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/espace/liste/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/espace/liste/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/espace/liste/editform.php');
                    break;
                }
                case 'search':{
                    include("views/espace/liste/search.php");
                    break;
                }
                case 'ajouter':{
                    Espace::ajouter();
                    break;
                }
                case 'modifier':{
                    Espace::modifier();
                    break;
                }
                case 'delete':{
                    Espace::supprimer();
                    break;
                }
            }
            break;
        }
        case 'table':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/espace/table/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/espace/table/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/espace/table/editform.php');
                    break;
                }
                case 'search':{
                    include("views/espace/table/search.php");
                    break;
                }
                case 'ajouter':{
                    Table::ajouter();
                    break;
                }
                case 'modifier':{
                    Table::modifier();
                    break;
                }
                case 'delete':{
                    Table::supprimer();
                    break;
                }
            }
            break;
        }
        case 'reservation':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/espace/reservation/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/espace/reservation/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/espace/reservation/editform.php');
                    break;
                }
                case 'search':{
                    include("views/espace/reservation/search.php");
                    break;
                }
                case 'ajouter':{
                    Reservation::ajouter();
                    break;
                }
                case 'modifier':{
                    Reservation::modifier();
                    break;
                }
                case 'delete':{
                    Reservation::supprimer();
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