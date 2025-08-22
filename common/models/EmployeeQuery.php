<?php

namespace common\models;

use common\enums\EmployeeStatus;
use common\enums\EmploymentType;

/**
 * This is the ActiveQuery class for [[Employee]].
 *
 * @see Employee
 */
class EmployeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Scope для фильтрации записей по полю status.
     *
     * @param  array  $statuses
     * @return \yii\db\ActiveQuery
     */
    public function scopeStatuses(array $statuses = [EmployeeStatus::ACTIVE])
    {
        return $this->where(['status' => $statuses]);
    }

    /**
     * Scope для получения записей по полю employment_type.
     * Тип занятости = полная занятость
     *
     * @return \yii\db\ActiveQuery
     */
    public function scopeFullTimeEmploymentType()
    {
        return $this->where(['employment_type' => EmploymentType::FULL_TIME]);
    }

    /**
     * Scope для получения записей по полю employment_type.
     * Тип занятости = занятость по выходным
     *
     * @return \yii\db\ActiveQuery
     */
    public function scopeWeekendTimeEmploymentType()
    {
        return $this->where(['employment_type' => EmploymentType::WEEKEND_TIME]);
    }
}
