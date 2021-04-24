<?php declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

final class PublicIpv6 extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            static function (
                string $attribute,
                $value
            ) {
                return filter_var(
                    $value,
                    FILTER_VALIDATE_IP,
                    FILTER_FLAG_IPV6 | FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE
                ) !== false;
            },
            'The :attribute field must be a valid public IPv6 address.'
        );
    }
}
