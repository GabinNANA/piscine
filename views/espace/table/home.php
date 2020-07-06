    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
            <div class="content-header">Tables</div>
            </div>
        </div>
        <section>
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste des tables</h4>
                </div>
                <div class="card-content ">
                    <div class="card-body">
                        <?php if(checkPrivilege("add_table")){ ?>
                        <button id="btnadd" class="btn btn-primary mb-3"><i class="ft-plus mr-2"></i>Ajouter</button>
                        <?php } ?>
                        <div class="col-md-12" style="margin-bottom:15px;">
                              <select id="espace" class="form-control select2">
                                <option value="">Choisir un espace ...</option>
                              <?php
                                foreach (Espace::q()->execute() as $espace) {
                              ?>
                                  <option value="<?=$espace->id?>"><?=$espace->intitule?></option>
                              <?php
                                }
                              ?>
                              </select>
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
    $(document).on('click','#btnadd',function(){
      $('#modalAll').modal('show');
      $.ajax({
              type: "POST",
              url: "espace/table/add",
              data: {},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
                $(".select2").select2();
              }
            });
    });

    $(document).on('click','.voir-row',function(){
      $('#modalAll').modal('show');
      var id = $(this).attr('data-id');
      $.ajax({
              type: "POST",
              url: "espace/table/detail",
              data: {'id':id},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
                $(".select2").select2();
              }
            });
    });
    $(document).on('click','.edit-row',function(){
      $('#modalAll').modal('show');
      var id = $(this).attr('data-id');
      $.ajax({
              type: "POST",
              url: "espace/table/update",
              data: {'id':id},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
                $(".select2").select2();
              }
            });
    });

    $(document).on('click','#delete',function(){
      var id = $(this).attr('data-id');
      $.ajax({
              type: "POST",
              url: "espace/table/delete",
              data: {'id':id},
              dataType: "text",
              success: function(data){
                search();
                toastr.success('table supprimé avec succès.');
                $("#dialogCancel").trigger("click");
              }
            });
    });

    $(document).on('click','.delete-row',function(){
      $('#modaldelete').modal('show');
      var id = $(this).attr('data-id');
      $('#modaldelete #delete').attr('data-id',id);
    });
    $('#espace').on('change',function(){ 
      search();
    });
    function search()
    {
        $.ajax({
            type: "POST",
            url: "espace/table/search",
            data: {"espace":$("#espace").val()},
            dataType: "text",
            success: function(data){
                $("#resultinfo").html(data);
                $(".add-rows").DataTable();
            }
        });
    }
</script>