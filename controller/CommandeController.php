<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
        case 'load':{
            $page_title = 'Accueil';
            include('views/head.php');
            include('views/navbar.php');
            include('views/sidebar.php');
            include('views/commande/home.php');
            include('views/footer.php');
            break;
        }
        case 'add':{
            include("views/commande/addform.php");
            break;
        }
        case 'update':{
            include("views/commande/editform.php");
            break;
        }
        case 'search':{
            include("views/commande/search.php");
            break;
        }
        case 'detail':{
            if(is_numeric($_REQUEST["action"])){
                $page_title = 'Accueil';
                include('views/head.php');
                include('views/navbar.php');
                include('views/sidebar.php');
                include('views/commande/detail.php');
                include('views/footer.php');
                break;
            }else{
                head('location: ../home');
            }
        }
        case 'ajouter':{
            commande::ajouter();
            break;
        }
        case 'modifier':{
            commande::modifier();
            break;
        }
        case 'tableau':{
            commande::tableau();
            break;
        }
        case 'delete':{
            commande::supprimer();
            break;
        }			
        default:{
            head('location: ../home');
        }
    }

?>