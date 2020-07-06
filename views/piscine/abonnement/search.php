<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Client</th>
            <th>Date de début</th>
            <th>Durée <small>en mois</small></th>
            <th>Montant </th>
            <th>Avance </th>
            <th>Reste </th>
            <th>Etat</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Souscription::q()->where("type=1")->execute() as $souscription) {
    ?>
        <tr>
            <td><?=Client::get($souscription->idclient)->nom?></td>
            <td><?=format_dateDate($souscription->date)?></td>
            <td><?=$souscription->nbre?></td>
            <td><?=$souscription->avance + $souscription->reste?></td>
            <td><?=$souscription->avance?></td>
            <td><?=$souscription->reste?></td>
            <td>
                <?php
                    if (date("Y-m-d")<=endMonth($souscription->date,$souscription->nbre)) {
                       echo "<span class='badge badge-pill bg-light-success mb-1 mr-2'>Valide</span>";
                    }else{
                        echo "<span class='badge badge-pill bg-light-danger mb-1 mr-2'>Non valide</span>";
                    }
                ?>
            </td>
            <td class="text-truncate">
                <?php if(checkPrivilege("edit_abonnement")){ ?>
                    <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$souscription->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_abonnement")){ ?>
                    <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$souscription->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>