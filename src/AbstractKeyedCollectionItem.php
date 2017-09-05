<?php

namespace Circle314\Component\Collection;

/**
 * Abstract Keyed Collection Item
 * Extend this class only if you require keyed collection items
 *
 * @package     Circle314\Component\Collection
 * @author      Kjartan Johansen <kjartan@artofwar.cc>
 * @copyright   Copyright (c) Kjartan Johansen
 * @license     https://www.apache.org/licenses/LICENSE-2.0
 * @link        https://github.com/circle314/collection
 */
abstract class AbstractKeyedCollectionItem extends AbstractCollectionItem implements KeyedCollectionItemInterface
{
    #region Abstract Methods
    /** {@inheritDoc} */
    abstract public function ID();
    #endregion
}