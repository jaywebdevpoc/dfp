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

namespace lispa\amos\faq;

use lispa\amos\core\module\AmosModule;
use lispa\amos\faq\widgets\icons\WidgetIconFaq;
use lispa\amos\core\interfaces\CmsModuleInterface;
use yii\console\Application;

/**
 * Class AmosFaq
 * @package lispa\amos\faq
 */
class AmosFaq extends AmosModule implements CmsModuleInterface
{
    public $controllerNamespace = 'lispa\amos\faq\controllers';
    public $name = 'FAQ';

    public static function getModuleName()
    {
        return 'faq';
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return \Yii::t('amos/faq/' . $category, $message, $params, $language);
    }



    public function init()
    {
        parent::init();

        \Yii::setAlias('@lispa/amos/' . static::getModuleName() . '/controllers/', __DIR__ . '/controllers/');
        \Yii::configure($this, require(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php'));
        $this->registerTranslations();

    }

    public function registerTranslations()
    {
        $translationConfiguration = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => \Yii::$app->language,
            'basePath' => '@vendor/lispa/amos-faq/src/messages',
            'fileMap' => [
                'amos/faq/app' => 'app.php',
            ],
        ];

        if (!YII_ENV_PROD) {
            $translationConfiguration['on missingTranslation'] = ['lispa\amos\faq\components\TranslationEventHandler', 'handleMissingTranslation'];
        }

        \Yii::$app->getI18n()->translations['amos/faq/*'] = $translationConfiguration;

    }

    public function getWidgetGraphics()
    {

    }

    public function getWidgetIcons()
    {
        return [
            WidgetIconFaq::className(),
        ];
    }

    /**
     * Get default model classes
     */
    protected function getDefaultModels()
    {
        return [
            'Faq' => __NAMESPACE__ . '\\' . 'models\\Faq',
        ];
    }
    
    /****
     * CmsModuleInterface
     */
     public static function getModelSearchClassName() {
        return __NAMESPACE__.'\models\FaqSearch';
    }

    public static function getModelClassName() {
        return __NAMESPACE__ . '\models\Faq';
    }
}
