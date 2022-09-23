<?php

/**
 * @file
 * Rector configuration file.
 *
 * For more info, please check: https://github.com/rectorphp/rector.
 */

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FunctionLike\MixedTypeRector;
use Rector\Php80\Rector\FunctionLike\UnionTypesRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {

  // Define sets of rules.
  // PHP 8.0 ruleset added.
  $rectorConfig->sets([
    LevelSetList::UP_TO_PHP_80,
  ]);
  // Define file extensions to pick up for processing.
  $rectorConfig->fileExtensions([
    'php',
    'install',
    'module',
    'inc',
    'theme',
  ]);
  // Define any specific rules you like to ignore from UP_TO_PHP_80 ruleset.
  // These changes are generally added to keep code consistency
  // with Drupal core or to avoid massive breaking changes in project.
  // These can vary project to project, should not be added initially.
  // Run rector and review the changes, then decide which rule should be
  // skipped for your project.
  $rectorConfig->skip([
    FinalizePublicClassConstantRector::class,
    InlineConstructorDefaultToPropertyRector::class,
    ClassPropertyAssignToConstructorPromotionRector::class,
    UnionTypesRector::class,
    ReadOnlyPropertyRector::class,
    TypedPropertyRector::class,
    ArraySpreadInsteadOfArrayMergeRector::class,
    MixedTypeRector::class,
    ThisCallOnStaticMethodToStaticCallRector::class,
    JsonThrowOnErrorRector::class,
    ChangeSwitchToMatchRector::class,
  ]);
};
