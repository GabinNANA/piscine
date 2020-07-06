<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Modifier un employé</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $employe=employe::get($_REQUEST["id"]);
?>
<form action="parametre/employe/modifier" method="post">
    <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>">
    <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Nom *</label>
                <input type="text" class="form-control" name="nom" value="<?=$employe->nom?>" placeholder="Nom" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Téléphone *</label>
                <input type="number" class="form-control" name="telephone" value="<?=$employe->telephone?>" placeholder="Téléphone" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Adresse </label>
                <input type="text" class="form-control" name="adresse" value="<?=$employe->adresse?>" placeholder="Adresse" >
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Poste </label>
                <input type="text" class="form-control" name="poste" value="<?=$employe->poste?>" placeholder="Poste" >
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Date de recrutement *</label>
                <input type="date" class="form-control" name="date" value="<?=$employe->date_recrutement?>" date="<?=date('Y-m-d')?>" required>
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
                    toastr.success('Employé modifié avec succès.');
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