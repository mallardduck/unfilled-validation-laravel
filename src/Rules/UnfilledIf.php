<?php

namespace MallardDuck\UnfilledValidator\Rules;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use MallardDuck\UnfilledValidator\ValidatorProxy;

final class UnfilledIf extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                $validator->requireParameterCount(1, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::fromValidator($validator);

                [$values, $other] = $validatorProxy->prepareValuesAndOther($parameters);

                if (in_array($other, $values, true)) {
                    return ! $validator->validateRequired($attribute, $value);
                }

                return true;
            },
            function (
                $stringTemplate,
                $currentField,
                $rule,
                $ruleArgs,
                $validator
            ) {
                [$other, $value] = $ruleArgs;
                $results = Str::replaceFirst(':other', $other, $stringTemplate);
                $results = Str::replaceFirst(':value', $value, $results);

                return $results;
            }
        );
    }
}
