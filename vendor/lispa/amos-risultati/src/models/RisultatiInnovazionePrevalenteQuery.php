<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace backend\modules\corsi\models;

use lispa\amos\cwh\query\CwhActiveQuery;

/**
 * Class Risultati Innovazione PrevalenteQuery
 * @package backend\modules\corsi\models * File generato automaticamente, verificarne
 * il contenuto prima di utilizzarlo in produzione
 */
class RisultatiInnovazionePrevalenteQuery extends CwhActiveQuery
{
    /**
     * @return array
     * da scommentare se si utilizzano i tag
     */
    //public function behaviors()
    //{
    //    return ArrayHelper::merge(
    //        parent::behaviors(), [
    //            TaggableQueryBehavior::className()
    //        ]
    //    );   
    //}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function attive()
    {
        //Questo è solo un esempio, verificare che i campi e le tabelle siano corretti
        return $this->innerJoin('risultatiInnovazionePrevalente_stato', 'risultatiInnovazionePrevalente.risultatiInnovazionePrevalente_stato_id = risultatiInnovazionePrevalente_stato.id AND risultatiInnovazionePrevalente_stato.nome = :stato_nome', [
            ':stato_nome' => 'Attiva'
        ]);
    }
}