<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\news
 * @category   CategoryName
 */

namespace lispa\amos\news\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\core\widget\WidgetAbstract;
use lispa\amos\core\icons\AmosIcons;

use lispa\amos\news\AmosNews;
use lispa\amos\news\models\search\NewsSearch;
use lispa\amos\news\models\News;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconAllNews
 * @package lispa\amos\news\widgets\icons
 */
class WidgetIconAllNews extends WidgetIcon
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $paramsClassSpan = [
            'bk-backgroundIcon',
            'color-primary'
        ];

        $this->setLabel(AmosNews::tHtml('amosnews', 'Tutte le notizie'));
        $this->setDescription(AmosNews::t('amosnews', 'Visualizza tutte le notizie'));

        if (!empty(Yii::$app->params['dashboardEngine']) && Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('news');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('feed');
        }

        $this->setUrl(['/news/news/all-news']);

        $this->setCode('ALL-NEWS');
        $this->setModuleName('news');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(),
                $paramsClassSpan
            )
        );

        if ($this->disableBulletCounters == false) {
            $search = new NewsSearch();
            $this->setBulletCount(
                $this->makeBulletCounter(
                    Yii::$app->getUser()->getId(),
                    News::className(),
                    $search->buildQuery([], 'all')
                )
            );
        }
    }

    /**
     * Aggiunge all'oggetto container tutti i widgets recuperati dal controller del modulo
     * 
     * @inheritdoc
     */
    public function getOptions()
    {
        return ArrayHelper::merge(
            parent::getOptions(),
            ['children' => []]
        );
    }

}
