<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Nombre de place</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $suite='';
        if (isset($_REQUEST['espace']) AND strlen($_REQUEST['espace'])>0) {
            $suite .= ' AND idespace = "'.$_REQUEST['espace'].'" ';
        }
        foreach (Table::q()->where("id is not null".$suite)->execute() as $table) {
    ?>
        <tr>
            <td><?=$table->intitule?></td>
            <td><?=$table->nbre_place?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_table")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$table->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_table")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$table->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>