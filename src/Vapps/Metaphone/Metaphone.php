<?php

namespace Vapps\Metaphone;

/**
 * \Metaphone
 *
 * Class to override the PHP function metaphone
 *
 * @package Vapps\Metaphone
 * @author Filipe Voges <filipe.voges@vapps.com.br>
 * @since 2018-08-02
 * @version 1.0
 */
abstract class Metaphone {

    /**
     * @var Patten
     */
    protected static $THE_MATCH = "$0";

    /**
     * @var Patten
     */
    protected static $VOWEL = "[aeiouy]";

    /**
     * @var Patten
     */
    protected static $NON_VOWEL = "[^aeiouy]";

    /**
     * @var String
     */
    private $original;

    /**
     * @var String
     */
    private $transformed;

    /**
     * @var String
     */
    private $result;

    /**
     * @var Integer
     */
    private $currentPosition;

    /**
     * @var Boolean
     */
    private $hadMatches = false;

    /**
     * @var String
     */
    private $currentMatch;

    public function __construct(string $str) {
        $this->original = $str;
        $this->transformed = $this->original;
        $this->result = '';
        $this->currentPosition = 0;
    }

    /**
     * Calculate the result
     *
     * @return Void
     */
    private function calculate() {
        if($this->isBlank()) return;

        $this->allLowerCase();
        replaceSpecialChars($this->transformed);
        $this->prepare();
        $this->addSpaceToBorders();

        while($this->isNotFullyProcessed() {
            $this->keep(" ");
            $this->algorithm();
            $this->ignoreNoMatches();
        }
    }

    protected abstract function prepare();

    protected abstract function algorithm();

    /**
     * Checks if the phoneme has been completely processed
     *
     * @return Boolean
     */
    private function isFullyProcessed(){
        return $this->currentPosition >= strlen($this->transformed);
    }

    /**
     * Checks if the phoneme has not been fully processed
     *
     * @return Boolean
     */
    private function isNotFullyProcessed(){
        return !$this->isFullyProcessed();
    }

    /**
     * Ignore those that are not results
     *
     * @return Void
     */
    private function ignoreNoMatches(){
        if(!$this->hadMatches) {
            $this->currentPosition += 1;
        }
        $this->hadMatches = false;
    }

    /**
     * translate the phoneme
     *
     * @param $pattern String
     * @param $subst String
     * @return Void
     */
    protected function translate(string $pattern, string $subst){
        if($this->FullyProcessed() || $this->hadMatches()) return;

        if(preg_match(".+\\(.*", $pattern)) {
            $this->lookBehind(substr($pattern, strpos($pattern, "(")));
            if($this->hadMatches()) $this->lookAhead(substr($pattern, strpos($pattern, "(")));
        }else{
            $this->lookAhead($pattern);
        }

        if(!$this->hadMatches()) return;

        $subst = (self::$THE_MATCH == $subst) ? $this->currentMatch() : $subst;
        $this->consume($this->currentMatch());
        $this->result .= strtoupper($subst);
    }

    /**
     * @param $match String
     * @return Void
     */
    private function consume(string $match) {
        $this->currentPosition += strlen($match);
    }

    /**
     * @param $pattern String
     * @return Void
     */
    protected function ignore(string $pattern) {
        $this->translate($pattern, "");
    }

    /**
     * @param $patterns ...String
     * @return Void
     */
    protected function keep(...$patterns) {
        translate("(" . $this->join("|", $patterns) . ")", self::$THE_MATCH);
    }

    /**
     * Concatenates many strings in just one
     *
     * @param $separator String
     * @param $elements ...String
     * @return String
     */
    private function join(string $separator,  ...$elements) {
        if(is_null($elements)) return "";
        if(empty($elements)) return "";
        $countElements = count($countElements);
        if($countElements == 1) return $elements[0];

        $result = '';
        $result .= $elements[0];

        for(int $i = 1; $i < $countElements; $i++) {
            $result .= $separator;
            $result .= $elements[i];
        }
        return $result;
    }

    /**
     * @return Boolean
     */
    private function hadMatches() {
        return $this->hadMatches;
    }

    /**
     * @return String
     */
    private function currentMatch() {
        return $this->currentMatch;
    }

    /**
     * Check if has a match
     *
     * @param $pattern String
     * @param $str String
     * @return Boolean
     */
    private function matches(string $pattern, string $str) {
        preg_match($pattern, $str, $hadMatches);

        if(!empty($hadMatches)) {
            $this->currentMatch = (count($hadMatches) > 0) ? $hadMatches[1] : $hadMatches[];
        }

        return $hadMatches;
    }

    /**
     * @param $pattern
     * @return Void
     */
    private function lookAhead(string $pattern) {
        $this->matches("^" + $pattern, $this->aheadString());
    }

    /**
     * @param $pattern
     * @return Void
     */
    private function lookBehind(string $pattern) {
        $this->matches($pattern + "$", $this->behindString());
    }

    /**
     * @return String
     */
    private function aheadString() {
        return substr($this->transformed, $this->currentPosition);
    }

    /**
     * @return String
     */
    private function behindString() {
        return substr($this->transformed, 0, $this->currentPosition);
    }

    /**
     * @return Boolean
     */
    private boolean isBlank(){
        return is_null($this->transformed) || empty($this->transformed);
    }

    /**
     * @return Void
     */
    protected function removeMultiples(...$letters) {
        foreach($letters as $letter)
            $this->transformed = str_replace($letter . $letter, $letter);
        }
    }

    /**
     * @return Void
     */
    private function addSpaceToBorders() {
        $this->transformed = " " + $this->transformed + " ";
    }

    /**
     * @return Void
     */
    private function allLowerCase() {
        $this->transformed = strtolower($this->transformed);
    }


    /**
     * @return String
     */
    public function __toString() {
        $this->calculate();
        return trim($this->result);
    }
}
