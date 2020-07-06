<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Ajouter un abonnement</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>

<form action="piscine/abonnement/ajouter" method="post">
    <input type="hidden" name="employe" value=''>
    <input type="hidden" name="type" value='1'>
    <div class="modal-body form-row">
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Client *</label>
                <select type="text" class="form-control" name="client" placeholder="client" required>
                    <?php
                        foreach (Client::q()->execute() as $client) {
                    ?>
                        <option value="<?=$client->id?>"><?=$client->nom?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">A partir du *</label>
                <input type="date" class="form-control" name="date" placeholder="Date" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Montant mensuel*</label>
                <input type="number" class="form-control" name="montant" placeholder="Montant" value="<?=Prix::get(3)->prix?>" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Durée *</label> <small> en mois</small>
                <input type="number" class="form-control" name="nbre" placeholder="Duree" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Avance </label>
                <input type="number" class="form-control" name="avance" placeholder="Avance" >
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
                    toastr.success('Abonnement créé avec succès.');
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