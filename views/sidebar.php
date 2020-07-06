
      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <div class="app-sidebar menu-fixed" data-background-color="man-of-steel" data-image="app-assets/img/sidebar-bg/01.jpg" data-scroll-to-active="true">
        <!-- main menu header-->
        <!-- Sidebar Header starts-->
        <div class="sidebar-header">
          <div class="logo clearfix"><a class="logo-text float-left" href="home">
              <div class="logo-img"><img src="app-assets/img/logo.png" alt="Apex Logo"/></div><span class="text">Djeuka</span></a><a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="expanded"></i></a><a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a></div>
        </div>
        <!-- Sidebar Header Ends-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="sidebar-content main-menu-content">
          <div class="nav-container">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
              <li class="nav-item"><a href="home"><i class="ft-home"></i><span class="menu-title" data-i18n="Chat">Tableau de bord</span></a>
              </li>
            <?php if(checkPrivilege("voir_piscine")){ ?>
              <li class="has-sub nav-item"><a href="javascript:;"><i class="ft-aperture"></i><span class="menu-title" data-i18n="UI Kit">Piscine</span></a>
                <ul class="menu-content">
                  <li class="active"><a href="piscine/entree"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Grid">Entrées</span></a>
                  </li>
                  <li><a href="piscine/formation"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Typography">Formations</span></a>
                  </li>
                  <li><a href="piscine/abonnement"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Syntax Highlighter">Abonnements</span></a>
                  </li>
                  <!-- <li class="has-sub"><a href="javascript:;"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Icons">Maillots</span></a>
                    <ul class="menu-content">
                      <li><a href="piscine/maillot"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Feather Icon">Liste</span></a>
                      </li>
                      <li><a href="piscine/maillot/entree"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Font Awesome Icon">Entrées en stock</span></a>
                      </li>
                      <li><a href="piscine/maillot/sortie"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Font Awesome Icon">Sorties en stock</span></a>
                      </li>
                      <li><a href="piscine/maillot/location"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Font Awesome Icon">Locations</span></a>
                      </li>
                      <li><a href="piscine/maillot/inventaire"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Simple Line Icon">Inventaire</span></a>
                      </li>
                    </ul>
                  </li> -->
                </ul>
              </li>
            <?php } ?>
            <?php if(checkPrivilege("voir_commande")){ ?>
              <li class="nav-item"><a href="commande"><i class="ft-file-text"></i><span class="menu-title" data-i18n="Chat">Commandes</span></a>
              </li>
            <?php } ?>
            <?php if(checkPrivilege("voir_reservation")){ ?>
              <li class=" nav-item"><a href="reservation"><i class="ft-calendar"></i><span class="menu-title" data-i18n="Chat">Reservation</span></a>
              </li>
            <?php } ?>
            <?php if(checkPrivilege("voir_comptabilite")){ ?>
              <li class="has-sub nav-item"><a href="javascript:;"><i class="ft-credit-card"></i><span class="menu-title" data-i18n="Dashboard">Comptabilité</span></a>
                <ul class="menu-content">
                  <li><a href="comptabilite/caisse"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 1">Caisse</span></a>
                  </li>
                  <li><a href="comptabilite/mouvement"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Mouvement</span></a>
                  </li>
                  <li><a href="comptabilite/prix"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Configuration des prix</span></a>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <?php if(checkPrivilege("voir_client")){ ?>
            <li class=" nav-item"><a href="client"><i class="ft-users"></i><span class="menu-title" data-i18n="Chat">Clients</span></a>
            </li>
            <?php } ?>
            <?php if(checkPrivilege("voir_bar")){ ?>
              <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-glass"></i><span class="menu-title" data-i18n="Dashboard">Bar</span></a>
                <ul class="menu-content">
                  <li><a href="bar/categorie"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 1">Catégories</span></a>
                  </li>
                  <li><a href="bar/boisson"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 1">Boissons</span></a>
                  </li>
                  <li><a href="bar/entree"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Entrées</span></a>
                  </li>
                  <li><a href="bar/sortie"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Sorties</span></a>
                  </li>
                  <li><a href="bar/inventaire"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Inventaire</span></a>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <?php if(checkPrivilege("voir_restaurant")){ ?>
              <li class="has-sub nav-item"><a href="javascript:;"><i class="ft-layers"></i><span class="menu-title" data-i18n="Dashboard">Restaurant</span></a>
                <ul class="menu-content">
                  <li><a href="restaurant/menu"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 1">Menus</span></a>
                  </li>
                  <li><a href="restaurant/plat"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Plats</span></a>
                  </li>
                </ul>
              </li>
            <?php } ?>
            
            <?php if(checkPrivilege("voir_espace")){ ?>
              <li class="has-sub nav-item"><a href="javascript:;"><i class="ft-command"></i><span class="menu-title" data-i18n="Dashboard">Espace</span></a>
                <ul class="menu-content">
                  <li><a href="espace/liste"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 1">Liste des espaces</span></a>
                  </li>
                  <li><a href="espace/table"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Tables</span></a>
                  </li>
                  <!-- <li><a href="espace/reservation"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Reservations</span></a>
                  </li> -->
                </ul>
              </li>
            <?php } ?>
            <?php if(checkPrivilege("voir_parametre")){ ?>
              <li class="has-sub nav-item"><a href="javascript:;"><i class="ft-settings"></i><span class="menu-title" data-i18n="Dashboard">Paramètres</span></a>
                <ul class="menu-content">
                  <li><a href="parametre/utilisateur"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 1">Utilisateurs</span></a>
                  </li>
                  <li><a href="parametre/employe"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Employés</span></a>
                  </li>
                  <li><a href="parametre/role"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 1">Rôles</span></a>
                  </li>
                  <li><a href="parametre/privilege"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="Dashboard 2">Privilèges</span></a>
                  </li>
                </ul>
              </li>
            <?php } ?>
            </ul>
          </div>
        </div>
        <!-- main menu content-->
        <div class="sidebar-background"></div>
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
        <!-- / main menu-->
      </div>

      <div class="main-panel">