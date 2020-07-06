<style type="text/css">
    .select2-container{
      width: 100% !important;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel1">Détails de l'employé</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
    </button>
</div>
<?php
    $employe=Employe::get(Utilisateur::get($_REQUEST["id"])->idemploye);
?>
<div class="modal-body form-row">
    <div class="col-md-12 col-12">
        <div class="form-group mb-2">
            <label for="basic-form-1">Nom : </label> <?=$employe->nom?>
        </div>
    </div>
    <div class="col-md-12 col-12">
        <div class="form-group mb-2">
            <label for="basic-form-1">Adresse : </label> <?=$employe->adresse?>
        </div>
    </div>
    <div class="col-md-12 col-12">
        <div class="form-group mb-2">
            <label for="basic-form-1">Téléphone : </label> <?=$employe->telephone?>
        </div>
    </div>
    <div class="col-md-12 col-12">
        <div class="form-group mb-2">
            <label for="basic-form-1">Poste : </label> <?=$employe->poste?>
        </div>
    </div>
    <div class="col-md-12 col-12">
        <div class="form-group mb-2">
            <label for="basic-form-1">Date de recrutement : </label> <?=format_dateDate($employe->date_recrutement)?>
        </div>
    </div>
</div>
<p id="infoslogin" style="text-align: center;color: red"></p>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="fermer"><i class="ft-x mr-1" ></i>Fermer</button>
</div>