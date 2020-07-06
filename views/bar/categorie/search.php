<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (categorie::q()->where("type=0")->execute() as $categorie) {
    ?>
        <tr>
            <td><?=$categorie->intitule?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_categorie")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$categorie->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_categorie")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$categorie->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>