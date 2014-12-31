<?
/*
 * Artist table view for Levylista plugin.
 * Call for levylista_table_view($query) to get this view
 */


if(!isset($query)) global $query;
?>

<table class="levylista">
<th>Esittäjä</th><th>Albumi</th><th>Julkaisuvuosi</th><th>Lisätty listaan</th>
<? 
while ( $query->have_posts() ) {
    $query->the_post();
    $levydata = get_post_custom();
    ?>
    <tr>
        <td><a href="<?levylista_the_artist_url() ?>"><? levylista_the_artist() ?></a></td>
        <td><a href="<? the_permalink() ?>"><? the_title()?></a></td>
        <td><? levylista_the_year() ?></td>
        <td><? the_time('d.m.Y') ?></td>
    </tr>

<? } ?>
<table>