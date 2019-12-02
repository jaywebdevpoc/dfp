<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\views\projects\email
 * @category   CategoryName
 */

use lispa\amos\projectmanagement\Module;
/** @var string $text */
/** @var \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model */
?>
<?php $title_project = $model->projects->name;?>
<?= Module::t('amosproject_management', $text,[
    'title_project' => $title_project
])  ?>
