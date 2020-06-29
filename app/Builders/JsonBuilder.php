<?php

namespace App\Builders;

use Illuminate\Database\Query\Builder;

class JsonBuilder extends Builder
{
    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $this->columns = [];
        $this->bindings['select'] = [];
        $columns = is_array($columns) ? $columns : func_get_args();

        foreach ($columns as $as => $column) {
            if (is_string($as) && $this->isQueryable($column)) {
                $this->selectSub($column, $as);
            } else {
                $this->columns[] = $column;
            }
        }

        dd('STOP');
        return $this;
    }

}
