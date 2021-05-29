<?php
// Ajout d'une ligne supplémentaire de tarif
function gestion_tarif_ajout() {
	global $wpdb, $table_gt; // insérer les variables globales

	$sql = $wpdb->get_results("SELECT * FROM $table_gt");
	foreach($sql as $row) {
		$gestion_tarif_titre = $_POST['gestion_titre'][$row->{id}];
		$gestion_tarif_tarif = $_POST['gestion_tarif'][$row->{id}];
		$gestion_tarif_devise = $_POST['gestion_devise'][$row->{id}];
		$gestion_tarif_type = $_POST['gestion_type'][$row->{id}];
		$gestion_tarif_tva = $_POST['gestion_tva'][$row->{id}];
		$gestion_tarif_tariffinal = $_POST['gestion_tariffinal'][$row->{id}];
		$gestion_tarif_resultat = $wpdb->update($table_gt, array('titre' => $gestion_tarif_titre, 'tarif' => $gestion_tarif_tarif, 'devise' => $gestion_tarif_devise, 'type' => $gestion_tarif_type, 'tva' => $gestion_tarif_tva, 'tariffinal' => $gestion_tarif_tariffinal), array('id' => $row->{id}));
	}
	
	$gestion_tarif_resultat = $wpdb->insert($table_gt, array('titre' => '', 'tarif' => '', 'devise' => '€', 'type' => 'H.T.', 'tva' => '1', 'tariffinal' => ''));
}

// Modification d'une ligne de tarif
function gestion_tarif_modif() {
	global $wpdb, $table_gt; // insérer les variables globales

	$sql = $wpdb->get_results("SELECT * FROM $table_gt");
	foreach($sql as $row) {
		$gestion_tarif_titre = $_POST['gestion_titre'][$row->{id}];
		$gestion_tarif_tarif = $_POST['gestion_tarif'][$row->{id}];
		$gestion_tarif_devise = $_POST['gestion_devise'][$row->{id}];
		$gestion_tarif_type = $_POST['gestion_type'][$row->{id}];
		$gestion_tarif_tva = $_POST['gestion_tva'][$row->{id}];
		$gestion_tarif_tariffinal = $_POST['gestion_tariffinal'][$row->{id}];
		$gestion_tarif_resultat = $wpdb->update($table_gt, array('titre' => $gestion_tarif_titre, 'tarif' => $gestion_tarif_tarif, 'devise' => $gestion_tarif_devise, 'type' => $gestion_tarif_type, 'tva' => $gestion_tarif_tva, 'tariffinal' => $gestion_tarif_tariffinal), array('id' => $row->{id}));
	}
}

// Suppression d'une ligne de tarif
function gestion_tarif_suppr($param) {
	global $wpdb, $table_gt; // insérer les variables globales
	$wpdb->query("DELETE FROM $table_gt WHERE id = $param");
	wp_redirect( $_SERVER['PHP_SELF'].'?page=gestion_tarifs', 301);
	exit;
}

