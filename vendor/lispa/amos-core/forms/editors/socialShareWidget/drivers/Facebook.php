<?php
/**
 */

namespace lispa\amos\core\forms\editors\socialShareWidget\drivers;
use ymaker\social\share\base\Driver;


/**
 * Driver for Facebook.
 *
 *
 * @since 1.0
 */
class Facebook extends Driver
{


    /**
     * @inheritdoc
     */
    public function getLink()
    {
        $this->_link = 'http://www.facebook.com/sharer.php?u={url}';
//        $this->_link =  'share?urlRedirect='.static::encodeData('http://www.facebook.com/sharer.php?u=').'{url}';


        return parent::getLink();
    }

    /**
     * @inheritdoc
     */
    protected function processShareData()
    {
        $this->url         = static::encodeData($this->remove_http($this->url));
        $this->description = static::encodeData($this->title);
        $this->imageUrl    = static::encodeData($this->imageUrl);
        $this->description = static::encodeData($this->description);
    }

    protected function remove_http($url)
    {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }

}
