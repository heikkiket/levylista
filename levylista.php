<?php
/**
 * Plugin Name: Heikin levylista
 * Plugin URI: http://heikkiket.kapsi.fi
 * Description: Heikin upea levykatalooki
 * Version: 1.0
 * Author: Heikki Ketoharju
 * Author URI: http://heikki.ketoharju.info
 * License: GPL3
 */

defined('ABSPATH') or die("No script kiddies please!");


$levylista_formats = array(
        'none' => '--',
        'cd' => 'CD',
        '2cd'=> '2CD',
        '3cd'=> '3CD',
        '4cd'=> '4CD',
        '5cd'=> '5CD',
        '6cd'=> '6CD',
        'cdep' => 'CDEP',
        'cds'=> 'CDS',
        'sacd' => 'SACD',
        'lp' => 'LP',
        '3lp'=> '3LP',
        '4lp'=> '4LP',
        '2lp'=> '2LP',
        '5lp'=> '5LP',
        '6lp'=> '6LP',
        '7i;'=> '7"',
        'blu-ray'=> 'Blu-ray',
        'blu-ray+' => 'Blu-ray+',
        'dualdisc' => 'DualDisc',
        'dvd'=> 'DVD',
        '2dvd' => '2DVD',
        '3dvd' => '3DVD',
        '4dvd' => '4DVD',
        'cd+dvd' => 'CD+DVD',
        '2cd+dvd'=> '2CD+DVD',
        'hdcd' => 'HDCD',
        'mc' => 'MC',
        'vhs' => 'VHS',
        '10i;' => '10"',
        '12i;' => '12"',
        'muu'=> 'Muu',
);


/*
 * Execute during install
 */
 
function levylista_activate() {
    levylista_create_post_type();
    flush_rewrite_rules();
    levylista_init_rewrites();

}
register_activation_hook( __FILE__, 'levylista_activate' );

/*
 * Execute every time Wordpress starts
 */

function levylista_create_post_type() {

    $labels = array(
        'name'               => _x( 'Levyt', 'post type general name', 'levylista-textdomain' ),
        'singular_name'      => _x( 'Levy', 'post type singular name', 'levylista-textdomain' ),
        'menu_name'          => _x( 'Levyt', 'admin menu', 'levylista-textdomain' ),
        'name_admin_bar'     => _x( 'Levy', 'add new on admin bar', 'levylista-textdomain' ),
        'add_new'            => _x( 'Lisää uusi', 'book', 'levylista-textdomain' ),
        'add_new_item'       => __( 'Lisää uusi levy', 'levylista-textdomain' ),
        'new_item'           => __( 'Uusi levy', 'levylista-textdomain' ),
        'edit_item'          => __( 'Muokkaa levyä', 'levylista-textdomain' ),
        'view_item'          => __( 'Näytä levy', 'levylista-textdomain' ),
        'all_items'          => __( 'Kaikki levyt', 'levylista-textdomain' ),
        'search_items'       => __( 'Etsi levyjä', 'levylista-textdomain' ),
        'not_found'          => __( 'Levyjä ei löytynyt.', 'levylista-textdomain' ),
        'not_found_in_trash' => __( 'Ei levyjä roskakorissa.', 'levylista-textdomain' )
    );

  register_post_type( 'levylista_levy',
    array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'supports' => array(
        'title',
        'author',
        'thumbnail',
      ),
      'menu-icon' => 'dashicons-album',
      'rewrite' => array("slug" => "levyt")
    )
  );
}
add_action( 'init', 'levylista_create_post_type' );

/*
 * Views and template tags
 */

 include plugin_dir_path(__FILE__) . 'views/template_tags.php';

/*
 * Init shortcodes and rewrites
 */

function levylista_init_shortcodes() {
    add_shortcode( 'artists', 'levylista_artists_shortcode' );
    add_shortcode( 'statistics', 'levylista_statistics_shortcode' );
    add_shortcode( 'years', 'levylista_years_shortcode' );
}
add_action( 'init', 'levylista_init_shortcodes' );

