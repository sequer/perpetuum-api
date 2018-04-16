<?php

namespace Application\Doctrine\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use DateTime;

class DateTimeExtractStrategy implements StrategyInterface
{
    public function extract($value)
    {
        if (!$value instanceof DateTime) {
            return $value;
        }

        return $value->format('Y-m-d H:i:s');
    }

    public function hydrate($value)
    {
        //
    }
}
