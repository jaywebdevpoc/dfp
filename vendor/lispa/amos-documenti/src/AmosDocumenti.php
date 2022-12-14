<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\documenti
 * @category   CategoryName
 */

namespace lispa\amos\documenti;

use lispa\amos\core\exceptions\AmosException;
use lispa\amos\core\module\AmosModule;
use lispa\amos\core\module\ModuleInterface;
use lispa\amos\core\interfaces\SearchModuleInterface;
use lispa\amos\documenti\widgets\graphics\WidgetGraphicsHierarchicalDocuments;
use lispa\amos\documenti\widgets\graphics\WidgetGraphicsUltimiDocumenti;
use lispa\amos\documenti\widgets\icons\WidgetIconAdminAllDocumenti;
use lispa\amos\documenti\widgets\icons\WidgetIconAllDocumenti;
use lispa\amos\documenti\widgets\icons\WidgetIconDocumenti;
use lispa\amos\documenti\widgets\icons\WidgetIconDocumentiCategorie;
use lispa\amos\documenti\widgets\icons\WidgetIconDocumentiCreatedBy;
use lispa\amos\documenti\widgets\icons\WidgetIconDocumentiDashboard;
use lispa\amos\documenti\widgets\icons\WidgetIconDocumentiDaValidare;
use Yii;
use yii\helpers\ArrayHelper;
use lispa\amos\core\interfaces\CmsModuleInterface;

/**
 * Class AmosDocumenti
 * @package lispa\amos\documenti
 */
class AmosDocumenti extends AmosModule implements ModuleInterface, SearchModuleInterface, CmsModuleInterface
{
    public static $CONFIG_FOLDER = 'config';

    /**
     * @var string|boolean the layout that should be applied for views within this module. This refers to a view name
     * relative to [[layoutPath]]. If this is not set, it means the layout value of the [[module|parent module]]
     * will be taken. If this is false, layout will be disabled within this module.
     */
    public $layout = 'main';

    public $name = 'Documenti';

    public $controllerNamespace = 'lispa\amos\documenti\controllers';

    /**
     * @var bool|false if document foldering is enabled or not
     */
    public $enableFolders = false;

    /**
     * @var bool|true if document categories are enabled or not
     */
    public $enableCategories = true;

    /**
     * @var array
     */
    public $whiteListRolesCategories = ['ADMIN', 'BASIC_USER'];

    /**
     * @var bool $enableDocumentVersioning If true enable the versioning of the documents. The folders aren't versioned.
     */
    public $enableDocumentVersioning = false;

    /**
     * @var array $documentExtraRequiredFields - extra mandatory fields in document form
     */
    public $documentExtraRequiredFields = [];

    /**
     * @var string List of the allowed extensions for the upload of files.
     */
    public $whiteListFilesExtensions = 'csv, doc, docx, pdf, rtf, txt, xls, xlsx';


    /**
     * @var string List of the allowed extensions for the upload of files.
     */
    public $whiteListFilesExtensionsImage = 'jpeg, jpg, png, gif';

    /**
     * @var bool|false $hidePubblicationDate
     */
    public $hidePubblicationDate = false;

    /**
     * @var array $defaultListViews This set the default order for the views in lists
     */
    public $defaultListViews = ['list', 'grid', 'expl'];
    
    
    /**
     * @var string $defaultView Set the default view for module
     */
    public $defaultView = 'list';
    
    /**
     * @var array
     */
    public $layoutPublishedByWidget = [
        'layout' => '{publisher}{targetAdv}{category}',
        //'layoutAdmin' => '{publisher}{targetAdv}{category}{status}{pubblicationdates}'
        'layoutAdmin' => '{publisherSection}{targetAdvSection}{categorySection}{statusSection}{pubblicationdatesSection}'
    ];

    /**
     * @var bool
     */
    public $showCountDocumentRecursive = false;

