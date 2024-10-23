<?php

namespace Mhughes2k\SemverExtended;


class Semver extends \Composer\Semver\Semver {
    /**
     * Sorts an array of mixed semver versions and non-semver strings.
     */
    public static function sort_mixed($array, $direction = SORT_ASC, $otherdirection = SORT_ASC) {
            // Sort by semver.
        $notSemver = [];
        $semver = [];
        $parser = new \Composer\Semver\VersionParser();
        foreach($array as $version) {
            try {
                $parser->normalize($version);
                $semver[] = $version;
            } catch (\UnexpectedValueException $e) {
                $notSemver[] = $version;
            }
        }
        if ($direction == SORT_ASC) {
            $semver = \Composer\Semver\Semver::sort($semver);
        } else {
            $semver = \Composer\Semver\Semver::rsort($semver);
        }
        if ($otherdirection == SORT_ASC) {
            natcasesort($notSemver);
        } else {
            natcasesort($notSemver);
            $notSemver = array_reverse($notSemver);
        }
        $versions = array_merge($semver, $notSemver);

        return $versions;
    }
    public static function ksort($array, $direction = SORT_ASC, $otherdirection = SORT_ASC) {
        // sort buildUses by semantic versioning.
        // Sort by semver.
        $newarray = [];
        $semverarray = self::sort_mixed(array_keys($array), $direction, $otherdirection);
        foreach($semverarray as $version) {
            $newarray[$version] = $array[$version];
        }
        return $newarray;
    }

}