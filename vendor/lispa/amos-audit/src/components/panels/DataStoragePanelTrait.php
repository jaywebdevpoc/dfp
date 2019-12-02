<?php

namespace lispa\amos\audit\components\panels;

/**
 * DataStoragePanelTrait
 * @package lispa\amos\audit\components\panels
 */
trait DataStoragePanelTrait
{
    use PanelTrait;

    /**
     * @inheritdoc
     */
    public function hasEntryData($entry)
    {
        $data = $entry->data;
        return isset($data[$this->id]);
    }
}