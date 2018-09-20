<?php

namespace Drupal\parser_sample\Myparser\TranslationStrategy;
/**
 * Translation strategy interface.
 */
interface TranslationStrategyInterface
{
    public function translate(array $tokens);
}