function levylista_init_rewrites() {
    add_rewrite_endpoint( "esittajat", EP_PERMALINK | EP_PAGES );
    add_rewrite_endpoint( "vuodet", EP_PERMALINK | EP_PAGES );
}
add_action( 'init', 'levylista_init_rewrites');


/*
 * Columns 
 */

function change_columns( $cols ) {
    $cols = array(
        'cb'        => '<input type="checkbox" />',
        'title'     => __( 'Levyn nimi', 'levylista-textdomain'),
        'levylista_artist'    => __( 'Artisti', 'levylista-textdomain'),
        'levylista_year'      => __( 'Julkaisuvuosi', 'levylista-textdomain'),
        'levylista_format'    => __( 'Tyyppi', 'levylista-textdomain')
        );
        return $cols;
}
add_filter ('manage_levylista_levy_posts_columns', 'change_columns');

function custom_columns( $column, $post_id ){
    switch( $column ) {
        case "levylista_artist":
            $levylista_artist = get_post_meta( $post_id, 'levylista_artist', true);
            echo '<a href="' . $levylista_artist . '">' . $levylista_artist . '</a>';
            break;
        case "levylista_year":
            $levylista_year = get_post_meta( $post_id, 'levylista_year', true);
            echo '<a href="' . $levylista_year . '">' . $levylista_year . '</a>';
            break;
        case "levylista_format":
            $levylista_format = get_post_meta( $post_id, 'levylista_format', true);
            echo '<a href="' . $levylista_format . '">' . $levylista_format . '</a>';
            break;
    }
}
add_action( "manage_posts_custom_column", "custom_columns", 10, 2 );

function sortable_columns() {
    return array(
      'levylista_artist'      => 'levylista_artist',
      'levylista_year' => 'levylista_year',
    );
  }
add_filter( "manage_edit-levylista_levy_sortable_columns", "sortable_columns" );


/*
 * Add taxonomy dropdown to admin side
 */

// Filter the request to just give posts for the given taxonomy, if applicable.
// function taxonomy_filter_restrict_manage_posts() {
//     global $typenow;
// 
//     $post_types = get_post_types( array( '_builtin' => false ) );
// 
//     if ( in_array( $typenow, $post_types ) ) {
//     $filters = get_object_taxonomies( $typenow );
// 
//         foreach ( $filters as $tax_slug ) {
//             $tax_obj = get_taxonomy( $tax_slug );
//             wp_dropdown_categories( array(
//                 'show_option_all' => __('Show All '.$tax_obj->label ),
//                 'taxonomy'    => $tax_slug,
//                 'name'      => $tax_obj->name,
//                 'orderby'     => 'name',
//                 'selected'    => $_GET[$tax_slug],
//                 'hierarchical'    => $tax_obj->hierarchical,
//                 'show_count'    => false,
//                 'hide_empty'    => true
//             ) );
//         }
//     }
// }
// add_action( 'restrict_manage_posts', 'taxonomy_filter_restrict_manage_posts' );
// 
// 
// function taxonomy_filter_post_type_request( $query ) {
// global $pagenow, $typenow;
// 
// if ( 'edit.php' == $pagenow ) {
//     $filters = get_object_taxonomies( $typenow );
//     foreach ( $filters as $tax_slug ) {
//     $var = &$query->query_vars[$tax_slug];
//     if ( isset( $var ) ) {
//         $term = get_term_by( 'id', $var, $tax_slug );
//         $var = $term->slug;
//     }
//     }
// }
// }
// add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );
  
  
  
/**
 * Add meta boxes
 */

add_action( 'add_meta_boxes', 'levylista_meta_boxes' );
function levylista_meta_boxes() {
    add_meta_box('levylista-meta-basic-info', "Levyn perustiedot", "levylista_meta_basic_info",
        "levylista_levy", "advanced", "high");
//     add_meta_box("levylista-meta-lisatiedot", "Levyn lisätiedot", "levylista_meta_additional_info",
//         "levylista_levy", "side", "high");
    add_meta_box('levylista-meta-comment', "Kommentit", "levylista_meta_comment",
        "levylista_levy", "normal", "high");

}

