<?php

namespace lispa\amos\projectmanagement\controllers;

use lispa\amos\core\user\User;
use lispa\amos\core\utilities\Email;
use lispa\amos\projectmanagement\models\ProjectsActivitiesOrganizationMm;
use lispa\amos\projectmanagement\models\ProjectsProgressCosts;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\models\ProjectsProgressStatements;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksOrganizationMm;
use yii\console\Controller;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\Console;

/**
 * Class ProjectsProgressDetectionPeriodConsoleController
 * @package lispa\amos\projectmanagement\controllers
 */
class ProjectsProgressDetectionPeriodConsoleController extends Controller
{
    const DATE_FORMAT = 'Y/m/d';

    public function actionDetectionPeriodInProgressCheck()
    {
        Console::stdout("Start\n");

        $today = new \DateTime();
        $listDetections = ProjectsProgressDetectionPeriod::find()->andWhere([
            'status' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED
        ])->all();
        /** @var ProjectsProgressDetectionPeriod $detection */
        foreach ($listDetections as $detection) {
            $detectionWarningDate = new \DateTime($detection->warning_date);
            if ($detectionWarningDate->format(self::DATE_FORMAT) == $today->format(self::DATE_FORMAT)) {
                switch ($detection->projects_progress_detection_type_id) {
                    case 1:
                        $this->handleActivityProgressStatements($detection);
                        break;
                    case 2:
                        $this->handleActivityProgressCosts($detection);
                        break;
                }
            }
        }

        Console::stdout("End\n");
    }

    /**
     * @param ProjectsProgressDetectionPeriod $detection
     */
    private function handleActivityProgressStatements(ProjectsProgressDetectionPeriod $detection)
    {
        $today = new \DateTime();
        $listDetectionPeriod = ProjectsProgressDetectionPeriod::find()->andWhere([
            'projects_id' => $detection->projects_id,
            'projects_progress_detection_type_id' => ProjectsProgressDetectionPeriod::STATEMENTS_TYPE
        ])->all();

        // 1) This Project - all oldiest detection period with (end_date < today) and status is "in progress" are to closed
        /** @var ProjectsProgressDetectionPeriod $dp */
        foreach ($listDetectionPeriod as $dp) {
            $detectionCloseDate = new \DateTime($dp->end_date);
            if (($detectionCloseDate->format(self::DATE_FORMAT) < $today->format(self::DATE_FORMAT)) && ($dp->status == ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS)) {
                $dp->detachBehaviors();
                $dp->status = ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_CLOSED;
                $dp->updated_at = new Expression('NOW()');
                $dp->save(false);
                Console::stdout("Old detection period expired, Id " . $dp->id . " Closed!\n");
            }
        }

        // 2) status to in progress
        $detection->detachBehaviors();
        $detection->status = ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS;
        $detection->updated_at = new Expression('NOW()');
        $detection->save(false);

        // 3) Create all Progress Statemets of this project
        /** @var ActiveQuery $query */
        $query = ProjectsTasks::find();
//        $query->joinWith('projectsActivities.projects');
        $query->innerJoin('projects_tasks_projects_activities_mm', 'projects_tasks.id = projects_tasks_projects_activities_mm.projects_tasks_id');
        $query->innerJoin('projects_activities', 'projects_tasks_projects_activities_mm.projects_activities_id = projects_activities.id');
        $query->innerJoin('projects_activities_projects_mm', 'projects_activities.id = projects_activities_projects_mm.projects_activities_id');
        $query->innerJoin('projects', 'projects_activities_projects_mm.projects_id = projects.id');
        $query->andWhere([
            'projects.id' => $detection->projects_id,
        ]);
//        Console::stdout($query->createCommand()->rawSql . "\n");

        $users = [];
        $listOfTask = $query->all();
        /** @var ProjectsTasks $task */
        foreach ($listOfTask as $task) {
            $task->detachBehaviors();
            $progressStatement = new ProjectsProgressStatements();
            $progressStatement->detachBehaviors();
            $progressStatement->projects_task_id = $task->id;
            $progressStatement->projects_progress_detection_period_id = $detection->id;
            $progressStatement->status = ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT;
            $progressStatement->created_at = new Expression('NOW()');
            $progressStatement->created_by = $detection->created_by;
            $progressStatement->updated_at = new Expression('NOW()');
            $progressStatement->save(false);
            Console::stdout("Progress statement created, id " . $progressStatement->id . " for task " . $task->id . " \n");

            // DETECT responsible of TASK
            /** @var ProjectsTasksOrganizationMm $projectTaskMm */
            $projectTaskMm = ProjectsTasksOrganizationMm::find()->andWhere([
                'projects_tasks_id' => $task->id,
            ])->one();
            if (!empty($projectTaskMm)) {

                $users[$projectTaskMm->user_id] = $projectTaskMm->user_id;
            }

            // DETECT responsible of ACTIVITY
            /** @var ActiveQuery $userActivityQuery */
            $userActivityQuery = ProjectsActivitiesOrganizationMm::find();
            $userActivityQuery->innerJoin('projects_tasks_projects_activities_mm', 'projects_tasks_projects_activities_mm.projects_activities_id = projects_activities_organization_mm.projects_activities_id');
            $userActivityQuery->andWhere(['projects_tasks_projects_activities_mm.projects_tasks_id' => $task->id]);
            $activityOrganizationMm = $userActivityQuery->one();
            if (!empty($activityOrganizationMm)) {
                $users[$activityOrganizationMm->user_id] = $activityOrganizationMm->user_id;
            }
        }

        // 4) Email to all responsible of this Task Or Activity
        $subject = '#subject_statement_detection';
        $text = '#EMAIL_STATEMENT_DETECTION_PERIOD1';
//        foreach ($users as $user){
//            $us = User::findOne($user);
//            Console::stdout("Email to" . $us->email . " \n");
//        }
        $this->sendMail($detection, array_unique($users), $subject, $text);
    }

