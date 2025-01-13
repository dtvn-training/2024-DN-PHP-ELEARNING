<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_82);

    $rectorConfig->sets([
        SetList::PHP_82, // PHP 8.2 modernizations
        SetList::CODE_QUALITY, // General code quality improvements
        SetList::TYPE_DECLARATION, // Add type declarations
        SetList::DEAD_CODE, // Remove unused code
    ]);

    $rectorConfig->importNames();
    $rectorConfig->removeUnusedImports();

    $rectorConfig->skip([
        __DIR__ . '/storage',
        __DIR__ . '/vendor',
        '*.blade.php',
    ]);

    $rectorConfig->parallel();
};
