<?php
/**
 * @var yii\web\View $this
 * @var \lispa\amos\projectmanagement\models\new_project_wizard\StepC $model
 */

use lispa\amos\projectmanagement\Module;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\helpers\Html;
use yii\base\InvalidConfigException;

\lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);

$path = Yii::$app->wizflowManagerNewProject->getPath();
if (count($path) == 1) {
    $descriptionStep = '#NEW_PROJECT_DESCRIPTION_PATH_A';
} else {
    $descriptionStep = '#NEW_PROJECT_DESCRIPTION_PATH_A_B';
}

$this->title = Module::t('amosproject_management', '#NEW_PROJECT_TITLE_STEP_C');
// $this->registerCss('#selected-members .select-on-check-all{ display: none; }');

$this->params['selection'] = $model->users;

$js = <<< JS
$(document).ready(function () {
    setChecked();

    function setChecked() {
        var selected = [];
        $('#selected-members tbody tr').each(function () {
            var user_id = $(this).find('input').val();
            
            console.log(user_id);
            selected.push(user_id);
        });

        $('#grid-members tbody tr').each(function () {
            var valore = $(this).find('input').val();
            var flag = 0;

            for (var i = 0; i < selected.length; i++) {
                if (selected[i] == valore) {
                    $(this).find('input').attr('checked', true);
                    $(this).addClass('success');
                    flag = 1;
                }
            }

            if (flag == 0) {
                $(this).removeClass('success');
                $(this).find('input').removeAttr('checked');
            }
        });
    }

    $(document).on('click', '#grid-members .kv-row-checkbox', function () {
        var user_id = $(this).closest('tr').attr("data-key");
        if (this.checked) {            
            var tr = $(this).closest('tr');
            var new_tr = tr.clone();
            console.log(new_tr.find('.kv-row-select input'));
            new_tr.find('.kv-row-select input')
                .attr('name', 'StepC[users][]')
                .attr('hidden', 'hidden');
            

            if ($('#selected-members .grid-view-empty').length >0) {
                $('#selected-members .grid-view-empty').remove();
            }
            $('#selected-members tbody').append(new_tr);
        }
        else {
            var user_id = $(this).closest('tr').attr("data-key");
            var a = $('#selected-members').find('[data-key="' + user_id + '"]');
            $(a).remove();
        }
        console.log(user_id);
    });
    $.pjax.defaults.timeout = 5000;

    $(".search-button").click(function (event) {
        event.preventDefault();
        $('.loading').show();
        $.pjax.reload({
            container: '#pjax-container',
            method: 'get',
            data: $('#search-form-users input').serialize() + '&nav=next',
            timeout: 5000
        }).done(function () {
            $('.loading').hide();
        }); //Reload GridView
    });


    $("#sendForm").click(function (event) {
        $('#groups-form').submit();
    });

    $(document).on('pjax:end', function (data, status, xhr, options) {
        // console.log('load');
        setChecked();
    });


});
JS;
$this->registerJs($js);
$dataProvider = $model->getAllProfilesDataProvider();
$this->params['breadcrumbs'][] = ['label' => '', 'hidden' => true];
?>


