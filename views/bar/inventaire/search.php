<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Boisson</th>
            <th>Quantite initiale</th>
            <th>Entrées en stock</th>
            <th>Sortie en stock</th>
            <th>Commandes</th>
            <th>Stock actuel</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $suite = '';$suite1 = '';$suite2 = '';
        if (isset($_REQUEST['datedeb']) AND strlen($_REQUEST['datedeb'])>0) {
            $suite1 .= ' AND DATE_FORMAT(date,\'%Y-%m-%d\') >= "'.$_REQUEST['datedeb'].'"';
            $suite2 .= ' and idcommande in ( SELECT id from commande where DATE_FORMAT(date,\'%Y-%m-%d\') >= "'.$_REQUEST['datedeb'].'" ) ';
        }
        if (isset($_REQUEST['datefin']) AND strlen($_REQUEST['datefin'])>0) {
            $suite1 .= ' AND DATE_FORMAT(date,\'%Y-%m-%d\') <= "'.$_REQUEST['datefin'].'"';
            $suite2 .= ' and idcommande in ( SELECT id from commande where DATE_FORMAT(date,\'%Y-%m-%d\') <= "'.$_REQUEST['datedeb'].'" ) ';
        }
        if (isset($_REQUEST['categorie']) AND strlen($_REQUEST['categorie'])>0) {
                $suite .=' and idcategorie="'.$_REQUEST['categorie'].'" ';
        }
        foreach (Boisson::q()->where("id is not null".$suite)->execute() as $boisson) {
            $entree=0; $sortie=0; $stock=0; $commande=0;
            foreach (Stock::q()->where("idelement=? and type_element=0 and type=0".$suite1,$boisson->id)->execute() as $e) {
                $entree+=$e->quantite;
            }
            foreach (Stock::q()->where("idelement=? and type_element=0 and type=1".$suite1,$boisson->id)->execute() as $s) {
                $sortie+=$s->quantite;
            }
            foreach (Produit_commande::q()->where("idelement=? and type_element=0  and idcommande in (select id from commande where servi=1 ".$suite1." )",$boisson->id)->execute() as $s) {
                $commande+=$s->quantite;
            }
            $stock= $boisson->quantite + $entree - $sortie - $commande;
    ?>
        <tr>
            <td><?=$boisson->intitule?></td>
            <td><?=$boisson->quantite?></td>
            <td><?=$entree?></td>
            <td><?=$sortie?></td>
            <td><?=$commande?></td>
            <td><?=$stock?></td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>