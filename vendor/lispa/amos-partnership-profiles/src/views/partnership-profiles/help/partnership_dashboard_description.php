<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\partnership-profiles\help
 * @category   CategoryName
 */

use lispa\amos\partnershipprofiles\Module;

$description = Module::t('amospartnershipprofiles', '#partnership_profiles_dashboard_description');
?>

<?php if(!empty($description)): ?>
    <div class="dashboard-description">
        <?= $description ?>
    </div>
<?php endif; ?>

