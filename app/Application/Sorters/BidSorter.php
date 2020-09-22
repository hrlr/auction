<?php


namespace App\Application\Sorters;


use Illuminate\Database\Query\Builder;

class BidSorter extends AbstractSorter
{
    public function applySort(Builder $query) {
        if ($this->request->has('sort')) {
            $query->orderby($this->request->column, $this->request->direction);
            session()->put('bid_column', $this->request->column);
            session()->put('bid_direction', $this->request->direction);
        } else {
            if(session()->has('bid_column') && session()->has('bid_direction')) {
                $query->orderby(session()->get('bid_column'), session()->get('bid_direction'));
            } else {
                $query->orderby('bidTime', 'desc');
            }
        }

        return $query;
    }
}
