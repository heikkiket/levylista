<?php
/*
 * Stats view for Levylista plugin
 * Call: levylista_stats_view($counted, $how_many_albums, $how_many_artists)
 */
 
// Let's get the artist_slug variable if it isn't set
if(!isset($levylista_artist_slug)) global $levylista_artist_slug; 
?>
 
<p><a href="<?php echo site_url() ?>/levyt"><?php _e('Levyjä:', 'levylista') ?> <?php echo $how_many_albums ?></a></p>
<p><a href="
<?php echo site_url() . '/' . $levylista_artist_slug ?>"><?php _e('Eri esittäjiä:', 'levylista'); echo $how_many_artists; ?>
</a></p>
<h3><?php _e('Formaatit', 'levylista') ?></h3>
<ul class="levylista-stats">
<?php foreach($counted['formats'] as $format => $amount) {
    echo '<li>' . $format . ' : ' . $amount . '</li>';
} ?>
</ul>
<h3><?php _e('Vuodet', 'levylista') ?></h3>
<ul class="levylista-stats">
<?php foreach($counted['years'] as $year => $amount) {
    echo '<li><a href="' . levylista_get_the_year_url($year) . '">' . $year . ' : ' . $amount . '</a></li>';
} ?>
</ul>