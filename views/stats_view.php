<?
/*
 * Stats view for Levylista plugin
 * Call: levylista_stats_view($counted, $how_many_albums, $how_many_artists)
 */
 ?>
 
<p><a href="<? echo site_url() ?>/levyt/">Levyjä: <? echo $how_many_albums ?></a></p>
<p><a href="<? echo site_url() ?>/esittajat/">Eri esittäjiä: <? echo $how_many_artists ?></a></p>
<h3>Formaatit</h3>
<ul class="levylista-stats">
<? foreach($counted['formats'] as $format => $amount) {
    echo '<li>' . $format . ' : ' . $amount . '</li>';
} ?>
</ul>
<h3>Vuodet</h3>
<ul class="levylista-stats">
<? foreach($counted['years'] as $year => $amount) {
    echo '<li><a href="' . levylista_the_year_url($year) . '">' . $year . ' : ' . $amount . '</a></li>';
} ?>
</ul>