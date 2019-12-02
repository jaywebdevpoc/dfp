<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\models\base
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\models\base;

use lispa\amos\core\record\Record;
use lispa\amos\partnershipprofiles\Module;
use yii\helpers\ArrayHelper;

/**
 * Class PartnershipProfilesType
 *
 * This is the base-model class for table "partnership_profiles_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\partnershipprofiles\models\PartnershipProfilesTypesMm[] $partnershipProfilesTypesMm
 *
 * @package lispa\amos\partnershipprofiles\models\base
 */
class PartnershipProfilesType extends Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partnership_profiles_type';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Module::t('amospartnershipprofiles', 'ID'),
            'name' => Module::t('amospartnershipprofiles', 'Name'),
            'description' => Module::t('amospartnershipprofiles', 'Description'),
            'created_at' => Module::t('amospartnershipprofiles', 'Created at'),
            'updated_at' => Module::t('amospartnershipprofiles', 'Updated at'),
            'deleted_at' => Module::t('amospartnershipprofiles', 'Deleted at'),
            'created_by' => Module::t('amospartnershipprofiles', 'Created by'),
            'updated_by' => Module::t('amospartnershipprofiles', 'Updated by'),
            'deleted_by' => Module::t('amospartnershipprofiles', 'Deleted by')
        ]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnershipProfilesTypesMm()
    {
        return $this->hasMany(\lispa\amos\partnershipprofiles\models\PartnershipProfilesTypesMm::className(), ['partnership_profiles_type_id' => 'id']);
    }
}
