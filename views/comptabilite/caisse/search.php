<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Intitule</th>
            <th>Solde initial</th>
            <th>Total versement</th>
            <th>Total depense</th>
            <th>Solde actuel</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Caisse::q()->execute() as $caisse) {
    ?>
        <tr>
            <td><?=$caisse->intitule?></td>
            <td><?=$caisse->solde_initial?></td>
            <td><?=$caisse->totalversement?></td>
            <td><?=$caisse->totaldepense?></td>
            <td><?=$caisse->solde?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_caisse")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$caisse->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_caisse")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$caisse->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>