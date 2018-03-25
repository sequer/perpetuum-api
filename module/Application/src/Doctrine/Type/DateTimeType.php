<?php

namespace Application\Doctrine\Type;

use Doctrine;

class DateTimeType extends Doctrine\DBAL\Types\DateTimeType
{
    public function convertToDatabaseValue($value, Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        return $value->format('Y-m-d H:i:s.000');
    }
}
