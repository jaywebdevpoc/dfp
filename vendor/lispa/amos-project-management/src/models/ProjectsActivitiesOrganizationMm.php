<?php

namespace lispa\amos\projectmanagement\models;

use Yii;
use yii\helpers\ArrayHelper;

//use backend\modules\cwh\behaviors\CwhNetworkBehaviors;
//use backend\modules\eventi\models\query\EventiQuery;
//use raoul2000\workflow\base\SimpleWorkflowBehavior;

/**
 * This is the model class for table "projects_activities_organization_mm".
 */
class ProjectsActivitiesOrganizationMm extends \lispa\amos\projectmanagement\models\base\ProjectsActivitiesOrganizationMm
{
//const _WORKFLOW = 'DiscussioniTopicWorkflow';

//public $regola_pubblicazione;
//public $destinatari;
//public $validatori;


    /*public function init()
        {
            parent::init();
            if ($this->isNewRecord) {
                $this->status = $this->getWorkflowSource()->getWorkflow(self::_WORKFLOW)->getInitialStatusId();
            }
        }*/

    public function representingColumn()
    {
        return [
//inserire il campo o i campi rappresentativi del modulo
            'organization_id',
        ];
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
//[['regola_pubblicazione', 'destinatari', 'validatori'], 'safe'],
        ]);
    }

    public function attributeLabels()
    {
        return
            ArrayHelper::merge(
                parent::attributeLabels(),
                [
//'tagValues' => '',
//'regola_pubblicazione' => 'Pubblicata per',
//'destinatari' => 'Per i condominii',
                ]);
    }
    /*
    public function behaviors()
    {
    return ArrayHelper::merge(parent::behaviors(), [
        'CwhNetworkBehaviors' => [
        'class' => CwhNetworkBehaviors::className(),
    ],
    [
        'class' => SimpleWorkflowBehavior::className(),
        'defaultWorkflowId' => self::_WORKFLOW,
        'propagateErrorsToModel' => true,
    ]
    ]);
    }

    public static function find()
    {
    $ProjectsactivitiesorganizationmmQuery = new ProjectsactivitiesorganizationmmQuery(get_called_class());
    $ProjectsactivitiesorganizationmmQuery->andWhere('projectsactivitiesorganizationmm.deleted_at IS NULL');
    return $ProjectsactivitiesorganizationmmQuery;
    }
    */

    /**
     * Restituisce il percorso del marker, da personalizzare a piacimento
     * @return string Il percorso del marker che sar?? utilizzato nella mappa
     */
    public function getIconaMarker()
    {
        return null;
    }

    /**
     * Restituisce il colore della categoria
     */
    public function getColoreCategoria()
    {
        return null; //da personalizzare
    }

    /**
     * Restituisce il nome della categoria per la legenda
     */
    public function getNomeLegenda()
    {
        return null; //da personalizzare
    }

    /**
     * Funzione che crea gli eventi da visualizzare sulla mappa in caso di pi?? eventi legati al singolo model
     * Andr?? valorizzato il campo array a true nella configurazione della vista calendario nella index
     */
    public function getEvents()
    {
        return null; //da personalizzare
    }

    /**
     * Restituisce l'url per il calendario dell'attivit??
     */
    public function getUrlEvento()
    {
        return null; //da personalizzare magari con Yii::$app->urlManager->createUrl([]);
    }

    /**
     * Restituisce il colore associato all'evento
     */
    public function getColoreEvento()
    {
        return null; //da personalizzare
    }

    /**
     * Restituisce il titolo, possono essere anche pi?? dati, associato all'evento
     */
    public function getTitoloEvento()
    {
        return null; //da personalizzare
    }

    /**
     * Restituisce un'immagine se associata al model
     */
    public function getAvatarUrl($dimension = 'small')
    {
        $url = '/img/img_default.jpg';
//funzione da implementare
        return $url;
    }

    /**
     *   Restituisce il testo da inserire nella visualizzazione a icona (una specie di descrizione)
     */
    public function getTestoIcon()
    {
//da personalizzare, ?? necessario adattare anche la view _icon definendo un'altezza fissa
//o usando flexbox / display table. Se si usa un'altezza fissa
//troncare il testo in pi??
        return null;
    }

    /**
     *   Restituisce il testo da inserire nella visualizzazione a Lista
     */
    public function getTestoItem()
    {
//da personalizzare
        return null;
    }

    /**
     *   Restituisce il numero di telefono di default
     */
    public function getTelefonoDefault()
    {
//da personalizzare
        return null;
    }

    /**
     *   Restituisce l'email di default
     */
    public function getEmailDefault()
    {
//da personalizzare
        return null;
    }

    /**
     *   Restituisce il campo dei contatti in comune per la view Icon
     */
    public function getContattiComune()
    {
//da personalizzare
        return null;
    }

}
