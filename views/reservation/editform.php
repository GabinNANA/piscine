<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Modifier une reservation</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $commande=Commande::get($_REQUEST["id"]);
    $paye=$commande->reste==0 ? "disabled":'';
?>
<form action="reservation/modifier" method="post">
    <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>">
    <div class="modal-body form-row">
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Client *</label>
                <select class="form-control select2" name="client" required <?=$paye?>>
                    <?php
                        foreach (Client::q()->execute() as $client) {
                    ?>
                       <option value="<?=$client->id?>" <?=$commande->idclient==$client->id ? 'selected':''?> ><?=$client->nom?></option>
                   <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Faire un paiement </label>
                <input type="number" class="form-control" min=0 name="avance" placeholder="Avance" id="avance" >
            </div>
        </div>
        <div class="col-md-4 col-6" style="<?=date("Y-m-d")> $commande->date ? 'display:none;':''?>">
            <div class="form-group mb-2">
                <label for="basic-form-2">Servi </label>
                <select class="form-control select2" name="servi" required>
                    <option value="0" <?=$commande->servi=='0' ? 'selected':''?> >Non</option>
                    <option value="1" <?=$commande->servi=='1' ? 'selected':''?> >Oui</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Réservation pour le : *</label>
                <input type="date" class="form-control"  name="date"  min='<?=date("Y-m-d")?>' value="<?=$commande->date?>" placeholder="Réservation pour le :" required>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">De : *</label>
                <input type="time" class="form-control"  name="heuredeb" value="<?=$commande->heuredeb?>" placeholder="De :" required>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">A : </label>
                <input type="time" class="form-control"  name="heurefin" value="<?=$commande->heurefin?>" placeholder="A :" >
            </div>
        </div>
        <div class="col-md-12 col-6" id="caisse" style="display:none">
            <div class="form-group mb-2">
                <label for="basic-form-2">Caisse </label>
                <select class="form-control select2" name="caisse" id="select_caisse">
                    <?php
                        foreach (Caisse::q()->execute() as $caisse) {
                    ?>
                        <option value="<?=$caisse->id?>" ><?=$caisse->intitule?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Espace </label>
                <select class="form-control select2" name="espace[]" multiple id="espace"  <?=$paye?>>
                <?php $selected="";
                    foreach (Espace::q()->execute() as $espace) {
                        if(in_array($espace->id, explode(',',$commande->idespace))){
                            $selected="selected";
                        }
                ?>
                    <option value="<?=$espace->id?>" <?=$selected?> ><?=$espace->intitule?></option>
                <?php $selected="";
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Repas </label>
                <select class="form-control select2" name="repas[]" id="repas" multiple  <?=$paye?>>
                <?php $selected="";
                    foreach (Plat::q()->where("idcategorie in (select id from categorie where type=1)")->execute() as $plat) {
                        if(isset(produit_commande::q()->where("idcommande=? and idelement=? and type_element=1",$commande->id,$plat->id)->execute()[0])){
                            $selected="selected";
                        }
                ?>
                    <option value='<?=$plat->id?>' <?=$selected?> ><?=$plat->intitule?></option>"
                <?php $selected="";
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Boissons </label>
                <select class="form-control select2" name="boisson[]" id="boisson" multiple  <?=$paye?>>
                <?php 
                    foreach (Categorie::q()->where("type=0")->execute() as $categorie) {
                ?>
                    <optgroup label="<?=$categorie->intitule?>">
                <?php $selected="";
                    foreach (Boisson::q()->where("idcategorie=?",$categorie->id)->execute() as $boisson) {
                        if(isset(produit_commande::q()->where("idcommande=? and idelement=? and type_element=0",$commande->id,$boisson->id)->execute()[0])){
                            $selected="selected";
                        }
                ?>
                    <option value='<?=$boisson->id?>' <?=$selected?> ><?=$boisson->intitule?></option>
                <?php $selected="";
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
        <div class="col-md-12 col-12">
            <div class="form-group mb-2 text-center">
                    <h2>Total de la facture : <span id="sum">0</span> FCFA</h2>
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
    var prix=0;
    $("#avance").on("keyup",function(){ 
        if($(this).val()>0){ 
            $("#caisse").show();
            $("#select_caisse").attr("required",true);
        }else{ 
            $("#caisse").hide();
            $("#select_caisse").attr("required",false);
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
                    toastr.success('Reservation modifiée avec succès.');
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
        var id="<?=$commande->id?>";
        var paye="<?=$paye?>";
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
        var selectedList2 = new Array();
        var selectBox2 = document.forms[0].espace;
        var select2='';
        for (var i=0; i<selectBox2.options.length; i++) {
            if (selectBox2.options[i].selected==true) {
            selectedList2.push(selectBox2.options[i]);
            }
        }
        for (opt in selectedList2) { 
            if(select2==""){
                select2 =selectedList2[opt].value;
            }else{
                select2 =select2+","+selectedList2[opt].value;
            }
        }
        $.ajax({
            type: "POST",
            url: "reservation/tableau",
            data: {'select':select,'select1':select1,'select2':select2,'id':id,'paye':paye},
            dataType: "json",
            success: function(data){
                $("#dynamic_field").html(data.tableau);
                prix=data.prix;
                calculateSum();
            }
        });
    }
    
    function calculateSum() {
        var sum = 0;
        //iterate through each textboxes and add the values
        $(".new").each(function () { 
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat($(this).data("price"))* parseFloat(this.value);
            }
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#sum").html((prix + sum).toFixed(2));
    }
</script>