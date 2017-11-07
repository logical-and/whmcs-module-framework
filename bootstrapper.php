<?php

use Webmozart\Assert\Assert;
use Webmozart\PathUtil\Path;
use SymlinkDetective as Symlink;

return function($marker = null) {
    $vendorsDir = '';

    $whmcsInitialized = defined('ROOTDIR');

    // Load symlink and deps
    if (!class_exists(Assert::class)) {
        require_once __DIR__ . '/../../webmozart/assert/src/Assert.php';
    }
    if (!class_exists(Path::class)) {
        require_once __DIR__ . '/../../webmozart/path-util/src/Path.php';
    }
    if (!class_exists(Symlink::class)) {
        require_once __DIR__ . '/../symlink-detective/src/SymlinkDetective.php';
    }

    $dirLookup = function($startDirectory, array $commonPaths = [], callable $testAgainst) {
        $foundPath = '';
        $startDirectory = rtrim($startDirectory, '/');

        foreach ($commonPaths as $path) {
            $path = ltrim($path, '/');
            $path = Symlink::detectPath("$startDirectory/$path");
            if (is_file($path)) {
                $path = dirname($path);
            }
            if ($testAgainst($path)) {
                $foundPath = $path;
                break;
            }
        }

        if ($foundPath) {
            return $foundPath;
        }

        // Go up until find that
        $dir = $startDirectory . '/a';
        while ($dir = dirname($dir)) {
            $dir = rtrim($dir, '/');
            if ($testAgainst($dir)) {
                $foundPath = $dir;
                break;
            }
        }


        if ($foundPath) {
            return $foundPath;
        }

        return false;
    };

    // Determine dependencies directory

    // Determine the plugin directory
    if (!$marker) {
        $marker = $dirLookup(dirname(Symlink::detectPath(__FILE__)), [
            '/../../../vendor/'
        ], function($dir) {
            return is_file("$dir/autoload.php");
        });
        if (!$marker) {
            throw new ErrorException('Cannot determine marker file');
        }
    }
    // Can be file (/addon/plugin-name/hooks.php
    if (is_file($marker)) {
        $marker = dirname($marker);
    }
    // Directory with vendors (/addon/plugin-name)
    if (is_dir($marker)) {
        if (is_dir("$marker/vendor")) {
            $marker = "$marker/vendor";
        }
    }
    // Vendors directory (/addon/plugin-name/vendor)
    if (is_file("$marker/autoload.php")) {
        $vendorsDir = $marker;
    }

    if (!$vendorsDir or !is_dir($vendorsDir)) {
        throw new ErrorException('Cannot determine vendor directory');
    }
    $vendorsDir = rtrim($vendorsDir, '/');

    if ($whmcsInitialized) {
        /** @noinspection PhpIncludeInspection */
        require_once "$vendorsDir/autoload.php";

        // No need to proceed
        return;
    }

    // Determine root directory
    $rootDir = $dirLookup($vendorsDir, [
        // modules/addon/plugin-name/vendor
        "/../../../init.php"
    ], function($dir) {
        $dir = rtrim($dir, '/');

        return is_file("$dir/init.php") and is_file("$dir/vendor/whmcs.composer.lock");
    });

    if (!$rootDir) {
        throw new ErrorException('Cannot determine WHMCS root directory');
    }

    // Load WHMCS autoloader before (static files issue)
    /** @noinspection PhpIncludeInspection */
    require_once "$rootDir/vendor/autoload.php";
    // Deps
    /** @noinspection PhpIncludeInspection */
    require_once "$vendorsDir/autoload.php";
    // Load WHMCS
    /** @noinspection PhpUnusedLocalVariableInspection */
    global $whmcs;
    /** @noinspection PhpIncludeInspection */
    require_once "$rootDir/init.php";
};