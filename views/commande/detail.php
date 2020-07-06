<div class="main-content">
    <div class="content-overlay"></div>
    <div class="content-wrapper"><!-- Invoice template starts -->
    <div class="row">
        <div class="col-12">
        <div class="content-header">Facture</div>
        </div>
    </div>
    <?php
        $commande=Commande::get($_GET["action"]);
        $prix=0;
        foreach (Produit_commande::q()->where("idcommande=?",$commande->id)->execute() as $prodC) {
            if($prodC->type_element==0){
                $prix +=Boisson::get($prodC->idelement)->prix * $prodC->quantite;
            }else{
                $prix +=Plat::get($prodC->idelement)->prix * $prodC->quantite;
            }
        }
    ?>
    <section class="invoice-template">
        <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-content p-3">
                <div id="invoice-template" class="card-body pb-0">
                <!-- Invoice Company Details starts -->
                <div id="invoice-company-details" class="row">
                    <div class="col-md-6 col-12">
                    <div class="media">
                        <img src="app-assets/img/logos/logo-color-big.png" alt="company logo" width="80" height="80">
                        <div class="media-body ml-4">
                        <ul class="m-0 list-unstyled">
                            <li class="text-bold-800">Complexe DJEUKA</li>
                            <li>Nyalla, près de la station totale</li>
                            <li>Douala - Cameroun</li>
                        </ul>
                        </div>
                    </div>
        
                    </div>
                    <div class="col-md-6 col-12 text-right">
                    <h2 class="primary text-uppercase">Facture</h2>
                    <p class="pb-3"># FAC-<?=$commande->id?></p>
                    <ul class="px-0 list-unstyled">
                        <li>Net à payer</li>
                        <li class="font-medium-2 text-bold-700"><?=format_money($prix)?> FCFA</li>
                    </ul>
                    </div>
                </div>
                <!-- Invoice Company Details ends -->
                <!-- Invoice Customer Details starts -->
                <div id="invoice-customer-details" class="row">
                    <div class="col-12 text-left">
                    <!-- <p class="text-muted mb-1">Client</p> -->
                    </div>
                    <div class="col-md-6 col-12">
                    <ul class="m-0 list-unstyled">
                        <!-- <li class="text-bold-800">Mr. Bret Lezama</li>
                        <li>4879 Westfall Avenue,</li>
                        <li>Albuquerque,</li>
                        <li>New Mexico-87102.</li> -->
                    </ul>
                    </div>
                    <div class="col-md-6 col-12 text-right">
                    <p><span class="text-muted">Date de facturation :</span> <?=format_dateDate($commande->date)?></p>
                    <p><span class="text-muted">Pour :</span> Commande</p>
                    <p class="m-0"><span class="text-muted">Date de paiement :</span> <?=format_dateDate($commande->date)?></p>
                    </div>
                </div>
                <!-- Invoice Customer Details ends -->
                <!-- Invoice Items Details starts -->
                <div id="invoice-items-details">
                    <div class="row">
                    <div class="table-responsive col-12">
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produits &amp; Catégorie</th>
                                    <th class="text-right">Prix unitaire</th>
                                    <th class="text-right">Quantité</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; $montant=0;
                                    foreach (Produit_commande::q()->where("idcommande=?",$commande->id)->orderby("type_element desc")->execute() as $prodC) {
                                        if($prodC->type_element==0){
                                            $produit =Boisson::get($prodC->idelement);
                                            $categorie="Boisson";
                                        }else{
                                            $produit =Plat::get($prodC->idelement);
                                            $categorie="Repas";
                                        }
                                        $montant += $produit->prix * $prodC->quantite;
                                ?>
                                <tr>
                                    <th scope="row"><?=$i?></th>
                                    <td>
                                        <p><?=$produit->intitule?></p>
                                        <p class="text-muted"><?=$categorie?></p>
                                    </td>
                                    <td class="text-right"><?=format_money($produit->prix)?> FCFA</td>
                                    <td class="text-right"><?=$prodC->quantite?></td>
                                    <td class="text-right"><?=format_money($produit->prix * $prodC->quantite)?> FCFA</td>
                                </tr>
                                <?php $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="row mt-3 mt-md-0">
                    <div class="col-md-6 col-12 text-left">
                        <!-- <p class="text-bold-700 mb-1 ml-1">Payment Methods:</p>
                        <div class="row">
                        <div class="col-12">
                            <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                <td>Bank name:</td>
                                <td class="text-right">ABC Bank, USA</td>
                                </tr>
                                <tr>
                                <td>Acc name:</td>
                                <td class="text-right">Amanda Orton</td>
                                </tr>
                                <tr>
                                <td>IBAN:</td>
                                <td class="text-right">FGS165461646546AA</td>
                                </tr>
                                <tr>
                                <td>SWIFT code:</td>
                                <td class="text-right">BTNPP34</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div> -->
                    </div>
                    <div class="col-md-6 col-12" style="float:right">
                        <p class="text-bold-700 mb-2 ml-4">Total </p>
                        <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Sous Total</td>
                                <td class="text-right"><?=format_money($montant)?> FCFA</td>
                            </tr>
                            <!-- <tr>
                                <td>TAX (12%)</td>
                                <td class="text-right">$1,788.00</td>
                            </tr>
                            <tr>
                                <td class="text-bold-800">Total</td>
                                <td class="text-bold-800 text-right"> $16,688.00</td>
                            </tr> -->
                            <tr>
                                <td>Reduction</td>
                                <td class="danger text-right">(-) 0 FCFA</td>
                            </tr>
                            <tr class="text-bold-500">
                                <td>Net à payer</td>
                                <td class="text-right"><?=format_money($prix)?> FCFA</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Invoice Items Details ends -->
                <!-- Invoice Footer starts -->
                <div id="invoice-footer">
                    <div class="row mt-2 mt-sm-0">
                    <div class="col-md-6 col-12 d-flex align-items-center">
                        <div class="terms-conditions mb-2">
                        <h6>Terms & Condition</h6>
                        <p>You know, being a test pilot isn't always the healthiest business in the world. We predict too much for the next year and yet far too little for the next 10.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="signature text-center">
                        <p>La caissière</p>
                        <img src="app-assets/img/pages/signature-scan.png" alt="signature" width="250">
                        <h6 class="mt-4">M Yannick MPONO AMBASSA</h6>
                        <p class="text-muted">Promoteur du complexe DJEUKA</p>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-12 text-center text-sm-right">
                        <?php
                            if(checkPrivilege("print_commande") and $commande->paye=='1'){
                        ?>
                        <button type="button" class="btn btn-primary btn-print mt-2 mt-md-1"><i class="ft-printer mr-1"></i>Imprimer la facture</button>
                        <?php
                            }
                        ?>
                    </div>
                    </div>
                </div>
                <!-- Invoice Footer ends -->
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    </div>
</div>
<script src="app-assets/vendors/js/jquery.min.js"></script>
<script src="app-assets/vendors/js/jquery.slimscroll.js"></script>
<script src="app-assets/vendors/js/jquery.min.js"></script>
<script src="app-assets/vendors/js/vendors.min.js"></script>
<script src="app-assets/vendors/js/switchery.min.js"></script>
<script src="app-assets/vendors/js/select2.full.min.js"></script>
<script src="app-assets/vendors/js/toastr.min.js"></script>
<script src="app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
<script src="app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>
<script src="app-assets/js/core/app-menu.min.js"></script>
<script src="app-assets/js/core/app.min.js"></script>
<script src="app-assets/js/notification-sidebar.min.js"></script>
<script src="app-assets/js/customizer.min.js"></script>
<script src="app-assets/js/scroll-top.min.js"></script>
<script src="app-assets/js/page-invoice.min.js"></script>
<script src="app-assets/js/data-tables/dt-api.js"></script>
<script src="app-assets/js/select2.min.js"></script>
<script src="app-assets/js/ex-component-toastr.min.js"></script>
<script src="app-assets/vendors/js/jquery.form.js"></script>
<script src="assets/js/scripts.js"></script>