<?php

namespace App\JDOs;

use Illuminate\Support\Arr;

class JDO extends \PDOStatement
{
    protected $query = '';

    public function prepare($query)
    {
        dump(compact('query'));
        $this->query = $query;

        return $this;
    }

    public function bindValue($parameter, $value, $data_type = 2 | 1)
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

    /**
     * @param null $fetch_style
     * @param null $fetch_argument
     * @param null $ctor_args
     * @return array|array[]
     */
    public function fetchAll($fetch_style = null, $fetch_argument = null, $ctor_args = null)
    {
        $selected = json_decode(ltrim($this->query, 'select'), true);

        return collect([
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
        ])->when($selected)->map(function ($item) use ($selected) {
            return Arr::only($item, array_merge(['id'], $selected));
        })->all();
    }
}
