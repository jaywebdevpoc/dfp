<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement;

use lispa\amos\core\module\AmosModule;
use lispa\amos\core\module\ModuleInterface;
use yii\base\Exception;

/**
 * Class Module
 * @package lispa\amos\projectmanagement
 */
class Module extends AmosModule implements ModuleInterface
{
    public static $CONFIG_FOLDER = 'config';

    static $name = 'project_management';

    /**
     * @var string|boolean the layout that should be applied for views within this module. This refers to a view name
     * relative to [[layoutPath]]. If this is not set, it means the layout value of the [[module|parent module]]
     * will be taken. If this is false, layout will be disabled within this module.
     */
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'lispa\amos\projectmanagement\controllers';

    public $rbacEnabled = false;

    public $timeout = 180;

    /**
     * Parameter that define the organization to use
     * @var string $organizationModuleName
     */
    public $organizationModuleName = 'organizzazioni';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::setAlias('@lispa/amos/projectmanagement/controllers/', __DIR__ . '/controllers');
        // custom initialization code goes here
        \Yii::configure($this, require(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php'));
    }

    /**
     * Module name
     * @return string
     */
    public static function getModuleName()
    {
        return self::$name;
    }

    public function getWidgetIcons()
    {
        return [
        ];
    }

    public function getWidgetGraphics()
    {
        return [
        ];
    }

    /**
     * Get default models
     * @return array
     */
    protected function getDefaultModels()
    {
        return [
        ];
    }

//    /**
//     * @throws Exception
//     */
//    public function getModuleOrganization()
//    {
//        $module = \Yii::$app->getModule($this->organizationModuleName);
//        if (!empty($module)){
//            return $module;
//        } else {
//            throw new Exception(Module::t('amosproject_management', 'Organization Module Not Available'));
//        }
//    }

    /**
     * @throws Exception
     */
    public static function getModuleOrganization()
    {
        $projectModule = \Yii::$app->getModule(Module::getModuleName());
        $orgModule = \Yii::$app->getModule($projectModule->organizationModuleName);
        if (!empty($orgModule)) {
            return $orgModule;
        } else {
            throw new Exception(Module::t('amosproject_management', 'Organization Module Not Available'));
        }
    }
}
