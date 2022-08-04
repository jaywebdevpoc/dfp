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

namespace lispa\amos\risultati\models;

use lispa\amos\cwh\query\CwhActiveQuery;

/**
 * Class ProtezioneInnovazioneRisultatiQuery
 * @package lispa\amos\risultati\models * File generato automaticamente, verificarne
 * il contenuto prima di utilizzarlo in produzione
 */
class ProtezioneInnovazioneRisultatiQuery extends CwhActiveQuery
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
        return $this->innerJoin('protezioneinnovazionerisulta_stato', 'protezioneinnovazionerisultati.protezioneinnovazionerisulta_stato_id = protezioneinnovazionerisulta_stato.id AND protezioneinnovazionerisulta_stato.nome = :stato_nome', [
            ':stato_nome' => 'Attiva'
        ]);
    }
}