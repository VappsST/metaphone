<?php

namespace Vapps\Metaphone;

use Vapps\Metaphone\Mapping\MapOfLists;

/**
 * \Analysis
 *
 * @package Vapps\Metaphone
 * @author Filipe Voges <filipe.voges@vapps.com.br>
 * @since 2018-08-02
 * @version 1.0
 */
class Analysis {

    public static function start() {

        $result = new MapOfLists();

        $files = [
            '',
            ''
        ];

        foreach($files as $file){
            $f = fopen ($file, 'r');
            while(!feof($f)){
                $line = fgets($f, 1024);
                $word = trim($line);
                $result->put(new MetaphonePtBrFrouxo($word)->__toString(), $word);
            }

        }

        return $result;

    }
}
