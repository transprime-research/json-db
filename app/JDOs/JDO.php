<?php

namespace App\JDOs;

class JDO extends \PDOStatement
{
    public function prepare($query)
    {
        dump(compact('query'));
        return $this;
    }

    public function bindValue($parameter, $value, $data_type = 2|1)
    {
        dump(compact('parameter', 'value', 'data_type'));
    }

    public function execute($input_parameters = null): bool
    {
        dump(compact('input_parameters'));
        return true;
    }

    public function lastInsertId()
    {
        return 1;
    }

    public function fetchAll($fetch_style = null, $fetch_argument = null, array $ctor_args = null)
    {
        dump(compact('fetch_style', 'fetch_argument', 'ctor_args'));

        return [
            [
                'id' => 1,
                'name' => 'Ninja',
                'created_at' => '2020-01-02 11:12:00',
                'updated_at' => '2020-01-02 11:12:00',
            ],
            [
                'id' => 2,
                'name' => 'Ninja 2',
                'created_at' => '2020-01-02 11:12:00',
                'updated_at' => '2020-01-02 11:12:00',
            ],
        ];
    }
}
