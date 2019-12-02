<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\notificationmanager\base\NotifierRepository;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\search\ProjectsSearch;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconMyProjects
 * @package lispa\amos\projectmanagement\widgets\icons
 */
class WidgetIconMyProjects extends WidgetIcon
{
    public function init()
    {
        parent::init();

        $this->setLabel(Module::tHtml('amosproject_management', 'My projects'));
        $this->setDescription(Module::t('amosproject_management', 'View the list of my projects'));

        $this->setIcon('linmodulo');
        $this->setUrl(['/project_management/projects/my-projects']);
        $this->setCode('PROJECTS');
        $this->setModuleName('project_management');
        $this->setNamespace(__CLASS__);

        $projectsSearch = new ProjectsSearch();
        $notifier = new NotifierRepository();
        $this->setBulletCount($notifier->countNotRead(Yii::$app->getUser()->id, Projects::class,
            $projectsSearch->searchMyProjects([])->query));

        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ]));
    }

    public static function widgetLabel()
    {
        return Module::t('amosproject_management', 'My projects');
    }
}
