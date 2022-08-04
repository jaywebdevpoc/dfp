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

namespace lispa\amos\faq\models\base;

use lispa\amos\core\record\Record;
use lispa\amos\faq\AmosFaq;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "faq_categories".
 *
 * @property integer $id
 * @property string $titolo
 * @property string $descrizione
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property integer $version
 */
class FaqCategories extends Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descrizione'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by', 'version'], 'integer'],
            [['titolo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => AmosFaq::t('amosfaq', 'ID'),
            'titolo' => AmosFaq::t('amosfaq', 'Titolo'),
            'descrizione' => AmosFaq::t('amosfaq', 'Descrizione'),
            'created_at' => AmosFaq::t('amosfaq', 'Creato il'),
            'updated_at' => AmosFaq::t('amosfaq', 'Aggiornato il'),
            'deleted_at' => AmosFaq::t('amosfaq', 'Cancellato il'),
            'created_by' => AmosFaq::t('amosfaq', 'Creato da'),
            'updated_by' => AmosFaq::t('amosfaq', 'Aggiornato da'),
            'deleted_by' => AmosFaq::t('amosfaq', 'Cancellato da'),
            'version' => AmosFaq::t('amosfaq', 'Versione numero'),
        ]);
    }
}
