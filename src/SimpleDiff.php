<?php
namespace CodeDruids;

use Exception;

/**
 *  Paul's Simple Diff Algorithm v 0.1
 *  (C) Paul Butler 2007 <http://www.paulbutler.org/>
 *  May be used and distributed under the zlib/libpng license.
 *
 *  Original by github/paulgb
 *  Includes fixes from github/angrychimp
 *  Class wrapper, updates, docs and tests by github/CodeDruids
*/
class SimpleDiff
{
    /**
     * Given two arrays, return an array of the changes.
     *
     * @param  array $old  Original array to compare to
     * @param  array $new  New array to compare against
     *
     * @return array       Original array, with differing elements replaced by an array showing deletions & insertions
     *
     * @throws Exception   When inputs are invalid
     */
    public static function diff($old, $new)
    {
        if (empty($old) && empty($new)) {
            return [];
        }
        if (!is_array($old)) {
            throw new Exception('Invalid input - $old must be an array');
        }
        if (!is_array($new)) {
            throw new Exception('Invalid input - $new must be an array');
        }

        $matrix = [];
        $maxlen = 0;
        foreach ($old as $oindex => $ovalue) {
            $nkeys = array_keys($new, $ovalue);
            foreach ($nkeys as $nindex) {
                $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
                if ($matrix[$oindex][$nindex] > $maxlen) {
                    $maxlen = $matrix[$oindex][$nindex];
                    $omax = $oindex + 1 - $maxlen;
                    $nmax = $nindex + 1 - $maxlen;
                }
            }
        }
        if ($maxlen == 0) {
            return [['deleted' => $old, 'inserted' => $new]];
        }

        return array_merge(
            self::diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
            array_slice($new, $nmax, $maxlen),
            self::diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
        );
    }

    /**
     * Wrapper for the diff command to return the differences in HTML.
     *
     * The tags used for the diff are <ins> and <del>, which can easily be styled with CSS.
     * Using PREG_SPLIT_DELIM_CAPTURE ensures whitespace is diffed as well.
     *
     * @param  string $old  Original string to compare to
     * @param  string $new  New string to compare against
     *
     * @return string       Combination of both strings with <ins> and <del> tags to indicate differences
     */
    public static function htmlDiff($old, $new)
    {
        $ret = '';
        $diff = self::diff(
            preg_split("/([\s]+)/", $old, null, PREG_SPLIT_DELIM_CAPTURE),
            preg_split("/([\s]+)/", $new, null, PREG_SPLIT_DELIM_CAPTURE)
        );
        foreach ($diff as $k) {
            if (is_array($k)) {
                foreach (['deleted', 'inserted'] as $v) {
                    $$v = '';
                    if (!empty($k[$v])) {
                        $$v = implode('', $k[$v]);
                        if ($$v != '') {
                            $tag = substr($v, 0, 3);
                            $$v = "<$tag>".$$v."</$tag>";
                        }
                    }
                }
                $ret .= $deleted.$inserted;
            } else {
                $ret .= $k;
            }
        }
        return $ret;
    }
}
