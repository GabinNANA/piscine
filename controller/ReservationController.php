<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
        case 'load':{
            $page_title = 'Accueil';
            include('views/head.php');
            include('views/navbar.php');
            include('views/sidebar.php');
            include('views/reservation/home.php');
            include('views/footer.php');
            break;
        }
        case 'add':{
            include("views/reservation/addform.php");
            break;
        }
        case 'update':{
            include("views/reservation/editform.php");
            break;
        }
        case 'search':{
            include("views/reservation/search.php");
            break;
        }
        case 'detail':{
            if(is_numeric($_REQUEST["action"])){
                $page_title = 'Accueil';
                include('views/head.php');
                include('views/navbar.php');
                include('views/sidebar.php');
                include('views/reservation/detail.php');
                include('views/footer.php');
                break;
            }else{
                head('location: ../home');
            }
        }
        case 'ajouter':{
            Reservation::ajouter();
            break;
        }
        case 'modifier':{
            Reservation::modifier();
            break;
        }
        case 'tableau':{
            Reservation::tableau();
            break;
        }
        case 'delete':{
            Reservation::supprimer();
            break;
        }			
        default:{
            head('location: ../home');
        }
    }

?>