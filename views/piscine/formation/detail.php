<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Liste des séances</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $abonnement=Souscription::get($_REQUEST["id"]);
    $count=Seance::q()->where("idsouscription=?",$abonnement->id)->count();
?>
    <div class="modal-body form-row">
        <div class="col-md-12 col-12">
            <?php if(checkPrivilege("add_seance") and $abonnement->nbre>$count){ ?>
                <button id="btnaddseance" class="btn btn-primary mb-3"><i class="ft-plus mr-2"></i>Ajouter</button>
            <?php } ?>
            <table class="table table-striped table-bordered add-rows">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure de debut</th>
                        <th>Heure de fin</th>
                        <th>Statut </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach (Seance::q()->where("idsouscription=?",$abonnement->id)->execute() as $seance) {
                ?>
                    <tr>
                        <td><?=format_dateDate($seance->date)?></td>
                        <td><?=$seance->heuredeb?></td>
                        <td><?=$seance->heurefin?></td>
                        <td>
                        <?php
                            if ($seance->statut=='1') {
                            echo "<span class='badge badge-pill bg-light-success mb-1 mr-2'>Effetué</span>";
                            }else{
                                echo "<span class='badge badge-pill bg-light-danger mb-1 mr-2'>Non éffetué</span>";
                            }
                        ?>
                        </td>
                        <td class="text-truncate">
                            <?php if(checkPrivilege("edit_seance")){ ?>
                                <a href="javascript:;" class="success p-0 edit-rowseance" data-id="<?=$seance->id?>" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                            <?php } ?>
                            <?php if(checkPrivilege("delete_seance")){ ?>
                                <a href="javascript:;" class="danger p-0 delete-rowseance" data-id="<?=$seance->id?>" data-toggle="tooltip" data-placement="top" title="Supprimer" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
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
    <p id="infoslogin" style="text-align: center;color: red"></p>
    <div class="modal-footer">
        <!-- <button type="submit" class="btn btn-primary mr-2"><i class="ft-check-square mr-1"></i>Enregister</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fermer"><i class="ft-x mr-1" ></i>Cancel</button>
    </div>
<script type="text/javascript">
var souscription="<?=$_REQUEST["id"]?>";
$(document).on('click','#btnaddseance',function(){
      $('#modalAll').modal('show');
      $('#modalAll').css('z-index','9999');
      $.ajax({
              type: "POST",
              url: "piscine/seance/add",
              data: {'souscription':souscription},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
                $(".select2").select2();
              }
            });
    });

    $(document).on('click','.edit-rowseance',function(){
      $('#modalAll').modal('show');
      $('#modalAll').css('z-index','9999');
      var id = $(this).attr('data-id');
      $.ajax({
              type: "POST",
              url: "piscine/seance/update",
              data: {'id':id,'souscription':souscription},
              dataType: "text",
              success: function(data){
                $('#modalAll .modal-content').html(data);
                $(".select2").select2();
              }
            });
    });

    $(document).on('click','#delete1',function(){
      var id = $(this).attr('data-id');
      $.ajax({
              type: "POST",
              url: "piscine/seance/delete",
              data: {'id':id,'souscription':souscription},
              dataType: "text",
              success: function(data){
                window.location='piscine/formation';
              }
            });
    });

    $(document).on('click','.delete-rowseance',function(){
      $('#modaldelete1').modal('show');
      $('#modaldelete1').css('z-index','9999');
      var id = $(this).attr('data-id');
      $('#modaldelete1 #delete1').attr('data-id',id);
    });
</script>