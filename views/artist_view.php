<?
/*
 * Artist view for Levylista plugin
 * call levylista_artist_view() to get this.
 */
 
echo '<h2>' . $artist . '</h2>';
if(isset($query)) {
    levylista_table_view($query);
} else {
    levylista_table_view();
    }

?>