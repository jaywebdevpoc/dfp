<?php

use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * Personalizzare a piacimento la vista
 * $model è il model legato alla tabella del db
 * $buttons sono i tasti del template standard {view}{update}{delete}
 */
?>

<div class="card-container">
    <div class="icon-body">
        <div class="container-title"><h3><a href="#"><?= $model ?></a></h3></div>
        <?php if ($model->getTestoIcon()): ?>
            <p><?= $model->getTestoIcon() ?></p>
        <?php endif; ?>
        <?php if ($model->getTelefonoDefault()): ?>
            <p>
                <?= AmosIcons::show('phone'); ?>
                <span title="<?= $model->getTelefonoDefault() ?>"><?= $model->getTelefonoDefault() ?></span>
            </p>
            <?php
        endif; ?>
    </div>
    <div class="icon-footer">
        <div class="foot-bar">
            <a href="<?= Url::toRoute(['/project_management/projects-tasks/by-activity', 'aid' => $model->id]) ?>"
               class="btn btn-navigation-primary">
                <?= AmosIcons::show('link'); ?>
                <span class="hidden-xs"><?= Module::t('amosproject_management', 'Tasks'); ?></span>
            </a>
            <div class="col-xs-12 container-action">
                <?= $buttons ?>
            </div>
        </div>
    </div>

</div>