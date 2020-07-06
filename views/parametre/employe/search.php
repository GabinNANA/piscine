<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Poste</th>
            <th>Date de recrutement</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Employe::q()->execute() as $employe) {
    ?>
        <tr>
            <td><?=$employe->nom?></td>
            <td><?=$employe->telephone?></td>
            <td><?=$employe->adresse?></td>
            <td><?=$employe->poste?></td>
            <td><?=format_dateDate($employe->date_recrutement)?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_employe")){ ?>
                <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$employe->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php  } ?>
                <?php if(checkPrivilege("delete_employe")){ ?>
                <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$employe->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php  } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>