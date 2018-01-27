<?php

namespace Circle314\Component\Collection;

use \ArrayIterator;
use Circle314\Component\Collection\Exception\CollectionExpectedClassMismatchException;
use Circle314\Component\Type\StringType;

/**
 * Abstract Collection
 * <p>
 * Extend this class to create an iterable object of either values or typed objects.
 * When extending, if your collection is of objects rather than values, ensure that you call the
 * setCollectionClass() method in the constructor before calling the parent constructor.
 * </p>
 * <p>
 * As this class extends ArrayIterator, values called by getID or foreach() are returned by reference,
 * rather than by value (as a native array type would).
 * </p>
 *
 * @package     Circle314\Component\Collection
 * @author      Kjartan Johansen <kjartan@artofwar.cc>
 * @copyright   Copyright (c) Kjartan Johansen
 * @license     https://www.apache.org/licenses/LICENSE-2.0
 * @link        https://github.com/circle314/collection
 */
abstract class AbstractCollection extends ArrayIterator implements CollectionInterface
{
    #region Properties
    /** @var StringType|null */
    private $collectionClass = null;
    #endregion

    #region Constructor
    /**
     * AbstractCollection constructor.
     *
     * Takes an array as a parameter, and converts that array into an iterable CollectionInterface object
     *
     * @param array|CollectionItemInterface[] $collectionItems The array of values or objects for the initial collection
     */
    public function __construct(Array $collectionItems = [])
    {
        $this->addCollectionItems($collectionItems);
    }
    #endregion

    #region Public Methods
    /**
     * {@inheritDoc}
     */
    final public function clearCollection()
    {
        while($this->valid()) {
            $this->rewind();
            $this->offsetUnset($this->key());
        }
    }
    #endregion

    #region Protected Methods
    /**
     * Returns the set collection class
     *
     * @return StringType|null
     */
    final protected function collectionClass()
    {
        return $this->collectionClass;
    }

    /**
     * Checks if a proposed collection item is the correct collection item class.
     *
     * @param mixed|CollectionItemInterface $collectionItem
     * @return bool
     */
    final protected function isCollectionClass($collectionItem)
    {
        if(is_null($this->collectionClass)) {
            return true;
        } else {
            return is_a($collectionItem, $this->collectionClass->getValue());
        }
    }

    /**
     * # Internal function - do not use
     * Sets the offset for the collection item safely. The reason we do this is because in PHP, the array keys 1 and '1' are identical.
     * So, if we have a new collection, and add two items with IDs 1 and 2, they will actually be keys 0 and 1 - if we then call getID(1) or saveID(1)
     * we get an unexpected return result.
     *
     * @internal
     * @param $ID
     * @return string
     */
    final protected function safeOffset($ID)
    {
        return CollectionConstants::_COLLECTION_KEY_PREFIX . (string)$ID;
    }

    /**
     * Sets the expected class for the collection's items.
     *
     * This is to be used when extending this class to create a collection of a specific type.
     * The method should be called in the constructor before calling the parent constructor, e.g:
     * ```
     * public function __construct(Array $collectionItems = [])
     * {
     *   $this->setCollectionClass(MyClass::class);
     *   parent::__construct($collectionItems);
     * }
     * ```
     *
     * @param $class string
     * @return void
     * @throws \Circle314\Component\Type\Exception\TypeValidationException
     * @throws \Circle314\Component\Type\Exception\ValueOutOfBoundsException
     */
    final protected function setCollectionClass($class)
    {
        $this->collectionClass = new StringType($class);
    }
    #endregion

    #region Abstract Methods
    /**
     * {@inheritDoc}
     * If the collection does not have a defined collectionClass, the value will be appended to the collection without a key.
     * If the collection has a defined collectionClass, the added collectionItem must be the correct type, otherwise an exception is thrown.
     *
     * @throws CollectionExpectedClassMismatchException
     */
    abstract public function addCollectionItem($collectionItem);

    /**
     * {@inheritDoc}
     */
    abstract public function addCollectionItems(Array $collectionItems);
    #endregion
}
