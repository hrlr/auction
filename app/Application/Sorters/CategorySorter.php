<?php


namespace App\Application\Sorters;


use Illuminate\Database\Query\Builder;

class CategorySorter extends AbstractSorter
{
    public function applySort(Builder $query) {
        if ($this->request->has('sort')) {
            $query->orderby($this->request->column, $this->request->direction);
            session()->put('category_column', $this->request->column);
            session()->put('category_direction', $this->request->direction);
        } else {
            if(session()->has('category_column') && session()->has('category_direction')) {
                $query->orderby(session()->get('category_column'), session()->get('category_direction'));
            } else {
                $query->orderby('categoryNumber', 'asc');
            }
        }

        return $query;
    }

}
