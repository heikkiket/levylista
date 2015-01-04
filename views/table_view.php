<?php
/*
 * Artist table view for Levylista plugin.
 * Call for levylista_table_view($query) to get this view
 */


if(!isset($query)) global $query;
?>

<table class="levylista">
<th><?php _e('Esittäjä', 'levylista') ?></th>
<th><?php _e('Albumi', 'levylista') ?></th>
<th><?php _e('Julkaisuvuosi', 'levylista') ?></th>
<th><?php _e('Lisätty listaan', 'levylista') ?></th>
<?php 
while ( $query->have_posts() ) {
    $query->the_post();
    $levydata = get_post_custom();
    ?>
    <tr>
        <td><a href="<?levylista_the_artist_url() ?>"><?php levylista_the_artist() ?></a></td>
        <td><a href="<?php the_permalink() ?>"><?php the_title()?></a></td>
        <td><a href="<?php levylista_the_year_url() ?>"><?php levylista_the_year() ?></a></td>
        <td><?php the_time('d.m.Y') ?></td>
    </tr>

<?php } ?>
</table>