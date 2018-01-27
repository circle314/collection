<?php

namespace Circle314\Component\Collection;

/**
 * Abstract CollectionI tem
 * Extend this class only if you require unkeyed collection items
 *
 * @package     Circle314\Component\Collection
 * @author      Kjartan Johansen <kjartan@artofwar.cc>
 * @copyright   Copyright (c) Kjartan Johansen
 * @license     https://www.apache.org/licenses/LICENSE-2.0
 * @link        https://github.com/circle314/collection
 */
abstract class AbstractCollectionItem implements CollectionItemInterface
{
    #region Properties
    /** @var mixed The value for the collection item */
    protected $value;
    #endregion

    #region Constructor
    /**
     * AbstractCollectionItem constructor.
     *
     * @param mixed $value The value of the collection item
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
    #endregion

    #region Magic Methods
    /**
     * Returns a string representation of the collection item.
     *
     * @return mixed
     */
    public function __toString()
    {
        return (string)$this->value;
    }
    #endregion
}
