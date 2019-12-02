<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\expressions-of-interest\help
 * @category   CategoryName
 */

use lispa\amos\partnershipprofiles\Module;

$label = Module::t('amospartnershipprofiles', '#all_expressions_of_interest_help');

if(!empty($label)) : ?>
    <div class="m-t-10 italic">
        <?= $label ?>
    </div>
<?php endif; ?>
