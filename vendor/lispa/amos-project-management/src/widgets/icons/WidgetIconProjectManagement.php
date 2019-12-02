<?php

namespace lispa\amos\projectmanagement\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\helpers\ArrayHelper;

class WidgetIconProjectManagement extends WidgetIcon
{

    public function init()
    {
        parent::init();

        $this->setLabel('Project Management');
        $this->setDescription(Module::t('amosproject_management', 'Accedi al Plugin Project Management'));

        $this->setIcon('linmodulo');


        $this->setUrl(['/project_management/projects/index']);
        $this->setCode('PROJECT_MANAGEMENT_VIEW');
        $this->setModuleName('project_management');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-greyColor'
        ]));
    }

    public function getOptions()
    {
        $options = parent::getOptions();

        //aggiunge all'oggetto container tutti i widgets recuperati dal controller del modulo
        return ArrayHelper::merge($options, ["children" => $this->getWidgetsIcon()]);
    }

    /**
     * Recupera i widget figli da far visualizzare nella dashboard secondaria
     * @return [lispa\amos\core\widget\WidgetIcon] Array con i widget della dashboard
     */
    public function getWidgetsIcon()
    {
        $widgets = [];

        $widget = \lispa\amos\dashboard\models\AmosWidgets::find()->andWhere(['module' => 'project_management'])->andWhere(['type' => 'ICON'])->andWhere([
            '!=',
            'child_of',
            null
        ])->all();

        foreach ($widget as $Widget) {
            $className = (strpos($Widget['classname'],
                    '\\') === 0) ? $Widget['classname'] : '\\' . $Widget['classname'];
            $widgetChild = new $className;
            if ($widgetChild->isVisible()) {
                $widgets[] = $widgetChild->getOptions();
            }
        }
        return $widgets;
    }

}
