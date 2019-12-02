<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\core\utilities
 * @category   CategoryName
 */

namespace lispa\amos\core\utilities;

use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\module\BaseAmosModule;
use lispa\amos\core\record\Record;
use yii\log\Logger;

/**
 * Class FormUtility
 * @package lispa\amos\core\utilities
 */
class FormUtility
{
    /**
     * Return the error triangle to put in a tab header.
     * @return string
     */
    public static function tabErrorTriangle()
    {
        return Html::tag('span', '&nbsp; ' . AmosIcons::show('alert-triangle'), [
            'id' => 'errore-alert-common',
            'class' => 'errore-alert hidden',
            'title' => \Yii::t('amoscore', 'La tab contiene degli errori')
        ]);
    }

    /**
     * This method link two models.
     * @param Record $startModel
     * @param Record $modelToLink
     * @param string $relationToLink
     * @return bool
     */
    public static function linkModels($startModel, $modelToLink, $relationToLink)
    {
        $ok = true;
        try {
            $startModel->link($relationToLink, $modelToLink);
        } catch (\Exception $exception) {
            $ok = false;
            \Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
        }
        return $ok;
    }

    /**
     * Save all values selected by user in a multi select field.
     * @param array $attrMmPost
     * @param string $mmModelClassName
     * @param string $firstIdField
     * @param int $firstIdValue
     * @param string $secondIdField
     * @return bool
     */
    public static function saveMmsFields($attrMmPost, $mmModelClassName, $firstIdField, $firstIdValue, $secondIdField)
    {
        $allOk = true;
        if (!empty($attrMmPost)) {
            if (!is_array($attrMmPost)) {
                $attrMmPost = [$attrMmPost];
            }
            foreach ($attrMmPost as $attrId) {
                /** @var \lispa\amos\core\record\Record $attrMmModel */
                $attrMmModel = new $mmModelClassName();
                $attrMmModel->{$firstIdField} = $firstIdValue;
                $attrMmModel->{$secondIdField} = $attrId;
                $ok = $attrMmModel->save(false);
                if (!$ok) {
                    $allOk = false;
                }
            }
        }
        return $allOk;
    }

    /**
     * Return an array with the values used in boolean fields. If the param 'invertValues' is true the values are returned inverted.
     * @param bool $invertValues
     * @return array
     */
    public static function getBooleanFieldsValues($invertValues = false)
    {
        if ($invertValues) {
            return [
                Html::BOOLEAN_FIELDS_VALUE_YES => BaseAmosModule::t('amoscore', 'Yes'),
                Html::BOOLEAN_FIELDS_VALUE_NO => BaseAmosModule::t('amoscore', 'No')
            ];
        } else {
            return [
                Html::BOOLEAN_FIELDS_VALUE_NO => BaseAmosModule::t('amoscore', 'No'),
                Html::BOOLEAN_FIELDS_VALUE_YES => BaseAmosModule::t('amoscore', 'Yes')
            ];
        }
    }
}
