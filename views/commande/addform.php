<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Ajouter une commande</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $val='';
?>
<form action="commande/ajouter" method="post">
    <div class="modal-body form-row">
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Table *</label>
                <select class="form-control select2" name="table" required>
                    <?php
                        foreach (Espace::q()->execute() as $espace) {
                    ?>
                        <optgroup label="<?=$espace->intitule?>">
                    <?php
                        foreach (Table::q()->where("idespace=?",$espace->id)->execute() as $table) {
                    ?>
                        <option value="<?=$table->id?>" ><?=$table->intitule?></option>
                    <?php
                        }
                    ?>
                        </optgroup>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="form-group mb-2">
                <label for="basic-form-2">Servi </label>
                <select class="form-control select2" name="servi" required>
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Payé </label>
                <select class="form-control select2" name="paye" required id="paye">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-6" id="caisse" style="display:none">
            <div class="form-group mb-2">
                <label for="basic-form-2">Caisse </label>
                <select class="form-control select2" name="caisse" id="select_caisse">
                    <?php
                        foreach (Caisse::q()->execute() as $caisse) {
                    ?>
                        <option value="<?=$caisse->id?>"><?=$caisse->intitule?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Repas </label>
                <select class="form-control select2" name="repas[]" id="repas" multiple>
                <?php
                    foreach (Plat::q()->where("etat=1 and idcategorie in (select id from categorie where type=1 and heuredeb<? and heurefin>?)",date("H:i:s"),
                    date("H:i:s"))->execute() as $plat) {
                ?>
                    <option value='<?=$plat->id?>' ><?=$plat->intitule?></option>"
                <?php
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Boissons </label>
                <select class="form-control select2" name="boisson[]" id="boisson" multiple>
                <?php
                    foreach (Categorie::q()->where("type=0")->execute() as $categorie) {
                ?>
                    <optgroup label="<?=$categorie->intitule?>">
                <?php
                    foreach (Boisson::q()->where("idcategorie=?",$categorie->id)->execute() as $boisson) {
                        if(enstock($boisson->id)>0){
                ?>
                    <option value='<?=$boisson->id?>' ><?=$boisson->intitule?></option>
                <?php
                        }
                    }
                ?>
                    </optgroup>
                <?php
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
            <table class="table table-striped table-bordered add-rows" id="dynamic_field">
            </table>
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
    $("#paye").on("change",function(){
        if($(this).val()==0){
            $("#caisse").hide();
            $("#select_caisse").attr("required",false);
        }else{
            $("#caisse").show();
            $("#select_caisse").attr("required",true);
        }
    });

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
                    toastr.success('Commande créé avec succès.');
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
    $("#repas").on("change",function(){
        tableau();
    });
    $("#boisson").on("change",function(){
        tableau();
    });
        function tableau () {
            var selectedList = new Array();
            var selectBox = document.forms[0].repas;
            var select='';
            for (var i=0; i<selectBox.options.length; i++) {
                if (selectBox.options[i].selected==true) {
                selectedList.push(selectBox.options[i]);
                }
            }
            for (opt in selectedList) { 
                if(select==""){
                    select =selectedList[opt].value;
                }else{
                    select =select+","+selectedList[opt].value;
                }
            }
            var selectedList1 = new Array();
            var selectBox1 = document.forms[0].boisson;
            var select1='';
            for (var i=0; i<selectBox1.options.length; i++) {
                if (selectBox1.options[i].selected==true) {
                selectedList1.push(selectBox1.options[i]);
                }
            }
            for (opt in selectedList1) { 
                if(select1==""){
                    select1 =selectedList1[opt].value;
                }else{
                    select1 =select1+","+selectedList1[opt].value;
                }
            }
            $.ajax({
                type: "POST",
                url: "commande/tableau",
                data: {'select':select,'select1':select1},
                dataType: "json",
                success: function(data){
                    $("#dynamic_field").html(data.tableau);
                }
            });
        }
</script>