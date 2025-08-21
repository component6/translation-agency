<?php

namespace common\enums;

class EmploymentType
{
    const FULL_TIME    = 1; // полная занятость
    const WEEKEND_TIME = 2; // занятость по выходным
    // const PART_TIME    = 3; // частичная занятость

    private static $types = [
        self::FULL_TIME    => 'full_time',
        self::WEEKEND_TIME => 'weekend_time',
        // self::PART_TIME    => 'part_time',
    ];

    /**
     * @return array
     */
    public static function getValues(): array
    {
        return array_map(function($label) {
            return \Yii::t('app', $label);
        }, self::$types);
    }

    /**
     * @return array
     */
    public static function getAllowedValues(): array
    {
        return array_keys(self::$types);
    }
}
