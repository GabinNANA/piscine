<table class="table table-striped table-bordered add-rows">
    <thead>
    <tr>
        <th> Justificatif </th>
        <th> Date </th>
        <th> Opération </th>
        <th> Transaction </th>
        <th> Caisse </th>
        <th> Intitulé </th>
        <th> Recette </th>
        <th> Dépense </th>
        <th> Solde </th>
    </tr>
    </thead>
    <tbody>
    <?php
        $rec = 0; $dep = 0; 
        $suite = '';
        if (isset($_REQUEST['datedeb']) AND strlen($_REQUEST['datedeb'])>0) {
            $suite .= ' AND DATE_FORMAT(date,\'%Y-%m-%d\') >= "'.$_REQUEST['datedeb'].'"';
        }
        if (isset($_REQUEST['datefin']) AND strlen($_REQUEST['datefin'])>0) {
            $suite .= ' AND DATE_FORMAT(date,\'%Y-%m-%d\') <= "'.$_REQUEST['datefin'].'"';
        }
        if (isset($_REQUEST['operation']) AND strlen($_REQUEST['operation'])>0) {
                $suite .=' and operation="'.$_REQUEST['operation'].'" ';
        }
        if (isset($_REQUEST['caisse']) AND strlen($_REQUEST['caisse'])>0) {
            $suite .=' and idcaisse="'.$_REQUEST['caisse'].'" ';
        }
        if (isset($_REQUEST['transaction']) AND strlen($_REQUEST['transaction'])>0) {
            $suite .=' and type_operation="'.$_REQUEST['transaction'].'" ';
        }
        foreach (Mouvement::q()->where("idcaisse in (select id from caisse)".$suite)->orderby("id desc")->execute() as $mouvement) {
    ?>
    <tr class="gradeX">
        <td>
        <?php if(checkPrivilege("voir_doc") and strlen($mouvement->justificatif)>0){ ?>
            <center><a href="image/transaction/<?=$mouvement->justificatif?>" target="_blank" class="on-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir"><i class="fa fa-eye"></i></a></center>
        <?php } ?>
        </td>
        <td> <?=format_dateDate($mouvement->date)?> </td>
        <td> 
        <?php
        switch($mouvement->operation){
        case 0: echo "Recette"; break;
        case 1: echo "Dépense"; break;
        case 2: echo "Transfert"; break;
        default: break;
        }
        ?>
        </td>
        <td> 
        <?php
        switch($mouvement->type_operation){
            case 0: echo "Commande"; break;
            case 1: echo "Reservation"; break;
            case 2: echo "Souscription"; break;
            case 3: echo "Location maillots"; break;
            case 4: echo "Sortie de stock"; break;
            case 5: echo "Autres"; break;
            case 6: echo "Payement à l'entrée"; break;
            default: break;
        }
        ?>
        </td>
        <td> <?=Caisse::get($mouvement->idcaisse)->intitule?></td>
        <td> <?=$mouvement->intitule?> </td>
        <td> <?=$mouvement->recette?> </td>
        <td> <?=$mouvement->depense?> </td>
        <td> <?=$mouvement->solde?> </td>
    </tr>
    <?php
        $rec += $mouvement->recette;
        $dep += $mouvement->depense;
        }
    ?>
    </tbody>
</table><br><br>
<table class="table table-striped table-bordered" >
    <thead>
    <tr>
        <th>Encaissements</th>
        <th>Décaissements</th>
        <th>Différence</th>
    </tr>
    </thead>
    <tbody>
    <tr class="gradeX">
        <td><?=format_money($rec)?></td>
        <td><?=format_money($dep)?></td>
        <td><?=format_money($rec - $dep)?></td>      
    </tr>
</table>