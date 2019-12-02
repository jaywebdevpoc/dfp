<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\organizzazioni\controllers
 * @category   CategoryName
 */

namespace lispa\amos\organizzazioni\controllers;

use lispa\amos\organizzazioni\controllers\base\ProfiloController;

/**
 * Class DefaultController
 * @package lispa\amos\organizzazioni\controllers
 */
class OrganizzazioniController extends ProfiloController
{

    /**
     * 
     * @param type $id
     */
    public function actionView($id){
        return $this->redirect(['/organizzazioni/profilo/view', 'id' => $id]);
    }
}
