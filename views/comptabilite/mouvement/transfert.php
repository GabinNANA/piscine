<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Transférer</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>

<form action="comptabilite/mouvement/transferer" method="post" enctype="multipart/form-data">
<input type="hidden" name="operation" value="0" >
    <div class="modal-body form-row">
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Caisse source *</label>
                <select class="form-control" name="source" required="" id="source">
                    <?php
                        foreach (Caisse::q()->execute() as $caisse) {
                    ?>
                        <option value="<?=$caisse->id?>" > <?=$caisse->intitule?> </option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-1">Caisse de destination *</label>
                <select class="form-control" name="destination" required="" id="destination">
                    <?php
                        foreach (Caisse::q()->execute() as $caisse) {
                    ?>
                        <option value="<?=$caisse->id?>" > <?=$caisse->intitule?> </option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Montant *</label>
                <input type="number" class="form-control" name="montant" placeholder="Montant" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="basic-form-2">Date *</label>
                <input type="date" class="form-control" name="date" value="<?=date("Y-m-d")?>" placeholder="Date" required>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="form-group mb-2">
                <label for="inputGroupFile01">Choisir un justificatif</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="inputGroupFile01"  accept='.pdf,.png,.jpeg,.jpg,.txt,.pdf' >
                    <label class="custom-file-label" for="inputGroupFile01">Choisir un fichier</label>
                </div>
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
                    toastr.success('Transfert éffectué avec succès.');
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
    $(document).on('change','#source',function(){
        var val = $(this).val();
        $.ajax({
            type: "POST",
            url: "comptabilite/mouvement/destination",
            data: {'val':val},
            dataType: "json",
            success: function(data){
                $("#destination").html(data.info);
            }
        });
    });
</script>