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
 * Class WidgetIconCreatedByProjects
 * @package lispa\amos\projectmanagement\widgets\icons
 */
class WidgetIconCreatedByProjects extends WidgetIcon
{
    public function init()
    {
        parent::init();

        $this->setLabel(Module::tHtml('amosproject_management', 'Projects created by me'));
        $this->setDescription(Module::t('amosproject_management', 'View the list of projects created by me'));

        $this->setIcon('linmodulo');
        $this->setUrl(['/project_management/projects/created-by-projects']);
        $this->setCode('PROJECTS');
        $this->setModuleName('project_management');
        $this->setNamespace(__CLASS__);

        $projectsSearch = new ProjectsSearch();
        $notifier = new NotifierRepository();
        $this->setBulletCount($notifier->countNotRead(Yii::$app->getUser()->id, Projects::class,
            $projectsSearch->searchCreatedByProjects([])->query));

        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ]));
    }

    public static function widgetLabel()
    {
        return Module::t('amosproject_management', 'Created by me');
    }
}
