<?php

namespace common\enums;

class TaskStatus
{
    const NEW         = 'new';         // Новая
    const IN_PROGRESS = 'in_progress'; // В работе
    const TESTING     = 'testing';     // На проверке
    const DONE        = 'done';        // Выполнена
    const CANCELED    = 'canceled';    // Отменена

    private static $statuses = [
        self::NEW         => self::NEW,
        self::IN_PROGRESS => self::IN_PROGRESS,
        self::TESTING     => self::TESTING,
        self::DONE        => self::DONE,
        self::CANCELED    => self::CANCELED,
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
        return array_values(self::$statuses);
    }
}
