<?php
/**
 * Created by PhpStorm.
 * User: michele.lafrancesca
 * Date: 10/06/2019
 * Time: 15:52
 */

namespace lispa\amos\community\widgets;


use lispa\amos\community\utilities\CommunityUserFieldUtility;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class CommunityUserFieldWidget extends Widget
{
    public $dynamicModel;
    public $form;
    public $community;

    public function init()
    {
        parent::init();
        if(empty($this->dynamicModel) || empty($this->form)){
            throw new InvalidConfigException("The params 'dynamicModel' and  'form' are mandatory");
        }
//        $this->loadDynamicModel();
    }

    public function run()
    {
        return $this->render('community_user_fields', ['dynamicModel' => $this->dynamicModel, 'form' => $this->form]);

    }

    public function loadDynamicModel(){
        $this->dynamicModel =  CommunityUserFieldUtility::loadDynamicFields($this->community->id);
    }

}