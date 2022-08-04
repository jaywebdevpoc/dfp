<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use yii\widgets\DetailView;
use lispa\amos\faq\AmosFaq;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;

/**
 * @var yii\web\View $this
 * @var lispa\amos\faq\models\Faq $model
 */

$this->title = $model->domanda;
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="details_card">
    <div class="faq-stato-view">
        <div class="col-xs-12 right-column">
            <section class="section-data">
                <div class="body">
                        <?php
                        $checkPermTopicNew = true;
                        $pulsantiAdmin = [
                            Html::a(AmosFaq::tHtml('amosfaq', 'Modifica'), "/faq/faq/update?id=" . $model->id, ['model' => $model], $checkPermTopicNew, ['title' => 'modifica']),
                        ];
                        if (!empty($pulsantiAdmin)):
                            ?>
                            <div class="manage col-xs-12 text-right nop">
                                <div class="dropdown">
                                    <a class="manage-menu" data-toggle="dropdown" href="" aria-expanded="true" title="manage menu"><?= AmosIcons::show('more-vert') ?></a>
                                    <ul class="dropdown-menu pull-right">
                                        <?php
                                        foreach ($pulsantiAdmin as $pulsante) {
                                            ?>
                                            <li>
                                                <?php echo $pulsante; ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?= $model->risposta ?>
                </div>
            </section>
        </div>
    </div>
</div>