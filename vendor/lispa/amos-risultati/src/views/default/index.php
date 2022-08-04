<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

/** @var \lispa\amos\dashboard\models\AmosUserDashboards $currentDashboard * */
/** @var \yii\web\View $this * */

use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\views\assets\AmosCoreAsset;
use lispa\amos\dashboard\AmosDashboard;
use lispa\amos\dashboard\assets\ModuleDashboardAsset;
use lispa\amos\risultati\AmosRisultati;

AmosCoreAsset::register($this);
ModuleDashboardAsset::register($this);
AmosIcons::map($this);

$this->title = $this->context->module->name;
$this->params['breadcrumbs'][] = ['label' => AmosRisultati::t('amosrisultati', 'Risultati'), 'url' => ['/risultati']];

?>

<input type="hidden" id="saveDashboardUrl"
       value="<?= Yii::$app->urlManager->createUrl(['dashboard/manager/save-dashboard-order']); ?>"/>
<input type="hidden" id="currentDashboardId"
       value="<?= $currentDashboard['id'] ?>"/>

<div id="dashboard-edit-toolbar" class="pull-right hidden">
    <?= Html::a(AmosRisultati::t('amosrisultati', 'Salva'), 'javascript:void(0);', [
        'id' => 'dashboard-save-button',
        'class' => 'btn btn-success bk-saveOrder',
    ]);
    ?>

    <?= Html::a(AmosRisultati::t('amosrisultati', 'Annulla'), \yii\helpers\Url::current(), [
        'class' => 'btn btn-danger bk-saveDelete',
    ]);
    ?>

</div>

<?php /*
* @$widgetsIcon elenco dei plugin ad icona
* @$widgetsGrafich elenco dei plugin ad grafici
* @$dashboardsNumber numero delle dashboard da mostrare
*/

?>

<nav data-dashboard-index="<?= $currentDashboard->slide ?>">

    <div class="actions-dashboard-container">
        <ul id="widgets-icon" class="bk-sortableIcon plugin-list"
            role="menu">
            <?php //indice di questa dashboard
            $thisDashboardIndex = 'dashboard_' . $currentDashboard->slide;

            //recupera i widgets di questa dashboard
            $thisDashboardWidgets = $currentDashboard->amosWidgetsSelectedIcon;

            if ($thisDashboardWidgets && count($thisDashboardWidgets) > 0) {

                foreach ($thisDashboardWidgets as $widget) {
                    $widgetObj = Yii::createObject($widget['classname']);
                    echo $widgetObj::widget();
                }
            } else {
                AmosDashboard::t('amosdashboard', 'Non ci sono widgets selezionati per questa dashboard');
            }
            ?>
        </ul>
    </div>

</nav>