    /**
     * @var bool|false $enableGroupNotification
     */
    public $enableGroupNotification = false;

    /**
     * @var bool|false $hideWizard
     */
    public $hideWizard = false;

    /**
     * @var string
     */
    public $defaultWidgetIndexUrl = '/documenti/documenti/own-interest-documents';

    /**
     * @var bool
     */
    public $enableCategoriesForCommunity = false;

    /**
     * @var bool
     */
    public $filterCategoriesByRole = false;


    public $showAllCategoriesForCommunity = true;

    /**
     * @var bool disableStandardWorkflow Disable standard worflow, direct publish
     */
    public $disableStandardWorkflow = false;
    
    /**
     * @var bool $alwaysLinkToViewWidgetGraphicLastDocs
     */
    public $alwaysLinkToViewWidgetGraphicLastDocs = false;

    /**
     * @var string new explorer view
     */
    public $viewExpl;

    /**
     * @var int used by uploader 
     */
    public $timeout;

    /**
     * @var bool $documentsOnlyText If true the main document file and the external document link are not required at all.
     */
    public $documentsOnlyText = false;
    
    /**
     * @inheritdoc
     */
    public static function getModuleName()
    {
        return "documenti";
    }
    
    public static function getModelSearchClassName() {
        return __NAMESPACE__.'\models\search\DocumentiSearch';
    }
    
    public static function getModuleIconName() {
        return 'file-text-o';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::setAlias('@lispa/amos/' . static::getModuleName() . '/controllers', __DIR__ . '/controllers/');

        //Configuration: merge default module configurations loaded from config.php with module configurations set by the application
        $config = require(__DIR__ . DIRECTORY_SEPARATOR . self::$CONFIG_FOLDER . DIRECTORY_SEPARATOR . 'config.php');
        Yii::configure($this, ArrayHelper::merge($config, $this));

        if (!is_array($this->defaultListViews)) {
            throw new AmosException(self::t('amosdocumenti', '#exception_msg_defaultlistviews_not_array'));
        }
    }

    /**
     * @inheritdoc
     */
    public function getWidgetIcons()
    {
        return [
            WidgetIconAdminAllDocumenti::className(),
            WidgetIconAllDocumenti::className(),
            WidgetIconDocumenti::className(),
            WidgetIconDocumentiCategorie::className(),
            WidgetIconDocumentiCreatedBy::className(),
            WidgetIconDocumentiDashboard::className(),
            WidgetIconDocumentiDaValidare::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWidgetGraphics()
    {
        return [
            WidgetGraphicsHierarchicalDocuments::className(),
            WidgetGraphicsUltimiDocumenti::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultModels()
    {
        return [
            'Documenti' => __NAMESPACE__ . '\\' . 'models\Documenti',
            'DocumentiSearch' => __NAMESPACE__ . '\\' . 'models\search\DocumentiSearch',
            'DocumentiCategorie' => __NAMESPACE__ . '\\' . 'models\DocumentiCategorie',
            'DocumentiCategorieSearch' => __NAMESPACE__ . '\\' . 'models\search\DocumentiCategorieSearch',
            'DocumentiCategoryCommunityMm' => __NAMESPACE__ . '\\' . 'models\DocumentiCategoryCommunityMm',
            'DocumentiCategoryRolesMm' => __NAMESPACE__ . '\\' . 'models\DocumentiCategoryRolesMm',
            'ReportNode' => __NAMESPACE__ . '\\' . 'models\ReportNode',
            'UploaderImportList' => __NAMESPACE__ . '\\' . 'models\UploaderImportList',
        ];
    }

    /**
     * This method return the session key that must be used to add in session
     * the url from the user have started the content creation.
     * @return string
     */
    public static function beginCreateNewSessionKey()
    {
        return 'beginCreateNewUrl_' . self::getModuleName();
    }

    public static function getModelClassName()
    {
        return __NAMESPACE__ . '\\' . 'models\Documenti';
    }
}
