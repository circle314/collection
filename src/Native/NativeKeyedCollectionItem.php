<?php

namespace Circle314\Component\Collection\Native;

use Circle314\Component\Collection\AbstractKeyedCollectionItem;

/**
 * Native Keyed Collection Item
 *
 * @package     Circle314\Component\Collection
 * @author      Kjartan Johansen <kjartan@artofwar.cc>
 * @copyright   Copyright (c) Kjartan Johansen
 * @license     https://www.apache.org/licenses/LICENSE-2.0
 * @link        https://github.com/circle314/collection
 */
class NativeKeyedCollectionItem extends AbstractKeyedCollectionItem
{
    #region Properties
    /** @var mixed */
    private $ID;
    #endregion

    #region Constructor
    /**
     * {@inheritDoc}
     * @param mixed $ID The identifier for the collection item
     */
    public function __construct($ID, $value)
    {
        $this->ID = $ID;
        parent::__construct($value);
    }
    #endregion

    #region Public Methods
    /** {@inheritDoc} */
    final public function ID()
    {
        return $this->ID;
    }
    #endregion
}
