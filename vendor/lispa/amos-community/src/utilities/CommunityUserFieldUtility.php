<?php
/**
 * Created by PhpStorm.
 * User: michele.lafrancesca
 * Date: 10/06/2019
 * Time: 15:27
 */

namespace lispa\amos\community\utilities;


use lispa\amos\community\models\Community;
use lispa\amos\community\models\CommunityUserField;
use lispa\amos\community\models\CommunityUserFieldVal;
use lispa\amos\community\validators\UniqueUserValCommunityValidator;
use lispa\amos\core\validators\CFValidator;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;

class CommunityUserFieldUtility
{

    /**
     * @param $community_id
     * @return null|DynamicModel
     */
    public static function loadDynamicFields($community_id)
    {
        $dynamicModel = null;
        $community = Community::findOne($community_id);
        if ($community) {

            $fields = $community->communityUserField;
            $attributesTypes = [];
            $attributes = ['attributesTypes'];
            $requiredAtributes = [];
            $uniqueAttributes = [];
            $attributesWithValidators = [];

            /** @var  $field CommunityUserField */
            foreach ($fields as $field) {
                $attributes [] = $field->name;
                $attributesTypes [$field->name] = $field->fieldType->type;
                if ($field->required) {
                    $requiredAtributes [] = $field->name;
                }
                if($field->unique){
                    $uniqueAttributes [] = $field->name;
                }

                if(!empty($field->validator_classname)){
                    $attributesWithValidators [$field->name] = $field->validator_classname;
                }
            }
//            die;

            $dynamicModel = new DynamicModel($attributes);
            $dynamicModel->attributesTypes = $attributesTypes;
            $dynamicModel->addRule($attributes, 'safe');
            $dynamicModel->addRule($uniqueAttributes, UniqueUserValCommunityValidator::className(), ['community_id' => $community_id]);
            $dynamicModel->addRule($requiredAtributes, 'required');
            foreach ($attributesWithValidators as $attr => $validator){
                if(class_exists($validator)) {
                    $classValidator = $validator::className();
                    $dynamicModel->addRule($attr, $classValidator);
                }
            }
            $dynamicModel = self::loadFieldsToDynamicModel($dynamicModel, $community);
        }
        return $dynamicModel;
    }


    /**
     * @return DynamicModel
     */
    public static function loadFieldsToDynamicModel($dynamicModel, $community)
    {
        $fields = $community->communityUserField;
        foreach ($fields as $field) {
            $value = $field->getCommunityUserFieldVals(\Yii::$app->user->id)->one();
            if ($value) {
                $attribute = $field->name;
                $dynamicModel->$attribute = $value->value;
            }
        }
        return $dynamicModel;
    }


    /**
     * @param $dynamicModel DynamicModel
     * @param $attributesTypes
     * @param $community
     * @throws \yii\base\InvalidConfigException
     */
    public static function saveFieldsFormDynamicModel($dynamicModel, $attributesTypes, $community)
    {
        foreach ($dynamicModel->attributes() as $attribute) {
            $modelField = CommunityUserField::find()->andWhere(['community_id' => $community->id, 'name' => $attribute])->one();
            if ($modelField) {
                $val = $modelField->getCommunityUserFieldVals(\Yii::$app->user->id)->one();
                if ($attributesTypes[$attribute] != 'file') {
                    if ($val) {
                        $val->value = $dynamicModel->$attribute;
                    } else {
                        $val = new CommunityUserFieldVal();
                        $val->user_id = \Yii::$app->user->id;
                        $val->user_field_id = $modelField->id;
                        $val->value = $dynamicModel->$attribute;
                    }
                    $val->save();
                }
//                if($attributesTypes[$attribute] == 'file'){
//                    $this->saveFileFields($attribute, $modelField);
//                }
            }
        }
        return true;
    }


    public static function getCommunityUserFieldValues()
    {
        $fields = [];
        $moduleCwh = \Yii::$app->getModule('cwh');
        if (isset($moduleCwh) && !empty($moduleCwh->getCwhScope())) {
            $scope = $moduleCwh->getCwhScope();
            if (isset($scope['community'])) {
                $id = $scope['community'];
                $community = Community::findOne($id);
                $fields = $community->communityUserField;
                if(empty($fields) && $community->parent_id){
                    $community = Community::findOne($community->parent_id);
                    $fields = $community->communityUserField;
                }
            }
        }
        return $fields;
    }
}