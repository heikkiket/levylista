<?
/*
 * Single entry view for Levylista plugin.
 * Call: levylista_single_view() 
 * Must be called inside the loop in order to work.
 */
?>
            <header class="page-content levylista-single-header">
            <h2><a href="<? levylista_the_artist_url() ?>"><? levylista_the_artist() ?>:</a></h2>
            <h1><? the_title() ?></h1>
            </header>
            
            <dl class="page-content levylista-data">
                <dt>Julkaisuvuosi</dt><dd><a href="<? levylista_the_year_url() ?>"><? levylista_the_year() ?></dd>
                <dt>Tyyppi</dt><dd><? levylista_the_format() ?></dd>
                <dt>Julkaisija</dt><dd><? levylista_the_publisher() ?></dd>
                <dt>Kataloginumero</dt><dd><? levylista_the_catalogue_number() ?></dd>
                <? if(levylista_get_the_comment() != ""){ ?>
                    <dt>Kommentti</dt>
                    <dd><blockquote class="levylista-comment"><? levylista_the_comment() ?></blockquote></dd>
                <? } ?>
            </dl>