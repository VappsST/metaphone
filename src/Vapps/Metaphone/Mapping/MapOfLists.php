<?php

namespace Vapps\Metaphone\Mapping;

use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\TreeSet;

/**
 * \MapOfLists
 *
 * Class to Mapping the lists of names
 *
 * @package Vapps\Metaphone\Mapping
 * @author Filipe Voges <filipe.voges@vapps.com.br>
 * @since 2018-08-02
 * @version 1.0
 */
class MapOfLists {

    /**
     * @var \chdemko\SortedCollection\TreeMap
     */
    private $content = new TreeMap();

    /**
     * Add a Value in $content
     *
     * @param $key String
     * @param $value String
     * @return Void
     */
    public function put(string $key, string $value) {
        $list = $this->content->find($key);
        if(is_null($list)) {
            $list = new SplDoublyLinkedList();
            $this->content->put($key, $list);
        }
        $list->add($key, $value);
    }

    /**
     * @return Mixed
     */
    public function iterator() {
        $set = new TreeSet();
        $set->addAll($this->content->entrySet());
        return $set->iterator();
    }
}
