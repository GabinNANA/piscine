<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Modifier une table</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $table=Table::get($_REQUEST["id"]);
?>
<form action="espace/table/modifier" method="post">
    <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>">
    <div class="modal-body form-row">
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Espace *</label>
                <select class="form-control select2" name="espace" required>
                    <?php
                        foreach (Espace::q()->execute() as $espace) {
                    ?>
                        <option value="<?=$espace->id?>" <?=$table->idespace==$espace->id ? 'selected':''?> ><?=$espace->intitule?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Intitule *</label>
                <input type="text" class="form-control" name="intitule" value="<?=$table->intitule?>" placeholder="intitule" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Nombre de place</label>
                <input type="number" class="form-control" name="nbre" value="<?=$table->nbre_place?>" placeholder="Nombre de place">
            </div>
        </div>
    </div>
    <p id="infoslogin" style="text-align: center;color: red"></p>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary mr-2"><i class="ft-check-square mr-1"></i>Enregister</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fermer"><i class="ft-x mr-1" ></i>Cancel</button>
    </div>
</form>
<script type="text/javascript">

    $('form').on('submit', function(){ 
        $(this).ajaxSubmit({
            beforeSend: function() {
                
            },
            uploadProgress: function(event, position, total, percentComplete) {
                
            },
            dataType:"json",
            success: function(data, statusText, xhr) {
                if (data.state == 'success') {
                    search();
                    toastr.success('Espace modifié avec succès.');
                    $("#fermer").trigger("click");
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