function levylista_meta_basic_info( $post ) {

    wp_nonce_field( basename( __FILE__ ), 'levylista_nonce' );
    $levylista_stored_meta = get_post_meta( $post->ID );
    
    global $levylista_formats;

    ?>

    <fieldset>
        <label>Esittäjä: <input type="text" name="levylista_artist"
            value="<?php if ( isset ( $levylista_stored_meta['levylista_artist'] ) )
            echo $levylista_stored_meta['levylista_artist'][0]; ?>"></input></label>
        <label>Ilmestymisvuosi: <input type="text" name="levylista_year"
            value="<?php if ( isset ( $levylista_stored_meta['levylista_year'] ) )
            echo $levylista_stored_meta['levylista_year'][0]; ?>"></input></label>
    </fieldset>
    
    
    <fieldset>
        <label>Formaatti:
            <select type="normal" name="levylista_format">
            <?foreach ($levylista_formats as $id => $value) { ?>
                <option value="<? echo $id ?>" <?php if ( isset ( $levylista_stored_meta['levylista_format'] ) )
                                            selected( $levylista_stored_meta['levylista_format'][0], $id );
                                            ?>>
                <?php _e( $value, 'levylista-textdomain' )?></option><?
             } ?>
            </select>
           </label>
        <label>Julkaisija: <input type="text" name="levylista_publisher"
        value="<?php if ( isset ( $levylista_stored_meta['levylista_publisher'] ) )
        echo $levylista_stored_meta['levylista_publisher'][0]; ?>"></input></label>
        <label>Kataloginumero: <input type="text" name="levylista_catalogue_number"
        value="<?php if ( isset ( $levylista_stored_meta['levylista_catalogue_number'] ) )
        echo $levylista_stored_meta['levylista_catalogue_number'][0]; ?>"></input></label>
    </fieldset>
    <?
}

function levylista_meta_additional_info( $post ) { 

    $levylista_stored_meta = get_post_meta( $post->ID );
   
}

function levylista_meta_comment( $post ) {
    $levylista_stored_meta = get_post_meta( $post->ID );
    ?>
    <textarea name="levylista_comment" id="levylista_comment"><?php 
     if ( isset ( $levylista_stored_meta['levylista_comment'] ) )
     echo $levylista_stored_meta['levylista_comment'][0]; ?></textarea>
    <?
}

/**
 * Saves the custom meta input
 */
function levylista_meta_save( $post_id ) {
    
    $levylista_data = array(
        'levylista_artist',
        'levylista_year',
        'levylista_format',
        'levylista_publisher',
        'levylista_catalogue_number',
        'levylista_comment'
        );
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id ); 
    $is_valid_nonce = ( isset( $_POST[ 'levylista_nonce' ] ) &&
                        wp_verify_nonce( $_POST[ 'levylista_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    foreach ($levylista_data as $meta) {
        if( isset( $_POST[ $meta ] ) ) {
            update_post_meta( $post_id, $meta, sanitize_text_field( $_POST[ $meta ] ) );
        }
    }
        
 
}
add_action( 'save_post', 'levylista_meta_save' );


/*
 * Create artist listning
 */

function levylista_artists_shortcode() {
    if( isset( $_GET['esittajat'] )) {
                $artist = sanitize_text_field(urldecode($_GET['esittajat']));
                $args = array(
                    'post_type' => 'levylista_levy',
                    'nopaging' => 'true',
                    'meta_key' => 'levylista_year',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                                'key' => 'levylista_artist',
                                'value' => $artist
                            ),
                        ),
                    );
                $query = new WP_query($args);
                return levylista_artist_view($query, false);

    } else {
        $args = array(
            'post_type' => 'levylista_levy',
            'nopaging' => 'true',
            'orderby' => 'meta_value',
            'meta_key' => 'levylista_artist',
            'order' => 'ASC'
            );
        $query = new WP_query($args);
        $counted = levylista_count_albums($query);
        $artists = $counted['artists'];
        $albums = $counted['albums'];
        
        if($_GET['orderby']== 'albumcount') {
            array_multisort($albums, SORT_DESC, $artists);
        }
        
        return levylista_artist_list_view($artists, false);
    }
    
}