// Afficher la page d'options dans le backoffice
function gestion_tarifs_admin_affichage() {
	global $wpdb, $table_gt; // insérer les variables globales
	
	// Déclencher la fonction d'ajout
	if(isset($_POST['add_gestion_tarifs']) && $_POST['add_gestion_tarifs'] == 'Ajouter un tarif') {
		gestion_tarif_ajout();
	}
	// Déclencher la fonction de modification
	if((isset($_POST['action_gestion_tarifs']) && $_POST['action_gestion_tarifs'] == "Enregistrer") || (isset($_POST['action_update_gestion_tarifs']) && $_POST['action_update_gestion_tarifs'] == "Mettre à jour")) {
		gestion_tarif_modif();
	}
?>
	<script type="text/javascript">
		function calcul(param) {
			document.getElementById('gestion_tariffinal_'+param).value = Math.round(
				(document.getElementById('gestion_tarif_'+param).value)
			*	(document.getElementById('gestion_tva_'+param).value) * 100)/100 ;
		}
    </script>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2><?php _e('Gestion des tarifs' , 'gestion-tarifs'); ?></h2>
        <br />
        <?php _e('Remplissez le formulaire et le nombre de tarifs qui vous intéressent.' , 'gestion-tarifs'); ?><br/>
        <?php _e('Recopier les shortcodes dans vos articles ou vos pages : [tarif id="n"] pour les tarifs à afficher et [intitule id="n"] pour les intitulés connexes.' , 'gestion-tarifs'); ?><br/><br/>
    </div>
	<form name="form_gestion_tarifs" id="form" method="post" action="admin.php?page=gestion_tarifs">
    <table class="widefat">
    <thead>
        <tr>
            <th class="th1"><?php _e('Intitulé du tarif' , 'gestion-tarifs'); ?></th>
            <th class="th2"><?php _e('Tarif (numérique)' , 'gestion-tarifs'); ?></th>
            <th class="th3"><?php _e('Devise' , 'gestion-tarifs'); ?></th>
            <th class="th4"><?php _e('Type' , 'gestion-tarifs'); ?></th>
            <th class="th5"><?php _e('TVA appliquée' , 'gestion-tarifs'); ?></th>
            <th class="th6"><?php _e('Tarif définitif' , 'gestion-tarifs'); ?></th>
            <th class="th7"><?php _e('Shortcode -> Tarif' , 'gestion-tarifs'); ?></th>
            <th class="th8"><?php _e('Shortcode -> Intitulé' , 'gestion-tarifs'); ?></th>
            <th class="th9"></th>
			<th class="th10"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th class="th1"><?php _e('Intitulé du tarif' , 'gestion-tarifs'); ?></th>
            <th class="th2"><?php _e('Tarif (numérique)' , 'gestion-tarifs'); ?></th>
            <th class="th3"><?php _e('Devise' , 'gestion-tarifs'); ?></th>
            <th class="th4"><?php _e('Type' , 'gestion-tarifs'); ?></th>
            <th class="th5"><?php _e('TVA appliquée' , 'gestion-tarifs'); ?></th>
            <th class="th6"><?php _e('Tarif définitif' , 'gestion-tarifs'); ?></th>
            <th class="th7"><?php _e('Shortcode -> Tarif' , 'gestion-tarifs'); ?></th>
            <th class="th8"><?php _e('Shortcode -> Intitulé' , 'gestion-tarifs'); ?></th>
            <th class="th9"></th>
			<th class="th10"></th>
        </tr>
    </tfoot>
    <tbody class="sortableTable">
<?php
	$ligne_tarif = $wpdb->get_results("SELECT * FROM $table_gt ORDER BY id ASC");
	foreach ($ligne_tarif as $rangee) {
	// Déclencher la fonction de suppression
	if(isset($_POST['action_delete_gestion_tarifs_'][$rangee->id]) && $_POST['action_delete_gestion_tarifs_'][$rangee->id] == 'Supprimer') {		
		gestion_tarif_suppr($rangee->id);
	}
?>
            <tr>
                <td>
                    <input type="text" name="gestion_titre[<?php echo $rangee->id; ?>]" value="<?php if($rangee->titre != '') { echo $rangee->titre; } ?>" id="tarif-titre" />
                </td>
                <td>
                    <input type="text" name="gestion_tarif[<?php echo $rangee->id; ?>]" id="gestion_tarif_<?php echo $rangee->id; ?>" value="<?php if($rangee->tarif != '') { echo $rangee->tarif; } ?>" onkeyup="calcul(<?php echo $rangee->id; ?>);" onblur="calcul(<?php echo $rangee->id; ?>);" class="tarif-prix" />
                </td>
                <td>
                    <select name="gestion_devise[<?php echo $rangee->id; ?>]" class="devise-tarif">
                    	<option value="€" <?php if($rangee->devise == '€') { echo "selected=\"selected\""; } ?>><?php _e('Euro (€)' , 'gestion-tarifs'); ?></option>
                        <option value="$" <?php if($rangee->devise == '$') { echo "selected=\"selected\""; } ?>><?php _e('Dollar ($)' , 'gestion-tarifs'); ?></option>
                        <option value="£" <?php if($rangee->devise == '£') { echo "selected=\"selected\""; } ?>><?php _e('Livre Sterling (£)' , 'gestion-tarifs'); ?></option>
                        <option value="¥" <?php if($rangee->devise == '¥') { echo "selected=\"selected\""; } ?>><?php _e('Yen (¥)' , 'gestion-tarifs'); ?></option>
                        <option value="Ұ" <?php if($rangee->devise == 'Ұ') { echo "selected=\"selected\""; } ?>><?php _e('Yuan (Ұ)' , 'gestion-tarifs'); ?></option>
                    </select>
                </td>
                <td>
                    <select name="gestion_type[<?php echo $rangee->id; ?>]" class="type-tarif">
                    	<option value="" <?php if($rangee->type == '') { echo "selected=\"selected\""; } ?>><?php _e('Aucun' , 'gestion-tarifs'); ?></option>
						<option value="H.T." <?php if($rangee->type == 'H.T.') { echo "selected=\"selected\""; } ?>><?php _e('H.T.' , 'gestion-tarifs'); ?></option>
                        <option value="T.T.C." <?php if($rangee->type == 'T.T.C.') { echo "selected=\"selected\""; } ?>><?php _e('T.T.C.' , 'gestion-tarifs'); ?></option>
                        <option value="HT" <?php if($rangee->type == 'HT') { echo "selected=\"selected\""; } ?>><?php _e('HT' , 'gestion-tarifs'); ?></option>
                        <option value="TTC" <?php if($rangee->type == 'TTC') { echo "selected=\"selected\""; } ?>><?php _e('TTC' , 'gestion-tarifs'); ?></option>
                    </select>
                </td>
                <td>
                    <select name="gestion_tva[<?php echo $rangee->id; ?>]" id="gestion_tva_<?php echo $rangee->id; ?>" onchange="calcul(<?php echo $rangee->id; ?>);" class="tva">
                    	<option value="1" <?php if($rangee->tva == '1') { echo "selected=\"selected\""; } ?>><?php _e('Sans TVA' , 'gestion-tarifs'); ?></option>
                    	<option value="1.196" <?php if($rangee->tva == '1.196') { echo "selected=\"selected\""; } ?>><?php _e('TVA 19,6%' , 'gestion-tarifs'); ?></option>*
                        <option value="1.2" <?php if($rangee->tva == '1.2') { echo "selected=\"selected\""; } ?>><?php _e('TVA 20%' , 'gestion-tarifs'); ?></option>
                    	<option value="1.05" <?php if($rangee->tva == '1.05') { echo "selected=\"selected\""; } ?>><?php _e('TVA 5%' , 'gestion-tarifs'); ?></option>
                        <option value="1.055" <?php if($rangee->tva == '1.055') { echo "selected=\"selected\""; } ?>><?php _e('TVA 5,5%' , 'gestion-tarifs'); ?></option>
                        <option value="1.07" <?php if($rangee->tva == '1.07') { echo "selected=\"selected\""; } ?>><?php _e('TVA 7%' , 'gestion-tarifs'); ?></option>
                        <option value="1.1" <?php if($rangee->tva == '1.1') { echo "selected=\"selected\""; } ?>><?php _e('TVA 10%' , 'gestion-tarifs'); ?></option>
                    </select>
                </td>
                <td>
                    <input type="text" name="gestion_tariffinal[<?php echo $rangee->id; ?>]" id="gestion_tariffinal_<?php echo $rangee->id; ?>" value="<?php if($rangee->tariffinal != '') { echo $rangee->tariffinal; } ?>" onfocus="calcul(<?php echo $rangee->id; ?>);" class="tarif-definitif" />
                </td>
                <td>
                    <p id="prix-tarif">[tarif id="<?php echo $rangee->id; ?>"]</p>
                </td>
                <td>
                    <p id="intitule-tarif">[intitule id="<?php echo $rangee->id; ?>"]</p>
                </td>
                <td>
                	<input type="submit" name="action_update_gestion_tarifs" class="button-primary" value="<?php _e('Mettre à jour' , 'gestion-tarifs'); ?>" onmouseover="calcul(<?php echo $rangee->id; ?>);" id="bouton-update" />
                </td>
                <td>
                    <input type="submit" name="action_delete_gestion_tarifs_[<?php echo $rangee->id; ?>]" class="button" value="<?php _e('Supprimer' , 'gestion-tarifs'); ?>" onmouseover="calcul(<?php echo $rangee->id; ?>);" id="bouton-delete" />
                </td>
            </tr>
<?php
	}
?>
    </tbody>
    </table>
        <p><input type="submit" name="add_gestion_tarifs" class="button-primary" value="<?php _e('Ajouter un tarif' , 'gestion-tarifs'); ?>" /></p>
        <p class="submit"><input type="submit" name="action_gestion_tarifs" class="button-primary" value="<?php _e('Enregistrer' , 'gestion-tarifs'); ?>" /></p>
    </form>
<?php
}
?>