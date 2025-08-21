<?php

namespace common\enums;

enum EmploymentEnum: int
{
    case FULL_TIME    = 1; // полная занятость
    case WEEKEND_TIME = 2; // занятость по выходным
    // case PART_TIME    = 3; // частичная занятость

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