    /**
     * @param ProjectsProgressDetectionPeriod $detection
     */
    private function handleActivityProgressCosts(ProjectsProgressDetectionPeriod $detection)
    {
        $today = new \DateTime();
        $listDetectionPeriod = ProjectsProgressDetectionPeriod::find()->andWhere([
            'projects_id' => $detection->projects_id,
            'projects_progress_detection_type_id' => ProjectsProgressDetectionPeriod::COSTS_TYPE,
        ])->all();

        // 1) This Project - all oldiest detection period with (end_date < today) and status is "in progress" are to closed
        /** @var ProjectsProgressDetectionPeriod $dp */
        foreach ($listDetectionPeriod as $dp) {
            $detectionCloseDate = new \DateTime($dp->end_date);
            if (($detectionCloseDate->format(self::DATE_FORMAT) < $today->format(self::DATE_FORMAT)) && ($dp->status == ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS)) {
                $dp->detachBehaviors();
                $dp->status = ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_CLOSED;
                $dp->updated_at = new Expression('NOW()');
                $dp->save(false);
                Console::stdout("Old detection period expired, Id " . $dp->id . " Closed!\n");
            }
        }

        // 2) status to in progress
        $detection->detachBehaviors();
        $detection->status = ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS;
        $detection->updated_at = new Expression('NOW()');
        $detection->save(false);

        // 3) Create all Progress Statemets of this project
        /** @var ActiveQuery $query */
        $query = ProjectsTasks::find();
//        $query->joinWith('projectsActivities.projects');
        $query->innerJoin('projects_tasks_projects_activities_mm', 'projects_tasks.id = projects_tasks_projects_activities_mm.projects_tasks_id');
        $query->innerJoin('projects_activities', 'projects_tasks_projects_activities_mm.projects_activities_id = projects_activities.id');
        $query->innerJoin('projects_activities_projects_mm', 'projects_activities.id = projects_activities_projects_mm.projects_activities_id');
        $query->innerJoin('projects', 'projects_activities_projects_mm.projects_id = projects.id');
        $query->andWhere([
            'projects.id' => $detection->projects_id,
        ]);

        $users = [];
        $listOfTask = $query->all();
        /** @var ProjectsTasks $task */
        foreach ($listOfTask as $task) {
            $task->detachBehaviors();
            $progressCost = new ProjectsProgressCosts();
            $progressCost->detachBehaviors();
            $progressCost->projects_task_id = $task->id;
            $progressCost->projects_progress_detection_period_id = $detection->id;
            $progressCost->status = ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT;
            $progressCost->created_at = new Expression('NOW()');
            $progressCost->created_by = $detection->created_by;
            $progressCost->updated_at = new Expression('NOW()');
            $progressCost->save(false);
            Console::stdout("Progress cost created, id " . $progressCost->id . " for task " . $task->id . " \n");

            if (!empty($task->user_responsible_costs_id)) {
                $user[$task->user_responsible_costs_id] = $task->user_responsible_costs_id;
            }

            // DETECT responsible of ACTIVITY and tasks - POII-1119
            $users[] = $progressCost->projectsTask->getUserResponsibleId();
            $users[] = $progressCost->projectsTask->projectsActivities->getUserResponsibleId();
            $users  = array_unique ($users);
        }

        // 4) Email to all responsible of this Task Or Activity
        $subject = '#subject_project_cost';
        $text = '#EMAIL_COST_DETECTION_PERIOD1';
        $this->sendMail($detection, $users, $subject, $text);
    }

    /**
     * @param ProjectsProgressDetectionPeriod $model
     * @param $userIds
     * @param $subject
     * @param $text
     * @param null $from
     * @return void
     */
    private function sendMail(ProjectsProgressDetectionPeriod $model, $userIds, $subject, $text, $from = null)
    {
        if (is_null($from)) {
            $from = \Yii::$app->params['email-assistenza'];
            if(is_null($from)){
                $from = \Yii::$app->params['supportEmail'];
            }
        }

        $to = [];
        foreach ($userIds as $id) {
//            Console::stdout("< " . $id. " for task ">" \n");
            $toEmail = User::find()->andWhere(['id' => $id])->one()->email;
            $to[] = $toEmail;

            $subjectRendered = Email::renderMailPartial(
                '@vendor/lispa/amos-project-management/src/views/projects-progress-detection-period/email/content_subject',
                [
                    'text' => $subject,
                    'model' => $model,
                ],
                $id);

            $textRendered = Email::renderMailPartial(
                '@vendor/lispa/amos-project-management/src/views/projects-progress-detection-period/email/content',
                [
                    'text' => $text,
                    'model' => $model,
                ],
                $id);

            $email = new Email();
            $email->sendMail(
                $from,
                $to,
                $subjectRendered,
                $textRendered,
                [], [], [], 0, false);

            $to = [];
        }
    }
}
