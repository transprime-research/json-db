<?php

namespace App\JDOs;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                $data['values'] = array_values($values);
                $data['values'][] = $this->getNextId($data['into']);
                $data['columns'][] = $this->getKeyName();

                return array_combine($data['columns'], $data['values']);
            })->merge($this->getAllData($data['into']))->values()->toJson();

            Storage::put('json_db/' . $data['into'] . '.json', $jsonData);
        }

        return true;
    }

    private function getFilePath(string $table)
    {
        return 'json_db/' . $table . '.json';
    }

    private function getNextId(string $table)
    {
        return Str::random();
    }

    private function getKeyName()
    {
        return 'id';
    }

    public function lastInsertId()
    {
        return 1;
    }

    private function getAllData(?string $table, array $selected = ['*'])
    {
        $fileData = json_decode(Storage::get($this->getFilePath($table ?: 'users')), true);

        return collect($fileData)
            ->when($selected[0] !== '*')
            ->map(function ($item) use ($selected) {
                return Arr::only($item, array_merge(['id'], $selected));
            })
            ->all();
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

        return $this->getAllData(null, $selected);
    }
}
