<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\utility
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\utility;

use lispa\amos\core\utilities\Email;
use yii\base\BaseObject;

/**
 * Class PartnershipProfilesEmailUtility
 * @package lispa\amos\partnershipprofiles\utility
 */
class PartnershipProfilesEmailUtility extends BaseObject
{
    /**
     * @param string $from
     * @param array $tos
     * @param string $subject
     * @param string $text
     * @param array $files
     * @param array $bcc
     * @param array $params
     * @return bool
     */
    public static function sendMail($from, $tos, $subject, $text, $files = [], $bcc = [])
    {
        $ok = true;
        /** @var \lispa\amos\emailmanager\AmosEmail $mailModule */
        $mailModule = \Yii::$app->getModule('email');
        if (isset($mailModule)) {
            if (is_null($from)) {
                if (isset(\Yii::$app->params['email-assistenza'])) {
                    // Use default platform email assistance
                    $from = \Yii::$app->params['email-assistenza'];
                } else {
                    $from = 'assistenza@open20.it';
                }
            }
            $ok = Email::sendMail($from, $tos, $subject, $text, $files, $bcc, [], 0, false);
        }
        return $ok;
    }
}
