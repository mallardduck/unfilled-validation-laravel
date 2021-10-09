<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

final class ExtendedValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * @var Factory $baseValidator
         */
        $baseValidator = app('validator');
        assert($baseValidator instanceof Factory);
        foreach (RuleManager::allRules() as $ruleType => $rules) {
            foreach ($rules as $key => $rule) {
                /**
                 * @var \MallardDuck\ExtendedValidator\Rules\BaseRule $rule
                 */
                $rule = new $rule();
                if ($ruleType === 'rules') {
                    $baseValidator->extend(
                        $rule->getName(),
                        $rule->getCallback(),
                        $rule->getMessage()
                    );
                }
                if ($ruleType === 'dependent') {
                    $baseValidator->extendDependent(
                        $rule->getName(),
                        $rule->getCallback(),
                        $rule->getMessage()
                    );
                }
                if ($rule->hasReplacer()) {
                    $baseValidator->replacer($rule->getName(), $rule->getReplacer());
                }
            }
        }
    }
}
