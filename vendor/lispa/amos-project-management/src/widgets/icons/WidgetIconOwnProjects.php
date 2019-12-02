<?php

namespace lispa\amos\projectmanagement\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\helpers\ArrayHelper;

class WidgetIconOwnProjects extends WidgetIcon
{

    public function init()
    {
        parent::init();

        $this->setLabel(Module::t('amosproject_management', 'Own projects'));
        $this->setDescription(Module::t('amosproject_management','All own projects'));

        $this->setIcon('linmodulo');

        if (!Yii::$app->user->isGuest) {
            $this->setUrl(['/project_management/projects/own-projects']);
        }
        $this->setCode('PROJECTS');
        $this->setModuleName('project_management');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-lightBase'
        ]));
    }

    public static function widgetLabel()
    {
        return Module::t('amosproject_management', 'All own projects');
    }

}
