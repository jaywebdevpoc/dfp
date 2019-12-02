<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\bestpratices\views\best-pratice\help
 * @category   CategoryName
 */

use lispa\amos\organizzazioni\Module;

$label = Module::t('amosorganizzazioni', '#organizzazioni_dashoard_description');

if(!empty($label)) : ?>
    <div class="dashoard-description">
        <?= $label ?>
    </div>
<?php endif; ?>
