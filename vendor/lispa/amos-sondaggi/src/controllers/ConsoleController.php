<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\controllers
 * @category   CategoryName
 */

namespace lispa\amos\sondaggi\controllers;

use lispa\amos\admin\models\UserProfile;
use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\dashboard\controllers\TabDashboardControllerTrait;
use lispa\amos\sondaggi\AmosSondaggi;
use lispa\amos\sondaggi\models\Risposte;
use lispa\amos\sondaggi\models\search\SondaggiSearch;
use lispa\amos\sondaggi\models\Sondaggi;
use lispa\amos\sondaggi\models\SondaggiDomande;
use lispa\amos\sondaggi\models\SondaggiDomandeCondizionate;
use lispa\amos\sondaggi\models\SondaggiDomandePagine;
use lispa\amos\sondaggi\models\SondaggiRispostePredefinite;
use lispa\amos\sondaggi\models\SondaggiRisposteSessioni;
use lispa\amos\sondaggi\widgets\icons\WidgetIconSondaggiGeneral;
use lispa\amos\upload\models\FilemanagerMediafile;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

/**
 * Class SondaggiController
 * SondaggiController implements the CRUD actions for Sondaggi model.
 *
 * @property \lispa\amos\sondaggi\models\Sondaggi $model
 * @property \lispa\amos\sondaggi\models\search\SondaggiSearch $modelSearch
 *
 * @package lispa\amos\sondaggi\controllers
 */
class ConsoleController extends \yii\console\Controller
{

