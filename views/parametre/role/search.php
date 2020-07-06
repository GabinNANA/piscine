<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Intitule</th>
            <th>Abreviation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Role::q()->execute() as $role) {
    ?>
        <tr>
            <td><?=$role->intitule?></td>
            <td><?=$role->abr?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_role")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$role->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_role")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$role->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>