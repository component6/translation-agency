<?php

namespace common\enums;

class EmployeeStatus
{
    const BLOCKED    = 0; // заблокирован
    const ACTIVE     = 1; // активен
    const NOT_ACTIVE = 2; // не активен

    private static $statuses = [
        self::BLOCKED    => 'blocked',
        self::ACTIVE     => 'active',
        self::NOT_ACTIVE => 'not_active',
    ];

    /**
     * @return array
     */
    public static function getValues(): array
    {
        return array_map(function($label) {
            return \Yii::t('app', $label);
        }, self::$statuses);
    }

    /**
     * @return array
     */
    public static function getAllowedValues(): array
    {
        return array_keys(self::$statuses);
    }
}
