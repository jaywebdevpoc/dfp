<?php
/** @var $model \lispa\amos\projectmanagement\models\Projects */
use lispa\amos\projectmanagement\Module;


$this->title = Module::t('amosproject_management', '#info_creation_title');

?>

<div class = "col-xs-12">
    <h3><?= Module::t('amosproject_management', "#info_creation_description", ['projecTitle' => $model->name])?></h3>
    <ul>
        <li><?= Module::t('amosproject_management','#info_creation_list_1' ) ?></li>
        <li><?= Module::t('amosproject_management','#info_creation_list_2' ) ?></li>

    </ul>
    <?=  \lispa\amos\core\helpers\Html::a(Module::t('amosproject_management', 'Continua'), ['/project_management/projects/update', 'id' => $model->id], [
        'class' => 'btn btn-primary pull-right'
    ])?>
</div>
