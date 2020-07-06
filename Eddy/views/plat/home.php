    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
            <div class="content-header">Plats</div>
            </div>
        </div>
        <section>
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste des plats</h4>
                </div>
                <div class="card-content ">
                    <div class="card-body">
                        <?php if(checkPrivilege("add_plat")){ ?>
                        <button id="btnadd" class="btn btn-primary mb-3"><i class="ft-plus mr-2"></i>Ajouter</button>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6" style="margin-bottom:15px;">
                              <select id="categorie" class="form-control select2">
                                <option value="">Choisir un menu ...</option>
                              <?php
                                foreach (Categorie::q()->where("type=1")->execute() as $categorie) {
                              ?>
                                  <option value="<?=$categorie->id?>"><?=$categorie->intitule?></option>
                              <?php
                                }
                              ?>
                              </select>
                            </div>
                            <div class="col-md-6" style="margin-bottom:15px;">
                              <select id="disponible" class="form-control select2">
                                <option value="">Choisir un etat ...</option>
                                <option value="1">Disponible</option>
                                <option value="0">Non disponible</option>
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
              url: "restaurant/plat/add",
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
              url: "restaurant/plat/detail",
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
              url: "restaurant/plat/update",
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
              url: "restaurant/plat/delete",
              data: {'id':id},
              dataType: "text",
              success: function(data){
                search();
                toastr.success('plat supprimée avec succès.');
                $("#dialogCancel").trigger("click");
              }
            });
    });

    $(document).on('click','.delete-row',function(){
      $('#modaldelete').modal('show');
      var id = $(this).attr('data-id');
      $('#modaldelete #delete').attr('data-id',id);
    });
    $('#categorie').on('change',function(){ 
      search();
    });
    $('#disponible').on('change',function(){ 
      search();
    });
    function search()
    {
        $.ajax({
            type: "POST",
            url: "restaurant/plat/search",
            data: {"categorie":$("#categorie").val(),"disponible":$("#disponible").val()},
            dataType: "text",
            success: function(data){
                $("#resultinfo").html(data);
                $(".add-rows").DataTable();
            }
        });
    }
    $(document).on('click','.btnaddimage',function(){
        $('#inputimgad').trigger('click');
    });
    $(document).on('change','#inputimgad',function(){
        readURL(this,'imgpreviewad');
    });
    function readURL(input, ids) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();  
        reader.onload = function (e) {
          $('#'+ids).attr('src', e.target.result);
          var src = $('#'+ids).attr('src');
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
</script>