<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Modifier une séance</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $seance=Seance::get($_REQUEST["id"]);
?>
<form action="piscine/seance/modifier" method="post">
    <input type="hidden" name="souscription" value="<?=$_REQUEST["souscription"]?>">
    <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>">
    <div class="modal-body form-row">
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Date *</label>
                <input type="date" class="form-control" name="date" value="<?=$seance->date?>" placeholder="Date" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Heure de debut *</label>
                <input type="time" class="form-control" name="heuredeb" value="<?=$seance->heuredeb?>" placeholder="Heure de debut" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Heure de fin *</label>
                <input type="time" class="form-control" name="heurefin" value="<?=$seance->heurefin?>" placeholder="Heure de fin" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Statut </label>
                <select type="text" class="form-control" name="statut">
                    <option value="1" <?=$seance->statut=='1' ? 'selected':''?> >Effectué</option>
                    <option value="0" <?=$seance->statut=='0' ? 'selected':''?> >Non éffectué</option>
                </select>
            </div>
        </div>
    </div>
    <p id="infoslogin" style="text-align: center;color: red"></p>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary mr-2"><i class="ft-check-square mr-1"></i>Enregister</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fermerseance"><i class="ft-x mr-1" ></i>Cancel</button>
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
                    window.location='piscine/formation';
                    // toastr.success('Séance modifié avec succès.');
                    // $("#fermerseance").trigger("click");
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