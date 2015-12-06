<?php

namespace Ease\Html;

/**
 * HTML unsorted list
 *
 * @author Vitex <vitex@hippy.cz>
 */
class UlTag extends Ease\Html\PairTag
{

    /**
     * Vytvori UL container
     *
     * @param mixed $ulContents položky seznamu
     * @param array $properties parametry tagu
     */
    public function __construct($ulContents = null, $properties = null)
    {
        parent::__construct('ul', $properties, $ulContents);
    }

    /**
     * Vloží pole elementů
     *
     * @param array $itemsArray pole hodnot nebo EaseObjektů s metodou draw()
     */
    public function addItems($itemsArray)
    {
        $itemsAdded = array();
        foreach ($itemsArray as $item) {
            $itemsAdded[] = $this->addItemSmart($item);
        }
        return $itemsAdded;
    }

    /**
     * Every item id added in Ease\Html\LiTag envelope
     *
     * @param mixed  $pageItem     obsah vkládaný jako položka výčtu
     * @param string $properties   Vlastnosti LI tagu
     *
     * @return mixed
     */
    function &addItemSmart($pageItem, $properties = null)
    {
        if (is_array($pageItem)) {
            foreach ($pageItem as $item) {
                $this->addItemSmart($item);
            }
            $itemAdded = & $this->lastItem;
        } else {
            if (isset($pageItem->tagType) && $pageItem->tagType == 'li') {
                $itemAdded = parent::addItem($pageItem);
            } else {
                $itemAdded = parent::addItem(new Ease\Html\LiTag($pageItem, $properties));
            }
        }
        return $itemAdded;
    }

}
