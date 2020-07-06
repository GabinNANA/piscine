<table class="table table-striped table-bordered add-rows">
    <thead>
        <tr>
            <th>Pseudo</th>
            <th>Mot de passe</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach (Utilisateur::q()->execute() as $utilisateur) {
    ?>
        <tr>
            <td><?=$utilisateur->pseudo?></td>
            <td><?=$utilisateur->password?></td>
            <td><?=Role::get($utilisateur->idrole)->intitule?></td>
            <td class="text-truncate">
                <?php
                    if(strlen($utilisateur->idemploye)>0 and $utilisateur->idemploye>0 and checkPrivilege("voir_utilisateur")){
                ?>
                <a href="javascript:;" class="info p-0 voir-row" data-id="<?=$utilisateur->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir detail de l'employé"><i class="ft-user font-medium-3 mr-2"></i></a>
                <?php
                    }
                ?>
                <?php if(checkPrivilege("edit_utilisateur")){ ?>
                <a href="javascript:;" class="success p-0 edit-row" data-id="<?=$utilisateur->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier"><i class="ft-edit-2 font-medium-3 mr-2"></i></a>
                <?php } ?>
                <?php if(checkPrivilege("delete_utilisateur")){ ?>
                <a href="javascript:;" class="danger p-0 delete-row" data-id="<?=$utilisateur->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="ft-x font-medium-3"></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>