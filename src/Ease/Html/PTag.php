<?php

namespace Ease\Html;

/**
 * HTML Paragraph class tag
 *
 * @subpackage
 * @author     Vitex <vitex@hippy.cz>
 */
class PTag extends PairTag
{

    /**
     * Odstavec
     *
     * @param mixed $content    vkládaný obsah
     * @param array $properties parametry tagu
     */
    public function __construct($content = null, $properties = null)
    {
        parent::__construct('p', $properties, $content);
    }

}