    /**
     * @param $id
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionExtract($id, $task_id = null)
    {
        $model   = Sondaggi::findOne($id);
        $xlsData = [];

// INTESTAZIONE EXCEL
        $xlsData[0]      = ["Nome", "Cognome", "Email", "Iniziato il", "Completato il"];
        $domande         = $model->getSondaggiDomandes()->orderBy('ordinamento ASC')->all();
        $count           = 1;
        $totCount        = 5;
        $colRisp         = [];
        $colRispLibere   = [];
        $colRispAllegati = [];
        foreach ($domande as $domanda) {
            $rispostePredefinite = $domanda->getSondaggiRispostePredefinites();
            $countRisposte       = $rispostePredefinite->count();
            $localCount          = 1;
            if (in_array($domanda->sondaggi_domande_tipologie_id, [10, 11])) {
                $xlsData[0][]                  = "D.".$count." ".$domanda->domanda;
                $colRispAllegati[$domanda->id] = $totCount;
                $totCount++;
            } else if (in_array($domanda->sondaggi_domande_tipologie_id, [5, 6])) {
                $xlsData[0][]                = "D.".$count." ".$domanda->domanda;
                $colRispLibere[$domanda->id] = $totCount;
                $totCount++;
            } else {
                if (!empty($countRisposte) && in_array($domanda->sondaggi_domande_tipologie_id, [1, 2, 3, 4])) {
                    foreach ($rispostePredefinite->orderBy('ordinamento ASC')->all() as $rispPre) {
                        $xlsData[0][]          = "D.".$count." ".$domanda->domanda."\nR.".$localCount." ".$rispPre->risposta;
                        $colRisp[$rispPre->id] = $totCount;
                        $localCount++;
                        $totCount++;
                    }
                }
            }
            $count ++;
        }


// CORPO FILE EXCEL
        $sondaggiRisposte = SondaggiRisposteSessioni::find()
            ->distinct()
            ->innerJoin('sondaggi_risposte',
                'sondaggi_risposte_sessioni.id = sondaggi_risposte.sondaggi_risposte_sessioni_id')
            ->leftJoin('user_profile', 'user_profile.user_id = sondaggi_risposte_sessioni.user_id')
            ->leftJoin('user', 'user_profile.user_id = user.id')
            ->andWhere(['sondaggi_risposte_sessioni.sondaggi_id' => $id])
            ->orderBy('sondaggi_risposte_sessioni.begin_date')
            ->all();

        $row = 1;

        foreach ($sondaggiRisposte as $sondRisposta) {
            $profile = null;
            if (!empty($sondRisposta->user_id)) {
                $profile = UserProfile::find()->andWhere(['user_id' => $sondRisposta->user_id])->one();
            }
            if (empty($profile)) {
                $xlsData [$row][0] = ($model->abilita_criteri_valutazione == 1 ? AmosSondaggi::t('amossondaggi',
                        'L\'utente non ha effettuato la registrazione') : AmosSondaggi::t('amossondaggi',
                        'L\'utente non è stato registrato'));
                $xlsData [$row][1] = ($model->abilita_criteri_valutazione == 1 ? AmosSondaggi::t('amossondaggi',
                        'L\'utente non ha effettuato la registrazione') : AmosSondaggi::t('amossondaggi',
                        'L\'utente non è stato registrato'));
                $xlsData [$row][2] = ($model->abilita_criteri_valutazione == 1 ? AmosSondaggi::t('amossondaggi',
                        'L\'utente non ha effettuato la registrazione') : AmosSondaggi::t('amossondaggi',
                        'L\'utente non è stato registrato'));
            } else {
                $xlsData [$row][0] = $profile->nome;
                $xlsData [$row][1] = $profile->cognome;
                $xlsData [$row][2] = $profile->user->email;
            }
            $xlsData [$row][3] = $sondRisposta->begin_date;
            $xlsData [$row][4] = $sondRisposta->end_date;
            $session_id        = $sondRisposta->id;


            /** @var  $domanda SondaggiDomande */
            foreach ($domande as $domanda) {

                $query = $domanda->getRispostePerUtente((empty($profile) ? null : $profile->user_id), $session_id);
// RISPOSTE LIBERE
                if ($domanda->sondaggi_domande_tipologie_id == 6 || $domanda->sondaggi_domande_tipologie_id == 5) {
//                    pr($query->one()->risposta_libera, 'D. ' . $domanda->id);
                    $risposta = $query->one();
                    if ($risposta) {                       
                        $xlsData[$row][$colRispLibere[$domanda->id]] = $risposta->risposta_libera;
                    } else {

                    }
//ALLEGATI
                } else if ($domanda->sondaggi_domande_tipologie_id == 10 || $domanda->sondaggi_domande_tipologie_id == 11) {
                    $risposta = $query->one();
                    if ($risposta) {
                        $attribute = 'domanda_'.$domanda->id;
                        if (!empty($risposta->$attribute)) {
                            $attachments    = $risposta->$attribute;
                            $listAttachUrls = [];
                            foreach ($attachments as $attach) {
                                $listAttachUrls [] = \Yii::$app->params['platform']['backendUrl'].$attach->getUrl();
                            }
                            $xlsData[$row][$colRispAllegati[$domanda->id]] = implode("\n", $listAttachUrls);
                        }
                    } else {

                    }
                } else {
                    $risposteArray = [];
                    foreach ($query->all() as $risposta) {
                        if ($risposta->sondaggiRispostePredefinite) {
                            $xlsData[$row][$colRisp[$risposta->sondaggiRispostePredefinite->id]] = $risposta->sondaggiRispostePredefinite->risposta;
                        }
                    }
                }
            }
            $row++;
            gc_collect_cycles();
        }

        /** @var  $domanda SondaggiDomande */
        $basePath    = \Yii::getAlias('@vendor/../common/uploads/temp');
//inizializza l'oggetto excel
        $nomeFile    = $basePath.'/Risposte_sondaggio_'.$id.'_'.$task_id.'.xls';
        $objPHPExcel = new \PHPExcel();

// set Style first row
        $lastColumn       = $totCount;
        $lastColumnLetter = \PHPExcel_Cell::stringFromColumnIndex($lastColumn);

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$lastColumnLetter.'1')->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setRGB('C0C0C0');

        for ($i = 1; $i <= $row; $i++) {
            for ($c = 0; $c <= $lastColumn; $c++) {
                if (empty($xlsData[$i]) || !array_key_exists($c, $xlsData[$i])) {
                    $xlsData[$i][$c] = '';
                }
            }
        }

        foreach ($xlsData as $key => $value) {
            ksort($xlsData[$key]);
        }

//li pone nella tab attuale del file xls
        $objPHPExcel->getActiveSheet()->fromArray($xlsData, NULL, 'A1');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($nomeFile);

        if (!is_null($task_id)) {
            $task = \lispa\amos\sondaggi\modules\v1\models\TaskSondaggi::findOne($task_id);
            if (!is_null($task)) {
                $task->filename = $nomeFile;
                $task->status   = 3;
                $task->save();
            }
        }
    }
}