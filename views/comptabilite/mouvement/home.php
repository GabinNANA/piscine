    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
            <div class="content-header">Mouvement</div>
            </div>
        </div>
        <section>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Liste des filtres</h4>
                  </div>
                  <div class="card-content ">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-9">
                              <label for="">Periode : </label><small> date de debut - date de fin</small>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="date" id="datedeb" class="form-control" placeholder="Choisir une date de debut" />
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="date" id="datefin" class="form-control" placeholder="Choisir une date de fin" />
                                </div>
                                <div class="form-group col-md-12">
                                    <select id="operation" class="form-control select2" >
                                        <option value=''>Choisir une opération...</option>
                                        <option value="0">Recette</option>
                                        <option value="1">Dépenses</option>
                                        <option value="2">Transfert</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <select id="caisse" class="form-control select2" >
                                        <option value=''>Choisir une caisse...</option>
                                        <?php
                                            foreach(Caisse::q()->execute() as $caisse){
                                        ?>
                                            <option value="<?=$caisse->id?>" > <?=$caisse->intitule?>  </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <select id="transaction" class="form-control select2" >
                                        <option value=''>Choisir une transaction...</option>
                                        <option value="6">Payement à l'entrée</option>
                                        <option value="0">Commande</option>
                                        <option value="1">Reservation</option>
                                        <option value="2">souscription</option>
                                        <option value="3">Location</option>
                                        <option value="4">Sortie de stock</option>
                                        <option value="5">Autres</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <br>
                          <?php
                              if (checkPrivilege('encaisse')) {
                                  ?>
                                      <button type="submit" class="btnencaisser btn btn-success" style="width: 100%;">Dépots</button><br><br>
                                  <?php
                              }
                              if (checkPrivilege('decaisse')) {
                                  ?>
                                      <button type="submit" class="btndecaisser btn btn-danger" style="width: 100%;">Retraits</button><br><br>
                                  <?php
                              }
                              if (checkPrivilege('transfert')) {
                                  ?>
                                      <button type="submit" class="btntransferer btn btn-warning" style="width: 100%;">Transférer</button><br><br>
                                  <?php
                              }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste des mouvements de caisse</h4>
                    </div>
                    <div class="card-content ">
                        <div class="card-body">
                            <div class="table-responsive" id="resultinfo">
                                
                            </div>
                        </div>
                    </div>
                  </div>
              </div>  
            </div>
        </section>
        </div>
    </div>
    <!-- END : End Main Content-->
    <!-- BEGIN VENDOR JS-->
    <script src="app-assets/vendors/js/jquery.min.js"></script>
    <script src="app-assets/vendors/js/jquery.slimscroll.js"></script>
    <script src="app-assets/vendors/js/jquery.min.js"></script>
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/vendors/js/switchery.min.js"></script>
    <script src="app-assets/vendors/js/pickadate/picker.js"></script>
    <script src="app-assets/vendors/js/pickadate/picker.date.js"></script>
    <script src="app-assets/vendors/js/pickadate/picker.time.js"></script>
    <script src="app-assets/vendors/js/pickadate/legacy.js"></script>
    <script src="app-assets/vendors/js/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/toastr.min.js"></script>
    <script src="app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
    <script src="app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/notification-sidebar.min.js"></script>
    <script src="app-assets/js/customizer.min.js"></script>
    <script src="app-assets/js/scroll-top.min.js"></script>
    <script src="app-assets/js/data-tables/dt-api.js"></script>
    <script src="app-assets/js/select2.min.js"></script>
    <script src="app-assets/js/ex-component-toastr.min.js"></script>
    <script src="app-assets/js/form-datetimepicker.min.js"></script>
    <script src="app-assets/js/form-inputs.min.js"></script>
    <script src="app-assets/vendors/js/jquery.form.js"></script>
    <script src="assets/js/scripts.js"></script>
    
<script type="text/javascript">
$(document).ready(function(){
  search();
})
    $(document).on('click','.btnencaisser',function(){
      $('#modalAll').modal('show');
      $.ajax({
              type: "POST",
              url: "comptabilite/mouvement/encaisser",
              data: {},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
              }
            });
    });

    $(document).on('click','.btndecaisser',function(){
      $('#modalAll').modal('show');
      $.ajax({
              type: "POST",
              url: "comptabilite/mouvement/decaisser",
              data: {},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
              }
            });
    });
    $(document).on('click','.btntransferer',function(){
      $('#modalAll').modal('show');
      $.ajax({
              type: "POST",
              url: "comptabilite/mouvement/transfert",
              data: {},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
                $("#source").trigger("change");
              }
            });
    });

    $("#caisse").on("change",function(){
        search();
    });
    $("#operation").on("change",function(){
        search();
    });
    $("#datedeb").on("change",function(){
        search();
    });
    $("#datefin").on("change",function(){
        search();
    });
    $("#transaction").on("change",function(){
        search();
    });
    function search()
    {
        $.ajax({
            type: "POST",
            url: "comptabilite/mouvement/search",
            data: {'datedeb':$('#datedeb').val(),'datefin':$('#datefin').val(),'caisse':$('#caisse').val(),'operation':$('#operation').val(),'transaction':$('#transaction').val()},
            dataType: "text",
            success: function(data){
                $("#resultinfo").html(data);
                $(".add-rows").DataTable();
            }
        });
    }
</script>