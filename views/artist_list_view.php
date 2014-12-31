<?
/*
 * Custom view for artist list.
 * Call: levylista_artist_list_view($artist)
 *
 * Part of Levylista plugin.
 */
 
 ?>
 
 <table>
    <th><a href="?orderby=">Artisti</a></th><th><a href="?orderby=albumcount" title="Järjestä levyjen määrän perusteella">Levyjä</a></th>
  <? foreach($artists as $artist) { ?>
    <tr>
        <td><a href="<? levylista_the_artist_url($artist['name']) ?>"><? echo $artist['name'] ?></td>
        <td><? echo $artist['albums'] ?></td>
    </tr>
  <? } //end foreach ?>
 </table>