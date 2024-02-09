<?php

/**
 * Plugin Name: Plugin Exam
 * Description: vente de billets pour 
 *                évènements avec champs personnalité à ajouter 
 * Version 1.0
 * Author: Aurélie
 */


//  si  le chemin est défini on prend en compte le plugin, sinon on le rejète

if (!defined('ABSPATH')) {
    exit;
}



// Vérification de l'activation des plugins


if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    echo 'Woo Commerce est activé <br>';
} else {
    echo 'Woo Commerce n\'est activé<br>';
    echo '<a href="http://localhost/pluginExam/wp-admin/plugins.php" style="text-align:center">Retour à l\'activation de l\'extension</a>';
}
if (in_array('advanced-custom-fields/acf.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    echo 'ACF est activé';
} else {
    echo 'ACF n\'est activé<br>';
    echo '<a href="http://localhost/pluginExam/wp-admin/plugins.php" style="text-align:center">Retour à l\'activation de l\'extension</a>';
}




// 1_ Créer les champs date, heure, description et info privé
// Action acf avec init
add_action('acf/init', 'my_acf_init');

// création des champs dans la partie woo commerce
function my_acf_init()
{
    if (function_exists('acf_add_local_field_group')) : //acf_add_local_field_group: ajoute un groupe de champs
        acf_add_local_field_group(array(
            'key' => 'group_1',
            'title' => 'Détail de l\'évènement',
            'fields' => array(
                array(
                    'key' => 'field_1',
                    'label' => 'Date de l\'évènement',
                    'name' => 'event_date',
                    'type' => 'date_picker',
                    'return_format' => 'D j F y',
                ),
                array(
                    'key' => 'field_2',
                    'label' => 'Heure de l\'évènement',
                    'name' => 'event_heure',
                    'type' => 'time_picker',
                    'return_format' => 'H:i',
                ),
                array(
                    'key' => 'field_3',
                    'label' => 'Description de l\'évènement',
                    'name' => 'event_desc',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_4',
                    'label' => 'Informations privées',
                    'name' => 'event_info',
                    'type' => 'text',
                ),
            ),
            // acf permet de choisir où sera mis les champs (d'où location)
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
        ));

    endif;
};



// 2_ Création du shortcode permet l'affichage des champs précédemment ajoutés
// je veux ajouter une action dans init avec le nom detail_init_shortcode

add_action('init', 'detail_init_shortcode');

// fonction qui va ajouter un shortcode
function detail_init_shortcode()
{
    add_shortcode('text', 'detail_do_shortcode');
}


// fonction qui va générer ce que fait le shortcode
function detail_do_shortcode()
{
    $detailSupp =
        '<h5 ">Informations supplémentaires</h5>
                <div>
                    <p>Le ballet aura lieu le ' . get_field('event_date') . ' à ' . get_field('event_heure') . '</p>
                    <p>' . get_field('event_desc') . '</p>
                </div>
                <div id="compte_a_rebours" style="border-block-end:solid; border-left:solid;padding:10px 0px; text-align:center; "> </div>
                <div style="margin-top:15px;font-size:15px">
                    Info Privée: <a href="https://casino-royat.partouche.com/" target="_blank" style="font-style:italic;">' . get_field('event_info') . '</a>
                </div>';

    return $detailSupp;
}



// 3_ Ajout d'un fichier CSS 
// Ajouter fichier css
add_action('wp_enqueue_scripts', 'Plugin_FrontBack_enqueue_styles');

function Plugin_FrontBack_enqueue_styles()
{
    wp_enqueue_style('style', plugins_url('style.css', __FILE__));
}


// // 4_ Ajout d'un fichier script avec un timer
// // Ajouter fichier scripts avec timer


add_action('wp_enqueue_scripts', 'Plugin_FrontBack_enqueue_scripts');

function Plugin_FrontBack_enqueue_scripts()
{
    wp_enqueue_script('script', plugins_url('timer.js', __FILE__), array('jquery'), '', true);
}
