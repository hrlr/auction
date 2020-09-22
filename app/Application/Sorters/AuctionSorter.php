<?php


namespace App\Application\Sorters;


use Illuminate\Database\Query\Builder;

class AuctionSorter extends AbstractSorter
{
    public function applySort(Builder $query) {
        if ($this->request->has('sort')) {
            $query->orderby($this->request->column, $this->request->direction);
            session()->put('auction_column', $this->request->column);
            session()->put('auction_direction', $this->request->direction);
        } else {
            if(session()->has('auction_column') && session()->has('auction_direction')) {
                $query->orderby(session()->get('auction_column'), session()->get('auction_direction'));
            } else {
                $query->orderby('auctionNumber', 'asc');
            }
        }

        return $query;
    }
}
