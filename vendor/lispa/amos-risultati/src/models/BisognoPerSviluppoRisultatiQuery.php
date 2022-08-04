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
 * Class BisognoPerSviluppoRisultatiQuery
 * @package backend\modules\risultati\models * File generato automaticamente, verificarne
 * il contenuto prima di utilizzarlo in produzione
 */
class BisognoPerSviluppoRisultatiQuery extends CwhActiveQuery
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
        return $this->innerJoin('bisognopersvilupporisultati_stato', 'bisognopersvilupporisultati.bisognopersvilupporisultati_stato_id = bisognopersvilupporisultati_stato.id AND bisognopersvilupporisultati_stato.nome = :stato_nome', [
            ':stato_nome' => 'Attiva'
        ]);
    }
}