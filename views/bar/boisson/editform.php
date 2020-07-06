<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Modifier un boisson</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $boisson=Boisson::get($_REQUEST["id"]);
?>
<form action="bar/boisson/modifier" method="post">
    <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>">
    <div class="modal-body form-row">
        <div class="col-md-12 col-12">
            <center>
                <img id="imgpreviewad" class="btnaddimage" style="width: 98px;max-height: 98px;" src="image/<?=strlen($boisson->image)==0 ? 'default.png' : 'boisson/'.$boisson->image ?>"><br>
                <input type="file" id="inputimgad" name="imageadd" style="display: none;" accept=".png,.jpeg,.jpg">
            </center>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Categorie </label>
                <select class="form-control select2" name="categorie" required>
                    <?php
                        foreach (Categorie::q()->where("type=0")->execute() as $categorie) {
                    ?>
                        <option value="<?=$categorie->id?>" <?=$categorie->id==$boisson->idcategorie ? 'selected':''?> ><?=$categorie->intitule?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Nom *</label>
                <input type="text" class="form-control" name="intitule" value="<?=$boisson->intitule?>" placeholder="Nom" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Quantite initiale *</label>
                <input type="number" class="form-control" name="quantite" value="<?=$boisson->quantite?>"  placeholder="Quantite intiale" required>
            </div>
        </div>
        
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Prix *</label>
                <input type="number" class="form-control" name="prix" value="<?=$boisson->prix?>"  placeholder="Prix" required>
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
                    toastr.success('Boisson modifiée avec succès.');
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