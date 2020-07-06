 <!-- BEGIN : Main Content-->
 <?php
  $entree=0;
  foreach(Mouvement::q()->where("date=? and type_operation=6",date("Y-m-d"))->execute() as $t){
    $entree +=$t->recette;
  }
  $commande=0;
  foreach(Mouvement::q()->where("date=? and type_operation=0",date("Y-m-d"))->execute() as $t){
    $commande +=$t->recette;
  }
  $reservation=0;
  foreach(Mouvement::q()->where("date=? and type_operation=1",date("Y-m-d"))->execute() as $t){
    $reservation +=$t->recette;
  }
  $formation=0;
  foreach(Mouvement::q()->where("date=? and type_operation=2 and idelement in (select id from souscription where type=0)",date("Y-m-d"))->execute() as $t){
    $formation +=$t->recette;
  }
  $abonnement=0;
  foreach(Mouvement::q()->where("date=? and type_operation=2 and idelement in (select id from souscription where type=1)",date("Y-m-d"))->execute() as $t){
    $abonnement +=$t->recette;
  }
  $formation_valide=0;
  foreach(souscription::q()->where("type=0")->execute() as $t){
    if($t->nbre == Seance::q()->where("idsouscription=? and statut=1",$t->id)->count()){
      $formation_valide++;
    }
  }
  $abonnement_valide=0;
  foreach(souscription::q()->where("type=1")->execute() as $t){
    if(date("Y-m-d")<=endMonth($t->date,$t->nbre)){
      $abonnement_valide++;
    }
  }
  $commande_nonservi=Commande::q()->where("type=1 and servi=1 and date=?",date("Y-m-d"))->count();
 ?>
 <div class="main-content">
          <div class="content-overlay"></div>
          <div class="content-wrapper"><!--Statistics cards Starts-->
            <div class="row">
              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-purple-love">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($entree)?> FCFA</h3>
                          <span>Total payements d'entrée</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-activity font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-ibiza-sunset">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($commande)?> FCFA</h3>
                          <span>Total commandes</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-percent font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-mint">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($reservation)?> FCFA</h3>
                          <span>Total reservations</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-trending-up font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-king-yna">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($formation)?> FCFA</h3>
                          <span>Total formations</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-credit-card font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart3" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-purple-love">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($abonnement)?> FCFA</h3>
                          <span>Total des abonnements</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-activity font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-ibiza-sunset">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($formation_valide)?> FCFA</h3>
                          <span>Nombre de formations valides</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-percent font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-mint">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($abonnement_valide)?> FCFA</h3>
                          <span>Nombre d'abonnements valides</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-trending-up font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-king-yna">
                  <div class="card-content">
                    <div class="card-body py-0">
                      <div class="media pb-1">
                        <div class="media-body white text-left">
                          <h3 class="font-large-1 white mb-0"><?=format_money($commande_nonservi)?> FCFA</h3>
                          <span>Commandes non servies</span>
                        </div>
                        <div class="media-right white text-right">
                          <i class="ft-credit-card font-large-1"></i>
                        </div>
                      </div>
                    </div>
                    <div id="Widget-line-chart3" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Statistics cards Ends-->

            <div class="row match-height">
              <div class="col-xl-4 col-lg-12 col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Ajouter un paiement d'entrée</h4>
                  </div>
                    <div class="card-content">
                      <form action="piscine/entree/ajouter" method="post">
                      <div class="card-body">
                        <div class="col-md-12 col-12">
                            <div class="form-group mb-2">
                                <label for="basic-form-1">Caisse : </label> <?=Caisse::get(Prix::get('1')->idcaisse)->intitule?>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group mb-2">
                                <label for="basic-form-1">Montant : </label> <?=Prix::get('1')->prix?>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mt-6 mb-3">
                            <div class="form-group mb-2">
                                <label for="basic-form-2">Nombre de personnes *</label>
                                <input type="number" class="form-control" name="nombre" min=1 placeholder="Nombre de personnes" required>
                            </div>
                        </div>
                      </div>
                      <p id="infoslogin" style="text-align: center;color: red"></p>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary mr-2"><i class="ft-check-square mr-1"></i>Enregister</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fermer"><i class="ft-x mr-1" ></i>Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-xl-8 col-lg-12 col-12">
                <div class="card shopping-cart">
                  <div class="card-header pb-2">
                    <h4 class="card-title mb-1">Les dernières commandes</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body p-0">
                      <div class="table-responsive">
                        <table class="table text-center m-0">
                        <thead>
                            <tr>
                                <th>Table</th>
                                <th>Montant</th>
                                <th>Servi</th>
                                <th>Payé</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach (Commande::q()->where("type=1")->limit("4")->orderby("id desc")->execute() as $commande) {
                                $prix=0;
                                foreach (Produit_commande::q()->where("idcommande=?",$commande->id)->execute() as $prodC) {
                                    if($prodC->type_element==0){
                                        $prix +=Boisson::get($prodC->idelement)->prix * $prodC->quantite;
                                    }else{
                                        $prix +=Plat::get($prodC->idelement)->prix * $prodC->quantite;
                                    }
                                }
                        ?>
                            <tr>
                                <td><?=Table::get($commande->idtable)->intitule?></td>
                                <td><?=format_money($prix)?> FCFA</td>
                                <td>
                                    <?php
                                        if ($commande->servi==1) {
                                          echo "<span class='badge badge-pill bg-light-success mb-1 mr-2'>Oui</span>";
                                        }else{
                                            echo "<span class='badge badge-pill bg-light-danger mb-1 mr-2'>Non</span>";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if ($commande->paye==1) {
                                          echo "<span class='badge badge-pill bg-light-success mb-1 mr-2'>Oui</span>";
                                        }else{
                                            echo "<span class='badge badge-pill bg-light-danger mb-1 mr-2'>Non</span>";
                                        }
                                    ?>
                                </td>
                                <td><?=format_dateDate($commande->date)?> <?=$commande->heuredeb?> </td>
                                <td class="text-truncate">
                                    <?php if(checkPrivilege("detail_commande")){ ?>
                                        <a href="commande/detail/<?=$commande->id?>" class="primary p-0" data-id="<?=$commande->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detail de la commande"><i class="ft-eye font-medium-3 mr-2"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!--Line with Area Chart 1 Starts-->
            <div class="row">
              <!-- <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Transaction financières</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <div class="chart-info mb-3 ml-3">
                        <span class="gradient-purple-bliss d-inline-block rounded-circle mr-1" style="width:15px; height:15px;"></span>
                        Encaissements
                        <span class="gradient-mint d-inline-block rounded-circle mr-1 ml-2" style="width:15px; height:15px;"></span>
                        Décaissement
                      </div>
                      <div id="line-area" class="height-350 lineArea">
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
              <div class="col-xl-12 col-lg-12 col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mb-0">Transactions financières</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <div class="chart-info mb-2">
                        <span class="text-uppercase mr-3"><i class="fa fa-circle success font-small-2 mr-1"></i> Encaissements</span>
                        <span class="text-uppercase"><i class="fa fa-circle info font-small-2 mr-1"></i> Décaissements</span>
                      </div>
                      <div id="line-area2" class="height-400 lineAreaDashboard">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Line with Area Chart 1 Ends-->
          </div>
        </div>
    <script src="app-assets/vendors/js/jquery.min.js"></script>
    <script src="app-assets/vendors/js/jquery.slimscroll.js"></script>
    <script src="app-assets/vendors/js/jquery.min.js"></script>
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/vendors/js/switchery.min.js"></script>
    <script src="app-assets/vendors/js/chartist.min.js"></script>
    <script src="app-assets/vendors/js/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/toastr.min.js"></script>
    <script src="app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
    <script src="app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/notification-sidebar.min.js"></script>
    <script src="app-assets/js/customizer.min.js"></script>
    <script src="app-assets/js/scroll-top.min.js"></script>
    <script src="app-assets/js/dashboard1.min.js"></script>
    <script src="app-assets/js/data-tables/dt-api.js"></script>
    <script src="app-assets/js/select2.min.js"></script>
    <script src="app-assets/js/ex-component-toastr.min.js"></script>
    <script src="app-assets/vendors/js/jquery.form.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
      lineArea2 = new Chartist.Line(
          "#line-area2",
          {
              labels: ["Jan", "Feb", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"],
              series: [
                  [5, 30, 25, 55, 45, 65, 60, 105, 80, 110, 120, 150],
                  [80, 95, 87, 155, 140, 147, 130, 180, 160, 175, 165, 200],
              ],
          },
          { showArea: !0, fullWidth: !0, lineSmooth: Chartist.Interpolation.none(), axisX: { showGrid: !1 }, axisY: { low: 0, scaleMinSpace: 50 } },
          [
              [
                  "screen and (max-width: 640px) and (min-width: 381px)",
                  {
                      axisX: {
                          labelInterpolationFnc: function (e, t) {
                              return t % 2 == 0 ? e : null;
                          },
                      },
                  },
              ],
              [
                  "screen and (max-width: 380px)",
                  {
                      axisX: {
                          labelInterpolationFnc: function (e, t) {
                              return t % 3 == 0 ? e : null;
                          },
                      },
                  },
              ],
          ]
      )
      lineArea2.update();

$('form').on('submit', function(){ 
    $(this).ajaxSubmit({
        beforeSend: function() {
            
        },
        uploadProgress: function(event, position, total, percentComplete) {
            
        },
        dataType:"json",
        success: function(data, statusText, xhr) {
            if (data.state == 'success') {
                toastr.success('Entrée créé avec succès.');
            }
            else{
            $('#infoslogin').html(data.reason);
            }
        },
        error: function(xhr, statusText, err) {
            alert("Problème lors de l'enregistrement "+xhr.responseText);
        }
    }); 
    return false;
}); 
</script>