/*
 * Year listning
 */

function levylista_years_shortcode() {
    if( isset( $_GET['vuodet'] )) {
                $year = sanitize_text_field(urldecode($_GET['vuodet']));
                $args = array(
                    'post_type' => 'levylista_levy',
                    'nopaging' => 'true',
                    'meta_key' => 'levylista_artist',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                                'key' => 'levylista_year',
                                'value' => $year
                            ),
                        ),
                    );
                $query = new WP_query($args);
        return levylista_artist_view($query, false);

    } else {
        $args = array(
            'post_type' => 'levylista_levy',
            'nopaging' => 'true',
            'orderby' => 'meta_value_num',
            'meta_key' => 'levylista_year',
            'order' => 'ASC'
            );
        $query = new WP_query($args);
        $counted = levylista_count_albums($query);
        $years = $counted['artists'];
        $albums = $counted['albums'];
        
        if($_GET['orderby']== 'artist') {
            array_multisort($albums, SORT_DESC, $years);
        }
        
        return levylista_artist_view($years, false);
    }
    
}

/*
 * Count functions
 */

function levylista_count_albums($query) {
    $artists = array();
    $albums = array();
    $years = array();
    $formats = array();
    while($query->have_posts()) {
        $query->the_post();
        $artist = levylista_get_the_artist();
        $format = levylista_get_the_format();
        $year = levylista_get_the_year();

        if(!array_key_exists($artist, $artists)) {
            $artists[$artist]['name'] = $artist;
            $artists[$artist]['albums'] = 1;
            $albums[$artist] = 1;
        } else {
            $artists[$artist]['albums']++;
            $albums[$artist]++;
        }
        
        $formats[$format]++;
        $years[$year]++;
    }
        
    arsort($years);
    arsort($formats);
        
    return array ( 'artists' => $artists, 'albums' => $albums, 'years' => $years, 'formats' => $formats);
}


/*
 *Create statistics
 */

function levylista_statistics_shortcode() {
    $args = array(
        'post_type' => 'levylista_levy',
        'nopaging' => 'true',
        'orderby' => 'meta_value',
        'meta_key' => 'levylista_artist',
        'order' => 'ASC'
        );
    $query = new WP_query($args);
    $counted = levylista_count_albums($query);
    
    $how_many_albums = wp_count_posts('levylista_levy')->publish;
    $how_many_artists = count($counted['artists']);
        
    return levylista_stats_view($counted, $how_many_albums, $how_many_artists);

}
/*
 * Customize search
 */

function levylista_custom_search_where($pieces) {
 
    // filter to select search query
    if (is_search() && !is_admin()) {
 
        global $wpdb;
        $custom_fields = array('levylista_artist','levylista_publisher', 'levylista_comment');
        $keywords = explode(' ', get_query_var('s'));
        $query = "";
        foreach ($custom_fields as $field) {
             foreach ($keywords as $word) {
                 $query .= "((mypm1.meta_key = '".$field."')";
                 $query .= " AND (mypm1.meta_value  LIKE '%{$word}%')) OR ";
             }
        }
 
        if (!empty($query)) {
            // add to where clause
            $pieces['where'] = str_replace("(((" . $wpdb->prefix . "posts.post_title LIKE '%", "( {$query} (( " . $wpdb->prefix . "posts.post_title LIKE '%", $pieces['where']);
 
            $pieces['join'] = $pieces['join'] . " INNER JOIN {$wpdb->postmeta} AS mypm1 ON ({$wpdb->posts}.ID = mypm1.post_id)";
        }
    }
    return ($pieces);
}
add_filter('posts_clauses', 'levylista_custom_search_where', 20, 1);


/**
 * Enqueue plugin style-files
 */

function levylista_custom_style() {
    wp_enqueue_style(plugin_dir_path( __FILE__ ) . 'css/style.css');
}
add_action( 'wp_head', 'levylista_custom_style' );

function levylista_admin_style() {
    wp_enqueue_style(plugin_dir_path( __FILE__ ) . 'css/admin.css');

}
add_action( 'wp_head', 'levylista_admin_style' );

?>