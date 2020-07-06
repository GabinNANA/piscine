<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Modifier un utilisateur</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $utilisateur=Utilisateur::get($_REQUEST["id"]);
?>
<form action="parametre/utilisateur/modifier" method="post">
    <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>">
    <div class="modal-body form-row">
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Role *</label> 
                <select class="form-control select2" name="role" required>
                    <?php
                        foreach (Role::q()->execute() as $role) {
                    ?>
                        <option value="<?=$role->id?>" <?=$role->id==$utilisateur->idrole ? "selected":""?> ><?=$role->intitule?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Pseudo *</label>
                <input type="text" class="form-control" name="pseudo"  value="<?=$utilisateur->pseudo?>" placeholder="Pseudo" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Password *</label>
                <input type="password" class="form-control" name="password" value="<?=$utilisateur->password?>" placeholder="Mot de passe" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Relier à un employé</label> 
                <select class="form-control select2" name="employe" >
                    <option value=""></option>
                    <?php
                        foreach (Employe::q()->execute() as $employe) {
                    ?>
                        <option value="<?=$employe->id?>" <?=$role->id==$utilisateur->idemploye ? "selected":""?>><?=$employe->intitule?></option>
                    <?php
                        }
                    ?>
                </select>
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
                    toastr.success('Utilisateur Modifié avec succès.');
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