<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\partnership-profiles\help
 * @category   CategoryName
 */

use lispa\amos\community\AmosCommunity;

$description = AmosCommunity::t('amoscommunity', '#create_community_dashboard_description');
?>

<?php if(!empty($description)): ?>
    <div class="dashboard-description">
        <?= $description ?>
    </div>
<?php endif; ?>