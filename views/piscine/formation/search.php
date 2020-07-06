<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Client</th>
            <th>Moniteur</th>
            <th>Nombre de séance</th>
            <th>Date debut</th>
            <th>Montant </th>
            <th>Avance </th>
            <th>Reste </th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Souscription::q()->where("type=0")->execute() as $souscription) {
    ?>
        <tr>
            <td><?=Client::get($souscription->idclient)->nom?></td>
            <td><?=$souscription->idemploye>0 ? Employe::get($souscription->idemploye)->nom:''?></td>
            <td><?=$souscription->nbre?></td>
            <td><?=format_dateDate($souscription->date)?></td>
            <td><?=format_money($souscription->avance + $souscription->reste)?></td>
            <td><?=format_money($souscription->avance)?></td>
            <td><?=format_money($souscription->reste)?></td>
            <td class="text-truncate">
                <?php if(checkPrivilege("voir_formation")){ ?>
                    <a href="javascript:;" class="primary p-0 voir-row" data-id="<?=$souscription->id?>" data-toggle="tooltip" data-placement="top" title="Voir séances" data-original-title="Voir séances"><i class="ft-eye font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("edit_formation")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$souscription->id?>" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_formation")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$souscription->id?>" data-toggle="tooltip" data-placement="top" title="Supprimer" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>