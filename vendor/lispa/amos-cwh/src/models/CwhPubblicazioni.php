<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\cwh
 * @category   CategoryName
 */

namespace lispa\amos\cwh\models;

use lispa\amos\core\record\Record;
use lispa\amos\cwh\AmosCwh;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;

/**
 * This is the model class for table "cwh_pubblicazioni".
 */
class CwhPubblicazioni extends \lispa\amos\cwh\models\base\CwhPubblicazioni
{

    public function aggiornaPubblicazione(Record $model)
    {
        $configContent                     = CwhConfigContents::findOne(['tablename' => $model->tableName()])->id;
        $this->content_id                  = $model->id;
        $this->cwh_config_contents_id      = $configContent;
        $this->cwh_regole_pubblicazione_id = $model->regola_pubblicazione;

        if ($this->validate()) {
            try {
                $this->save();

                if (property_exists($model, 'destinatari')) {
                    $this->aggiornaEditori($model->destinatari);
                }
                if (property_exists($model, 'validatori')) {
                    $this->aggiornaValidatori($model->validatori);
                }
            } catch (Exception $e) {
                throw new ErrorException(AmosCwh::t('amoscwh',
                    'Impossibile salvare la pubblicazione per il contenuto: {msgError}',
                    [
                    'msgError' => $e->getMessage()
                ]));
            }
        } else {
            throw new ErrorException(AmosCwh::t('amoscwh', 'Impossibile salvare la pubblicazione per il contenuto'));
        }
    }

    /**
     * delete all CwhPubblicczioniCwhNodiValidatoriMm associated to this CwhPubblicazioni
     */
    public function deleteValidators()
    {
        $validators = $this->cwhPubblicazioniCwhNodiValidatoriMms;
        if (!empty($validators)) {
            foreach ($validators as $validator) {
                $validator->delete();
            }
        }
    }

    /**
     * unlink and delete all CwhPubliccazioniCwhNodiEditoriMm associated to this CwhPubblicazioni
     */
    public function deleteEditors()
    {
        $editors = $this->cwhPubblicazioniCwhNodiEditoriMms;
        if (!empty($editors)) {
            foreach ($editors as $editor) {
                $editor->delete();
            }
        }
    }

    /**
     * @deprecated
     *
     * Old method used when publication id was a string content::tableName()-content->id eg. 'news-99'
     * This method will be removed.
     *
     * @param Record $model
     * @return string idPubblicazione
     */
    public static function getUniqueIdFor(Record $model)
    {
        return $model->tableName().'-'.$model->getPrimaryKey();
    }

    /**
     * @param array $editoriCollection - array of editor Ids
     */
    public function aggiornaEditori($editoriCollection)
    {
        $this->unlinkAll('destinatari', true);

        if ($editoriCollection) {
            $EditoriQuery = CwhNodi::find()->andWhere(['IN', 'id', $editoriCollection]);
            $Editori      = $EditoriQuery->all();
            foreach ($Editori as $Editore) {
                $this->link('destinatari', $Editore);
            }
        }
    }

    /**
     * @param array $validatoriCollection - array of validator Ids
     */
    public function aggiornaValidatori($validatoriCollection)
    {


        $this->unlinkAll('validatori', true);

        if ($validatoriCollection) {
            $ValidatoriQuery = CwhNodi::find()->andWhere(['IN', 'id', $validatoriCollection]);
            $Validatori      = $ValidatoriQuery->all();
            foreach ($Validatori as $Validatore) {
                $this->link('validatori', $Validatore);
            }
        }
    }
}