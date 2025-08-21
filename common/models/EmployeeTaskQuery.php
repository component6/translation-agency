<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[EmployeeTask]].
 *
 * @see EmployeeTask
 */
class EmployeeTaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmployeeTask[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeTask|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
