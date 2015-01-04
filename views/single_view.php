<?php
/*
 * Single entry view for Levylista plugin.
 * Call: levylista_single_view() 
 * Must be called inside the loop in order to work.
 */
?>
            <h2><a href="<?php levylista_the_artist_url() ?>"><?php levylista_the_artist() ?>:</a></h2>
            <h1><?php the_title() ?></h1>
            
            <dl class="levylista-data">
                <dt><?php _e('Julkaisuvuosi', 'levylista') ?></dt>
                    <dd><a href="<?php levylista_the_year_url() ?>"><?php levylista_the_year() ?></a></dd>
                <dt><?php _e('Tyyppi', 'levylista') ?></dt>
                    <dd><?php levylista_the_format() ?></dd>
                <dt><?php _e('Julkaisija', 'levylista') ?></dt>
                    <dd><?php levylista_the_publisher() ?></dd>
                <dt><?php _e('Kataloginumero', 'levylista') ?></dt>
                    <dd><?php levylista_the_catalogue_number() ?></dd>
                <?php if(levylista_get_the_comment() != ""){ ?>
                    <dt><?php _e('Kommentti', 'levylista') ?></dt>
                    <dd><blockquote class="levylista-comment"><?php levylista_the_comment() ?></blockquote></dd>
                <?php } ?>
            </dl>