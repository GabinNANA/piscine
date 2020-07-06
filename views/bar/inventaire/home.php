    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
            <div class="content-header">Inventaire</div>
            </div>
        </div>
        <section>
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste des inventaires</h4>
                </div>
                <div class="card-content ">
                    <div class="card-body">
                      <div class="row">
                          <div class="col-md-4" style="margin-bottom:15px;">
                            <select id="categorie" class="form-control select2">
                              <option value="">Choisir une catégorie ...</option>
                              <?php
                                foreach (Categorie::q()->where("type=0")->execute() as $categorie) {
                              ?>
                                  <option value="<?=$categorie->id?>"><?=$categorie->intitule?></option>
                              <?php
                                }
                              ?>
                            </select>
                          </div>
                          <!-- <div class="col-md-4" style="margin-bottom:15px;">
                            <select id="boisson" class="form-control select2">
                              <option value="">Choisir une boisson ...</option>
                              <?php
                                foreach (Boisson::q()->execute() as $categorie) {
                              ?>
                                  <option value="<?=$categorie->id?>"><?=$categorie->intitule?></option>
                              <?php
                                }
                              ?>
                            </select>
                          </div> -->
                          <div class="col-md-4">
                              <input type="date" id="datedeb" class="form-control" placeholder="Choisir une date de debut" />
                          </div>
                          <div class="col-md-4">
                              <input type="date" id="datefin" class="form-control" placeholder="Choisir une date de fin" />
                          </div>
                          <div class="col-md-12">
                            <div class="table-responsive" id="resultinfo">
                            
                            </div>
                          </div>
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
    <script src="app-assets/vendors/js/jquery.form.js"></script>
    <script src="assets/js/scripts.js"></script>
    
<script type="text/javascript">
$(document).ready(function(){
  search();
})
    $("#categorie").on("change",function(){
        search();
    });
    $("#boisson").on("change",function(){
        search();
    });
    $("#datedeb").on("change",function(){
        search();
    });
    $("#datefin").on("change",function(){
        search();
    });
    function search()
    {
        $.ajax({
            type: "POST",
            url: "bar/inventaire/search",
            data: {'datedeb':$('#datedeb').val(),'datefin':$('#datefin').val(),'categorie':$('#categorie').val()},
            dataType: "text",
            success: function(data){
                $("#resultinfo").html(data);
                $(".add-rows").DataTable();
            }
        });
    }
</script>