<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
           
        case 'mouvement':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/comptabilite/mouvement/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'encaisser':{
                    include("views/comptabilite/mouvement/encaisser.php");
                    break;
                }
                case 'decaisser':{
                    include("views/comptabilite/mouvement/decaisser.php");
                    break;
                }
                case 'transfert':{
                    include("views/comptabilite/mouvement/transfert.php");
                    break;
                }
                case 'search':{
                    include("views/comptabilite/mouvement/search.php");
                    break;
                }
                case 'encaiss':{
                    Mouvement::encaiss();
                    break;
                }	
                case 'destination':{
                    Mouvement::destination();
                    break;
                }
                case 'decaiss':{
                    Mouvement::decaiss();
                    break;
                }	
                case 'transferer':{
                    Mouvement::transfert();
                    break;
                }
                default:{
                    header('location: ../home');
                }
            }
            break;
        }
        case 'caisse':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/comptabilite/caisse/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/comptabilite/caisse/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/comptabilite/caisse/editform.php');
                    break;
                }
                case 'search':{
                    $page_title = 'Accueil';
                    include('views/comptabilite/caisse/search.php');
                    break;
                }
                case 'ajouter':{
                    caisse::ajouter();
                    break;
                }
                case 'modifier':{
                    caisse::modifier();
                    break;
                }
                case 'delete':{
                    caisse::supprimer();
                    break;
                }
            }
            break;
        }
        case 'prix':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/comptabilite/prix/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/comptabilite/prix/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/comptabilite/prix/editform.php');
                    break;
                }
                case 'search':{
                    $page_title = 'Accueil';
                    include('views/comptabilite/prix/search.php');
                    break;
                }
                case 'ajouter':{
                    Prix::ajouter();
                    break;
                }
                case 'modifier':{
                    Prix::modifier();
                    break;
                }
                case 'delete':{
                    Prix::supprimer();
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