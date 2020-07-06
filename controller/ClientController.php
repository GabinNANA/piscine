<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
        case 'load':{
            $page_title = 'Accueil';
            include('views/head.php');
            include('views/navbar.php');
            include('views/sidebar.php');
            include('views/client/home.php');
            include('views/footer.php');
            break;
        }
        case 'add':{
            include("views/client/addform.php");
            break;
        }
        case 'update':{
            include("views/client/editform.php");
            break;
        }
        case 'search':{
            include("views/client/search.php");
            break;
        }
        case 'ajouter':{
            Client::ajouter();
            break;
        }
        case 'modifier':{
            Client::modifier();
            break;
        }
        case 'delete':{
            Client::supprimer();
            break;
        }			
        default:{
            head('location: ../home');
        }
    }

?>