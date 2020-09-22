<?php


namespace App\Application\Sorters;


use Illuminate\Database\Query\Builder;

class UserSorter extends AbstractSorter
{
    public function applySort(Builder $query) {
        if ($this->request->has('sort')) {
            $query->orderby($this->request->column, $this->request->direction);
            session()->put('user_column', $this->request->column);
            session()->put('user_direction', $this->request->direction);
        } else {
            if(session()->has('user_column') && session()->has('user_direction')) {
                $query->orderby(session()->get('user_column'), session()->get('user_direction'));
            } else {
                $query->orderby('userNumber', 'asc');
            }
        }

        return $query;
    }

}
