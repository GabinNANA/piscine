<?php
    $cible = isset($_GET['cible'])? $_GET['cible'] : "load";
    
    switch($cible){
            
        case 'utilisateur':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/parametre/utilisateur/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'profile':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/profile.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    include("views/parametre/utilisateur/addform.php");
                    break;
                }
                case 'detail':{
                    include("views/parametre/utilisateur/detail.php");
                    break;
                }
                case 'update':{
                    include("views/parametre/utilisateur/editform.php");
                    break;
                }
                case 'search':{
                    include("views/parametre/utilisateur/search.php");
                    break;
                }
                case 'login':{
                    Utilisateur::login();
                    break;
                }
                case 'ajouter':{
                    Utilisateur::ajouter();
                    break;
                }
                case 'modifier':{
                    Utilisateur::modifier();
                    break;
                }
                case 'modifierprofil':{
                    Utilisateur::modifierprofil();
                    break;
                }
                case 'delete':{
                    Utilisateur::supprimer();
                    break;
                }		
                default:{
                    head('location: ../home');
                }
            }
            break;
        }
        case 'role':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/parametre/role/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/parametre/role/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/parametre/role/editform.php');
                    break;
                }
                case 'search':{
                    include("views/parametre/role/search.php");
                    break;
                }
                case 'ajouter':{
                    Role::ajouter();
                    break;
                }
                case 'modifier':{
                    Role::modifier();
                    break;
                }
                case 'delete':{
                    Role::supprimer();
                    break;
                }
            }
            break;
        }
        case 'employe':{
            $action = isset($_GET['action'])? $_GET['action'] : "load";

            switch($action){
                case 'load':{
                    $page_title = 'Accueil';
                    include('views/head.php');
                    include('views/navbar.php');
                    include('views/sidebar.php');
                    include('views/parametre/employe/home.php');
                    include('views/footer.php');
                    break;
                }
                case 'add':{
                    $page_title = 'Accueil';
                    include('views/parametre/employe/addform.php');
                    break;
                }
                case 'update':{
                    $page_title = 'Accueil';
                    include('views/parametre/employe/editform.php');
                    break;
                }
                case 'search':{
                    include("views/parametre/employe/search.php");
                    break;
                }
                case 'ajouter':{
                    Employe::ajouter();
                    break;
                }
                case 'modifier':{
                    Employe::modifier();
                    break;
                }
                case 'delete':{
                    Employe::supprimer();
                    break;
                }
            }
            break;
        }
        case 'privilege':{
            $action = isset($_GET['action'])? trim($_GET['action']) : "load";
            switch($action){
                case 'load':{
                    $page_title = "Gestion des rôles";
                    include("views/head.php");
                    include("views/navbar.php");
                    include("views/sidebar.php");
                    include("views/parametre/privilege/home.php");
                    include("views/footer.php");
                    break;
                }
                
                case 'add':{
                    $page_title = "Ajouter medicament";
                    Privilege::ajouter();
                    break;
                }

            }
            break;
        }
        default:{
            // header('location: ../home');
        }
        
    }

?>