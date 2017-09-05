<?php

namespace Circle314\Component\Collection;

use Circle314\Concept\Identification\IdentifiableInterface;
use Circle314\Component\Collection\Exception\CollectionExpectedClassMismatchException;
use Circle314\Component\Collection\Exception\CollectionIDNotFoundException;
use Circle314\Component\Collection\Exception\CollectionItemUnidentifiableException;

/**
 * {@inheritDoc}
 * <hr>
 * # Class AbstractKeyedCollection
 * <p>
 * This abstract class requires keyed collection items or associative arrays to be supplied in the constructor
 * and for the addCollectionItems() method, and keyed
 * </p>
 *
 * @package     Circle314\Component\Collection
 * @author      Kjartan Johansen <kjartan@artofwar.cc>
 * @copyright   Copyright (c) Kjartan Johansen
 * @license     https://www.apache.org/licenses/LICENSE-2.0
 * @link        https://github.com/circle314/collection
 */
abstract class AbstractKeyedCollection extends AbstractCollection implements KeyedCollectionInterface
{
    #region Public Methods
    /**
     * {@inheritDoc}
     *
     * If the collection does not have a defined collectionClass, the value will be appended to the collection without a key.
     * If the collection has a defined collectionClass, the added collectionItem must be the correct type, otherwise an exception is thrown.
     *
     * @param IdentifiableInterface $collectionItem
     * @throws CollectionExpectedClassMismatchException
     * @throws CollectionItemUnidentifiableException
     */
    final public function addCollectionItem($collectionItem)
    {
        if(is_null($this->collectionClass()) || !is_a($collectionItem, IdentifiableInterface::class)) {
            throw new CollectionItemUnidentifiableException('Attempted to add a collection item to ' . static::class . ' without providing an identifier.');
        } else {
            if($this->isCollectionClass($collectionItem)) {
                $this->offsetSet($this->safeOffset($collectionItem->ID()), $collectionItem);
            } else {
                throw new CollectionExpectedClassMismatchException('Attempted to add class ' . get_class($collectionItem) . ' to ' . static::class . '. Expected concrete class of type ' . $this->collectionClass()->getValue() . '.');
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    final public function addCollectionItems(Array $collectionItems)
    {
        if(is_null($this->collectionClass())) {
            foreach($collectionItems as $ID => $collectionItem) {
                $this->offsetSet($this->safeOffset($ID), $collectionItem);
            }
        } else {
            foreach($collectionItems as $collectionItem) {
                $this->addCollectionItem($collectionItem);
            }
        }
    }

    /**
     * {@inheritDoc}
     *
     * If the key cannot be found in the collection, an exception is thrown.
     *
     * @throws CollectionIDNotFoundException
     * @return void
     */
    public function deleteID($ID)
    {
        if($this->offsetExists($this->safeOffset($ID))) {
            $this->offsetUnset($this->safeOffset($ID));
        } else {
            throw new CollectionIDNotFoundException('ID "' . $ID . '" does not exist in collection');
        }
    }

    /**
     * {@inheritDoc}
     *
     * Tests whether a key exists in the collection
     *
     * @param mixed $ID
     * @return bool
     */
    public function hasID($ID)
    {
        return !is_null($ID) && $this->offsetExists($this->safeOffset($ID));
    }

    /**
     * {@inheritDoc}
     *
     * If the key cannot be found in the collection, an exception is thrown.
     *
     * @throws CollectionIDNotFoundException
     */
    public function getID($ID)
    {
        if($this->hasID($ID)) {
            return $this->offsetGet($this->safeOffset($ID));
        } else {
            throw new CollectionIDNotFoundException('ID "' . $ID . '" does not exist in collection');
        }
    }

    /**
     * {@inheritDoc}
     *
     * Saves a collection item
     *
     * @param mixed $ID The ID of the collection item
     * @param mixed $item The value of the collection item
     */
    public function saveID($ID, $item)
    {
        $this->addCollectionItems([
            $ID => $item
        ]);
    }
    #endregion
}
