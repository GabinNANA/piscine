<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Client::q()->execute() as $client) {
    ?>
        <tr>
            <td><?=$client->nom?></td>
            <td><?=$client->telephone?></td>
            <td><?=$client->email?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_client")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$client->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_client")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$client->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>