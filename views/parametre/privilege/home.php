    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
            <div class="content-header">Privilèges</div>
            </div>
        </div>
        <section>
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste des privilèges</h4>
                </div>
                <div class="card-content ">
                    <div class="card-body">
                        <div class="table-responsive" id="resultinfo">
                            <table class="table table-striped table-bordered add-rows">
                                <thead>
                                    <tr>
                                        <th>Privilèges</th>
                                        <?php 
                                            foreach (Role::q()->execute() as $role) {
                                            ?>
                                                <th><center><?=($role->abr);?></center></th>
                                            <?php
                                                $roles[] = $role->id;
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                   foreach (Privilege::q()->where('idmodule is null and visible=1')->execute() as $module) {
                                      echo '<tr>
                                            <th style="padding: 12px 0px;background: #975AFF;color: black;text-align: center;font-size: 15px;" colspan="'.(count($roles)+1).'">'.$module->intitule.'
                                            </th>
                                          </tr>';

                                      foreach (Privilege::q()->where('(idmodule=? or id=?) and visible=1',$module->id,$module->id)->orderby("id asc")->execute() as $priv) {
                                          ?>
                                          <tr>
                                            <td><b><?=($priv->intitule);?></b></td>
                                            <?php 
                                              for ($i=0; $i < count($roles); $i++) { 
                                                $sql = $BD->query("SELECT * FROM privilege_role WHERE idrole = ".$roles[$i]." AND idprivilege = ".$priv->id);
                                                if($sql->rowCount()>0)
                                                  $check = 'checked';
                                                else
                                                  $check = '';
                                                $mere[$i] = $check;
        
                                                echo '<td><center><input type="checkbox"  class="checkPrivilege" data-menu="'.$priv->id.'" data-role="'.$roles[$i].'" '.(checkPrivilege("edit_privilege") ? '' : 'disabled').' data-privilege="'.$priv->id.'" value="" '.$check.' name="select"></center></td>';
                                               
                                              }
                                            ?>
                                          </tr>
                                        <?php
                                      }
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
    var action = "";

$(document).on('click', '.checkPrivilege', function(){

   
    if ($(this).is(':checked')) {
        action = "addprivilege";
        if ($(this).attr('data-menu') != 0) {
          $('.btnenfant'+$(this).attr('data-privilege')+$(this).attr('data-role')+' .checkPrivilege').prop('disabled',false);
          $('.btnenfant'+$(this).attr('data-privilege')+$(this).attr('data-role')+' .checkPrivilege').prop('checked',true);
        }
        
    }
    else{
      action = "removeprivilege";
      if ($(this).attr('data-menu') != 0) {
          $('.btnenfant'+$(this).attr('data-privilege')+$(this).attr('data-role')+' .checkPrivilege').prop('checked',false);
          $('.btnenfant'+$(this).attr('data-privilege')+$(this).attr('data-role')+' .checkPrivilege').prop('disabled',true);
        }
    }
    $.ajax({
      type: "POST",
      url: "parametre/privilege/add",
      data: {privilege:$(this).attr('data-privilege'),role:$(this).attr('data-role'),menu:$(this).attr('data-menu'),'action':action},
      dataType: "json",
      success: function(data){
      }
    });

  });
</script>