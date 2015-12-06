<?php

namespace Ease\Html;

/**
 * HTML Table cell class
 *
 * @author Vitex <vitex@hippy.cz>
 */
class TdTag extends Ease\Html\PairTag
{

    /**
     * Buňka tabulky
     *
     * @param mixed $content    vkládaný obsah
     * @param array $properties parametry tagu
     */
    public function __construct($content = null, $properties = null)
    {
        parent::__construct('td', $properties, $content);
    }

}
