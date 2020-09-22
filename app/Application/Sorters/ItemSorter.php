<?php


namespace App\Application\Sorters;


use Illuminate\Database\Query\Builder;

class ItemSorter extends AbstractSorter
{
    public function applySort(Builder $query) {
        if ($this->request->has('sort')) {
            $query->orderby($this->request->column, $this->request->direction);
            session()->put('item_column', $this->request->column);
            session()->put('item_direction', $this->request->direction);
        } else {
            if(session()->has('item_column') && session()->has('item_direction')) {
                $query->orderby(session()->get('item_column'), session()->get('item_direction'));
            } else {
                $query->orderby('itemNumber', 'asc');
            }
        }

        return $query;
    }

}
