<?php
// Création des shortcodes pour chaque tarif
function gestion_shortcode_tarif($atts) {
	global $wpdb, $table_gt;
		
	extract(shortcode_atts(array(
		'id' => 1,
	), $atts));

	$rows_id = $wpdb->get_results("SELECT * FROM $table_gt WHERE id = {$id}");	
	$tariftotal = '';
	foreach($rows_id as $row) {
		// Gestion de l'espace
		if(get_option("gestion_tarifs_space") == false) {
			$space = '';
		} else {
			$space = ' ';
		}
		// Gestion de l'ordre d'affichage
		if(get_option("gestion_tarifs_position") == false) {
			$tariftotal.= $row->devise.$space.$row->tariffinal;
		} else {
			$tariftotal.= $row->tariffinal.$space.$row->devise;
		}
		// Gestion du type
		if(!empty($row->type)) {
			$tariftotal.= ' '.$row->type;
		}
		
		return $tariftotal;
	}
}
add_shortcode("tarif","gestion_shortcode_tarif");

// Création des shortcodes pour chaque intitulé
function gestion_shortcode_intitule($atts) {
	global $wpdb, $table_gt;
		
	extract(shortcode_atts(array(
		'id' => 1,
	), $atts));

	$rows_id = $wpdb->get_results("SELECT * FROM $table_gt WHERE id = {$id}");	
	foreach ($rows_id as $row) {
		$intitule = $row->titre;
		return $intitule;
	}
}
add_shortcode("intitule","gestion_shortcode_intitule");
?>