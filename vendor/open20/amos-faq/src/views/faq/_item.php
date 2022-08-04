<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use open20\amos\core\forms\ContextMenuWidget;
use open20\amos\core\helpers\Html;
use open20\amos\core\icons\AmosIcons;
use open20\amos\faq\AmosFaq;
?>

<div class="row">
    <div id="faq" class="col-md-12">
        <div class="panel-group" id="accordion-faq">
            <div class="panel panel-default">
                <div class="panel-heading text">
                    <?= ContextMenuWidget::widget([
                        'model' => $model,
                        'actionModify' => "/faq/faq/update?id=" . $model->id,
                        'actionDelete' => "/faq/faq/delete?id=" . $model->id,
                        'labelDeleteConfirm' => AmosFaq::t('amosfaq', 'Sei sicuro di voler cancellare questa notizia?')
                    ]) ?>
                    <h4 class="panel-title">
<!--                     if you want to enable the accordion you have to insert value "collapse" in the attribute data-toggle-->
<!--                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-1">-->
                        <p class="accordion-toggle" data-toggle="" data-parent="#accordion-faq" href="#collapse-1">
                            <span class="question-faq">D:</span> <?= $model->domanda ?>
                        </p>
                    </h4>
                </div>
                <div id="collapse-1" class="panel collapse in">
                    <div class="panel-body">
                        <p><span class="awsner-faq">R:</span> <?= $model->risposta ?>
                        </p>
                    </div>
                    <!--<div class="panel-footer hidden">
                        <div class="btn-group btn-group-xs"><span class="btn"></span><a class="btn btn-yes" href="#"> Yes</a> <a class="btn btn-no" href="#"> No</a></div>
                        <div class="btn-group btn-group-xs pull-right"><a class="btn btn-primary" href="#"></a></div>
                    </div> -->
                </div>
            </div>


        </div>
    </div>
</div>
