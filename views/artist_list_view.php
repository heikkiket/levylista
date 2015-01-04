<?php
/*
 * Custom view for artist list.
 * Call: levylista_artist_list_view($artist)
 *
 * Part of Levylista plugin.
 */
 
 ?>
 
 <table>
    <th><a href="?orderby="><?php _e('Artisti', 'levylista') ?></a></th>
    <th><a href="?orderby=albumcount" title="<?php _e('Järjestä levyjen määrän perusteella', 'levylista') ?>">
    <?php _e('Levyjä', 'levylista') ?></a></th>
  <?php foreach($artists as $artist) { ?>
    <tr>
        <td><a href="<?php levylista_the_artist_url($artist['name']) ?>"><?php echo $artist['name'] ?></td>
        <td><?php echo $artist['albums'] ?></td>
    </tr>
  <?php } //end foreach ?>
 </table>