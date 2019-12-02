<?php

namespace lispa\amos\projectmanagement\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\helpers\ArrayHelper;

class WidgetIconprojects extends WidgetIcon
{

    public function init()
    {
        parent::init();

        $this->setLabel(Module::t('amosproject_management', 'Projects'));
        $this->setDescription(Module::t('amosproject_management',
            'Consente all\'utente di modificare l\'entità Project Management'));

        $this->setIcon('linmodulo');

        if (!Yii::$app->user->isGuest) {
            $this->setUrl(['/project_management/projects/index']);
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
        return Module::t('amosproject_management', 'All projects');
    }

}
