<?php
// Modification d'une ligne de tarif
function gestion_tarif_modifConfig() {
	global $wpdb; // insérer les variables globales

	$gt_position = $_POST['gt_position'];
	$gt_space = $_POST['gt_space'];

	update_option("gestion_tarifs_position", $gt_position);
	update_option("gestion_tarifs_space", $gt_space);
}

// Afficher la page d'options dans le backoffice
function gestion_tarifs_admin_configuration() {
	global $wpdb; // insérer les variables globales
	
	// Déclencher la fonction de modification
	if(isset($_POST['config_gestion_tarifs']) && $_POST['config_gestion_tarifs'] == __('Enregistrer', 'gestion-tarifs')) {
		gestion_tarif_modifConfig();
	}
?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2><?php _e('Configuration', 'gestion-tarifs'); ?></h2>
        <br />
        <?php _e('Paramétrez l\'affichage des tarifs comme bon vous semble.', 'gestion-tarifs'); ?><br/>
        <?php _e('Allez ensuite dans la section d\'ajout de tarifs pour bénéficier des réglages effectués.', 'gestion-tarifs'); ?><br/><br/>
    </div>
	<form name="form_gestion_tarifs" id="form2" method="post" action="">
    <table class="widefat">
		<tbody class="sortableTable">
            <tr>
                <td class="config1">
                    <select name="gt_position" />
						<option value="0" <?php if(get_option("gestion_tarifs_position") == false) { echo 'selected="selected"'; } ?>><?php _e('Avant le tarif', 'gestion-tarifs'); ?></option>
						<option value="1" <?php if(get_option("gestion_tarifs_position") == true) { echo 'selected="selected"'; } ?>><?php _e('Après le tarif', 'gestion-tarifs'); ?></option>
					</select>
                </td>
                <td class="config2">
                    <label>Position de la devise</label>
                </td>
            </tr>
            <tr>
                <td class="config1">
                    <select name="gt_space" />
						<option value="0" <?php if(get_option("gestion_tarifs_space") == false) { echo 'selected="selected"'; } ?>><?php _e('Non', 'gestion-tarifs'); ?></option>
						<option value="1" <?php if(get_option("gestion_tarifs_space") == true) { echo 'selected="selected"'; } ?>><?php _e('Oui', 'gestion-tarifs'); ?></option>
					</select>
                </td>
                <td class="config2">
                    <label>Ajouter un espace entre la devise et le tarif ?</label>
                </td>
            </tr>
		</tbody>
    </table>
		<p><input type="submit" name="config_gestion_tarifs" class="button-primary" value="<?php _e('Enregistrer', 'gestion-tarifs'); ?>" /></p>
    </form>
<?php
}
?>