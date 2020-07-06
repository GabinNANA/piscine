<!DOCTYPE html>
<html class="loading" lang="en">
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Apex admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Apex admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Se connecter - Complexe Djeuka</title>
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/img/ico/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="app-assets/img/ico/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/prism.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/switchery.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/layout-dark.min.css">
    <link rel="stylesheet" href="app-assets/css/plugins/switchery.min.css">
    <!-- END APEX CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" href="app-assets/css/pages/authentication.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->
  </head>
  <!-- END : Head-->

  <!-- BEGIN : Body-->
  <body class="vertical-layout vertical-menu 1-column auth-page navbar-sticky blank-page" data-menu="vertical-menu" data-col="1-column">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">
      <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-overlay"></div>
          <div class="content-wrapper"><!--Login Page Starts-->
            <section id="login" class="auth-height">
                <div class="row full-height-vh m-0">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="card overflow-hidden">
                        <div class="card-content">
                            <div class="card-body auth-img">
                                <div class="row m-0">
                                    <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center auth-img-bg p-3">
                                        <img src="app-assets/img/gallery/login.png" alt="" class="img-fluid" width="300" height="230">
                                    </div>
                                        <div class="col-lg-6 col-12 px-4 py-3">
                                            <form action="parametre/utilisateur/login" method="post">
                                                <h4 class="mb-2 card-title">SE CONNECTER</h4>
                                                <p>Bienvenue, veuillez vous connecter à votre compte.</p>
                                                
                                                <input type="text" class="form-control mb-3" name="pseudo" placeholder="Pseudo">
                                                <input type="password" class="form-control mb-2" name="password" placeholder="Mot de passe">
                                                <p style="color: red;text-align:center;"><?php if(isset($_SESSION["login_error"])) echo $_SESSION["login_error"] ?></p>
                                                <div class="justify-content-between flex-sm-row flex-column ">
                                                    <button type="submit" style="margin-top: 15px;float: right;" class="btn btn-primary">Se connecter</button>
                                                </div>
                                            </form>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
            <!--Login Page Ends-->
          </div>
        </div>
        <!-- END : End Main Content-->
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/vendors/js/switchery.min.js"></script>
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/notification-sidebar.min.js"></script>
    <script src="app-assets/js/customizer.min.js"></script>
    <script src="app-assets/js/scroll-top.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- END: Custom CSS-->
  </body>
  <!-- END : Body-->
</html>