<section class="step-c">
    <?php

    $form = ActiveForm::begin([
        'action' => ['', 'nav' => 'next'],
    ]);
    echo $form->field($model, 'passStep')->hiddenInput()->label(false);

    ?>

    <div class="col-lg-12 nop">
        <!--        <p>--><?php //= Module::t('amosproject_management', '#NEW_PROJECT_SELECT_USER_FIELD') ?><!--</p>-->

        <div class="container-change-view">
            <div class="btn-tools-container">
                <div class="tools-right">
                    <span class="btn btn-tools-primary show-hide-element am am-search"
                          data-toggle-element="form-search"></span>
                </div>
            </div>
        </div>
        <div class="search-users-index">
            <?php
            $modelSearch = new \lispa\amos\admin\models\search\UserProfileSearch();
            echo $this->render('_search_users', ['model' => $modelSearch, 'form' => $form]);
            ?>
        </div>

        <div class="col-xs-12 nop">
            <h2 class="subtitle-wizard">
                <?= Module::t('amosproject_management', '#NEW_PROJECT_DESCRIPTION_STEP_C'); ?>
            </h2>
            <p class="wizard-description">
                <?= Module::t('amosproject_management', $descriptionStep); ?>
            </p>
        </div>

        <?php
        \yii\widgets\Pjax::begin(['id' => 'pjax-container', 'options'  => ['class' => 'col-lg-7 nop'], 'timeout' => 2000, 'clientOptions' => ['data-pjax-container' => 'grid-members']]); ?>
        <?php
        try {
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $dataProvider,
                'id' => 'grid-members',
                'columns' => [
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        'name' => 'StepC[attrSelected][]',
                        'header' => '',
                        'rowSelectedClass' => \kartik\grid\GridView::TYPE_SUCCESS,
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            // pr($this->params['selection']);
                            if (in_array($model->id, (array)$this->params['selection'])) {

                                return ['value' => $model->id,
                                    'checked' => true
                                ];
                            } else {
                                return ['value' => $model->id];
                            }
                        }

                    ],
                    'userProfileImage' => [
                        'label' => Module::t('amosproject_management', '#USER_PROFILE_IMAGE'),//$model->getAttributeLabel('userProfileImage'),
                        'format' => 'html',
                        'value' => function ($model) {
                            /** @var \lispa\amos\admin\models\UserProfile $model */

                            return \lispa\amos\admin\widgets\UserCardWidget::widget(['model' => $model]);
                        }
                    ],
                    'nome',
                    'cognome',
//                    'codice_fiscale',
//                    [
//                        'attribute' => 'user.email',
//                        'label' => 'Email'
//                    ],
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage() . ' L:' . $e->getLine(), 'ERROR');
        }
        \yii\widgets\Pjax::end();
        ?>

        <?php
        //    if ($model->isNewRecord) {
        $dataProviderSelected = new \yii\data\ActiveDataProvider([
            'query' => \lispa\amos\admin\models\UserProfile::find()->andWhere(['id' => $model->attrSelected])
        ]);
        //    }
        ?>
        <div class="col-lg-5">
            <div class="col-xs-12 selected-users">
                <h3><?= Yii::t('amosproject_management', '#NEW_PROJECT_SELECTED_USERS') ?></h3>
                <?php try {
                    echo \lispa\amos\core\views\AmosGridView::widget([
                        'dataProvider' => $dataProviderSelected,
                        'id' => 'selected-members',
                        'columns' => [
                            [
                                'class' => '\kartik\grid\CheckboxColumn',
                                'header' => '',
                                'name' => 'StepC[users][]',
                                'rowSelectedClass' => \kartik\grid\GridView::TYPE_SUCCESS,
                                'checkboxOptions' => function ($model, $key, $index, $column) {
                                    return ['value' => $model->id,
                                        'checked' => true,
                                        'hidden' => true
                                    ];
                                }

                            ],
                            'userProfileImage' => [
                                'label' => Module::t('amosproject_management', '#USER_PROFILE_IMAGE'),//$model->getAttributeLabel('userProfileImage'),
                                'format' => 'html',
                                'value' => function ($model) {
                                    /** @var \lispa\amos\admin\models\UserProfile $model */

                                    return \lispa\amos\admin\widgets\UserCardWidget::widget(['model' => $model]);
                                }
                            ],
                            'nome',
                            'cognome',
//                    'codice_fiscale',
//                    [
//                        'attribute' => 'user.email',
//                        'label' => 'Email'
//                    ],
                        ],
                    ]);
                } catch (Exception $e) {
                    pr($e->getMessage() . ' L:' . $e->getLine(), 'ERROR');
                }
                ?>
            </div>
        </div>
    </div>




    <div class="col-xs-12 btn-wizard-footer nop">
        <div class="form-group">
            <?php
            $labelBack = Module::t('amosproject_management', '#NEW_PROJECT_BACK');
            echo Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> ' . $labelBack,
                ['wizard', 'nav' => 'prev'], ['class' => 'btn btn-primary pull-left']);
            ?>
            <?php
            try {
                $labelForward = Module::t('amosproject_management', '#NEW_PROJECT_FORWARD');
                echo Html::submitButton(
                    $labelForward . ' <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
                    ['class' => 'btn btn-navigation-primary pull-right']);
            } catch (InvalidConfigException $e) {
            }

            ?>

            <?= Html::a(Module::t('amosproject_management', '#NEW_PROJECT_EXIT'), ['exit'], ['class' => 'btn btn-secondary pull-left annulla']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</section>
