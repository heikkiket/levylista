<?
/* 
 * Template tags to get views and data
 */
 
 function levylista_single_view($echo=true) {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'single_view.php';
    $returned = ob_get_contents();
    ob_end_clean();
    if($echo)
        echo $returned;
    else
        return $returned;
}

function levylista_artist_view($query, $echo=true) {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'artist_view.php';
    $returned = ob_get_contents();
    ob_end_clean();
    if($echo)
        echo $returned;
    else
        return $returned;
}

function levylista_table_view($query, $echo=true) {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'table_view.php';
    $returned = ob_get_contents();
    ob_end_clean();
    if($echo)
        echo $returned;
    else
        return $returned;
}

function levylista_artist_list_view($artists, $echo=true) {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'artist_list_view.php';
    $returned = ob_get_contents();
    ob_end_clean();
    if($echo)
        echo $returned;
    else
        return $returned;
}

function levylista_stats_view($counted, $how_many_albums, $how_many_artists, $echo=true) {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'stats_view.php';    
    $returned = ob_get_contents();
    ob_end_clean();
    if($echo)
        echo $returned;
    else
        return $returned;
}

/*template tags*/

function levylista_get_the_artist() {
    $post = get_post();
    $levylista_artist = get_post_meta( $post->ID, 'levylista_artist', true);
    return $levylista_artist;
}
function levylista_the_artist() {
    echo levylista_get_the_artist();
}
function levylista_the_artist_url($artist=NULL) {
    if($artist==NULL) {
        $artist = levylista_get_the_artist();
    }
    echo site_url() . '/esittajat/?esittajat=' . urlencode($artist);
}
function levylista_the_year() {
    echo levylista_get_the_year();
}
function levylista_get_the_year() {
    $post = get_post();
    $levylista_year = get_post_meta( $post->ID, 'levylista_year', true);
    return $levylista_year;
}
function levylista_the_year_url($year=NULL) {
    if($year==NULL) {
        $year = levylista_get_the_year();
    }
    echo levylista_get_the_year_url($year);
}
function levylista_get_the_year_url($year=NULL) {
    if($year==NULL) {
        $year = levylista_get_the_year();
    }
    return site_url() . '/vuodet/?vuodet=' . urlencode($year);
}

function levylista_the_publisher() {
    $post = get_post();
    $levylista_publisher = get_post_meta( $post->ID, 'levylista_publisher', true);
    echo $levylista_publisher;
}
function levylista_the_catalogue_number() {
    $post = get_post();
    $levylista_catalogue_number = get_post_meta( $post->ID, 'levylista_catalogue_number', true);
    echo $levylista_catalogue_number;
}
function levylista_the_comment() {
    echo levylista_get_the_comment();
}
function levylista_get_the_comment() {
    $post = get_post();
    $levylista_comment = get_post_meta( $post->ID, 'levylista_comment', true);
    return $levylista_comment;
}
function levylista_the_format() {
    echo levylista_get_the_format();
}
function levylista_get_the_format() {
    global $levylista_formats;
    $post = get_post();
    $levylista_format = get_post_meta( $post->ID, 'levylista_format', true);
    return $levylista_formats[$levylista_format];
}


?>