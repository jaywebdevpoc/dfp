<?php

namespace lispa\amos\videoconference\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\core\widget\WidgetAbstract;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\videoconference\AmosVideoconference;
use Yii;
use yii\helpers\ArrayHelper;

// use lispa\amos\comuni\AmosComuni;

class WidgetIconVideoconference extends WidgetIcon
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $paramsClassSpan = [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ];

        $this->setLabel(AmosVideoconference::tHtml('amosvideoconference', 'Videoconference'));
        $this->setDescription(AmosVideoconference::t('amosvideoconference', 'Plugin per videoconferenze'));

        if (!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('videoconferenza');
            $paramsClassSpan = [];
        } else {
            $this->setIconFramework('dash');
            $this->setIcon('video-camera');
        }

        $this->setUrl(Yii::$app->urlManager->createUrl(['/videoconference/videoconf/index']));
        $this->setModuleName('videoconference');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(),
                $paramsClassSpan
            )
        );
    }

}
