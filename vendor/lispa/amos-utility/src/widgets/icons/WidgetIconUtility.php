<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\utility\widgets\icons
 * @category   CategoryName
 */

namespace lispa\amos\utility\widgets\icons;

use lispa\amos\core\user\AmosUser;
use lispa\amos\core\user\User;
use lispa\amos\core\utilities\CoreCommonUtility;
use lispa\amos\core\widget\WidgetIcon;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconUtility
 * @package lispa\amos\utility\widgets\icons
 */
class WidgetIconUtility extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel('Utility');
        $this->setDescription('Plugin Utility');
        $this->setIcon('linentita');
        $this->setUrl(['/utility']);
        $this->setCode('UTILITY_ADMIN');
        $this->setModuleName('utility');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-primary'
        ]));
    }

    /**
     * @inheritdoc
     */
    public function isVisible()
    {
        $isVisible = parent::isVisible();
        if ($isVisible) {
            /** @var AmosUser $webUser */
            $webUser = \Yii::$app->user;
            /** @var User $loggedUser */
            $loggedUser = $webUser->identity;
            // Si vede solo su devel e produzione perché in nessuno dei due ambienti il cliente usa l'utente admin.
            // In qualche stage alcune volte succede quindi non c'è il widget in dashboard.
            // Per gli ambienti di test, stage o pre prod è necessario essere in azienda per vedere il widget.
            $isVisible = (
                $webUser->can('ADMIN') &&
                ($loggedUser->username == 'admin') &&
                (
                    YII_ENV_DEV ||
                    YII_ENV_PROD ||
                    CoreCommonUtility::platformSeenFromHeadquarter()
                )
            );
        }
        return $isVisible;
    }
}
