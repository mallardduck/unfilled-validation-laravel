<?php

namespace MallardDuck\OpinionatedValidator;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class OpinionatedValidatorServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Factory $baseValidator */
        $baseValidator = app('validator');
        foreach (OpinionatedRuleManager::allRules() as $ruleType => $rules) {
            foreach ($rules as $key => $rule) {
                $rule = new $rule;
                if ('rules' === $ruleType) {
                    $baseValidator->extend($rule->name, $rule->callback);
                }
                if ('implicit' === $ruleType) {
                    $baseValidator->extendImplicit($rule->name, $rule->callback);
                }
                if ('dependent' === $ruleType) {
                    $baseValidator->extendDependent($rule->name, $rule->callback);
                }
                $baseValidator->replacer($rule->name, $rule->resolver);
            }
        }
    }
}
