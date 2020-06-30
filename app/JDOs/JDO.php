<?php

namespace App\JDOs;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class JDO extends \PDOStatement
{
    protected $query = '';

    public function prepare($query)
    {
        $this->query = $query;

        return $this;
    }

    public function bindValue($parameter, $value, $data_type = 2 | 1)
    {
        return [];
    }

    public function execute($input_parameters = null): bool
    {
        $data = json_decode(ltrim($this->query, 'insert'), true);

        if ($data) {

            $jsonData = collect($data['values'])->map(function ($values) use ($data) {
                return array_combine($data['columns'], array_values($values));
            })->toJson();

            Storage::put('json_db/' . $data['into'] . '.json', $jsonData);
        }

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
        ])->when($selected[0] !== '*')->map(function ($item) use ($selected) {
            return Arr::only($item, array_merge(['id'], $selected));
        })->all();
    }
}
