<?php
/*
Plugin Name: Gestion de tarifs
Plugin URI: http://wordpress.org/extend/plugins/gestion-tarifs/
Description: <strong>Gestion de tarifs</strong> permet d'ajouter ou de supprimer des tarifs que vous souhaitez inclure dans des articles ou des pages Wordpress. &Agrave; chaque tarif cr&eacute;&eacute; correspond un tag qui s'ajoute facilement dans l'interface des pages ou des articles. <strong>Gestion de tarifs</strong> permet de g&eacute;rer tous vos prix de sites de pr&eacute;sentation &agrave; partir d'une seule et m&ecirc;me interface et avec un enregistrement dans une base de donn&eacute;es.
Author: Mathieu Chartier
Version: 1.4
Author URI: http://www.evigeo.com
*/
global $wpdb, $table_gt;
$table_gt = $wpdb->prefix.'gestion_tarif';

// Version du plugin
$gestion_tarifs_version = "1.4";

function gestion_tarifs_languages() {
   $path = dirname(plugin_basename(__FILE__)).'/lang/';
   load_plugin_textdomain('gestion-tarifs', false, $path);
}
add_action('plugins_loaded', 'gestion_tarifs_languages');

// Fonction lancée lors de l'activation ou de la desactivation de l'extension
register_activation_hook( __FILE__, 'gestion_tarifs_install' );
register_deactivation_hook( __FILE__, 'gestion_tarifs_desinstall' );

// Afficher le bouton Gestion tarifs dans le backoffice
add_action('admin_menu', 'gestion_tarifs_admin');
function gestion_tarifs_admin() {
	$page_title		= 'Gestion de tarifs';	// Titre interne à la page de réglages
	$menu_title		= __('Ajout de tarifs' , 'gestion-tarifs');	// Titre du sous-menu
	$capability		= 'manage_options'; // Rôle d'administration qui a accès au sous-menu
	$menu_slug		= 'gestion_tarifs';	// Alias (slug) de la page
	$function		= 'gestion_tarifs_admin_affichage';	// Fonction appelée pour afficher la page de réglages
	$function2		= 'gestion_tarifs_admin_configuration'; // Fonction appelée pour afficher la page de gestion des styles
	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, plugin_dir_url( __FILE__ ).'icon.png', 32);
	add_submenu_page($menu_slug, __('Configuration','wp-advanced-search'), __('Configuration','wp-advanced-search'), $capability, $function2, $function2);
}

// Installation de la table dès l'activation de l'extension
function gestion_tarifs_install() {
	global $wpdb, $table_gt;

	// Création de la table de base
	$sql = "CREATE TABLE $table_gt (
		id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		titre VARCHAR( 255 ) NOT NULL, 
		tarif VARCHAR( 10 ) NOT NULL,
		devise VARCHAR( 10 ) NOT NULL,
		type VARCHAR( 10 ) NOT NULL,
		tva VARCHAR( 10 ) NOT NULL,
		tariffinal VARCHAR( 10 ) NOT NULL		
	);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	
	// Insertion de valeurs par défaut (premier enregistrement)
	$defaut_titre = "Tarif test";
	$defaut_tarif = "0";
	$defaut_devise = "€";
	$defaut_type = "";
	$defaut_tva = "1";
	$defaut_tariffinal = "0";
	$initial = $wpdb->insert($table_gt, array('titre' => $defaut_titre, 'tarif' => $defaut_tarif, 'devise' => $defaut_devise, 'type' => $defaut_type, 'tva' => $defaut_tva, 'tariffinal' => $defaut_tariffinal));

	// Ajout des options de configuration par défaut
	add_option("gestion_tarifs_position", true);
	add_option("gestion_tarifs_space", false);
	
	// Prise en compte de la version en cours
	add_option("gestion_tarifs_version", $gestion_tarifs_version);
}
// Action lors de la desinstallation de l'extension
function gestion_tarifs_desinstall() {
	global $wpdb, $table_gt;
	// Suppression de la table de base
	$wpdb->query("DROP TABLE IF EXISTS $table_gt");
	
	// Suppression des options de configuration
	delete_option("gestion_tarifs_position");
	delete_option("gestion_tarifs_space");
}
// Quand le plugin est mise à jour, on relance la fonction
function gestion_tarifs_upgrade() {
    global $gestion_tarifs_version;
	
	// Si c'est la première fois que la configuration est prise en compte
	if(get_site_option("gestion_tarifs_version") == false) {
		add_option("gestion_tarifs_version", "1");
	}

    if(get_site_option('gestion_tarifs_version') != $gestion_tarifs_version) {
        gestion_tarifs_version_update();
    }
}
add_action('plugins_loaded', 'gestion_tarifs_upgrade');

// Fonction d'update
function gestion_tarifs_version_update() {
	global $wpdb, $table_gt, $gestion_tarifs_version;

	// Récupération de la version en cours (pour voir si mise à jour...)
	$installed_ver = get_option("gestion_tarifs_version");
	
	// Mise à jour des données
	if($installed_ver != $gestion_tarifs_version) {		
		if(get_site_option('gestion_tarifs_position') == false) {
			add_option("gestion_tarifs_position", true);
		}
		if(get_site_option('gestion_tarifs_space') == false) {
			add_option("gestion_tarifs_space", false);
		}

		// Mise à jour de la version
		update_option("gestion_tarifs_version", $gestion_tarifs_version);
	}
}

// Ajout d'une feuille de style pour l'admin
function gestion_tarifs_CSS() {
	$handle = 'admin_css';
	$style	= plugins_url('gestion-tarifs.css', __FILE__);
	wp_enqueue_style($handle, $style, 15);
}
add_action('admin_print_styles', 'gestion_tarifs_CSS');

// Inclusion de la fonction générale (liste des tarifs)
include('gestion-tarifs-form.php');

// Inclusion de la page de configuration générale
include('gestion-tarifs-configuration.php');

// Inclusion des shortcodes
include('gestion-tarifs-shortcodes.php');