<?php

namespace lispa\amos\projectmanagement\controllers;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use yii\web\ForbiddenHttpException;

/**
* This is the class for controller "ProjectsProgressCostsController".
*/
class ProjectsProgressCostsController extends base\ProjectsProgressCostsController
{

    /**
     * Displays a single ProjectsProgressStatements model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionViewProgress($id, $pid)
    {
        $this->setUpLayout('form');

        $project = Projects::find()->andWhere(['id' => $pid])->one();
        if (empty($project)) {
            throw new ForbiddenHttpException();
        }
        $detectionPeriod = ProjectsProgressDetectionPeriod::find()->andWhere(['id' => $id])->one();;
        if (empty($detectionPeriod)) {
            throw new ForbiddenHttpException();
        }

        return $this->render('view-progress', [
            'model' => $detectionPeriod,
            'projects' => $project,
        ]);
    }

}
