<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VisitorsExport implements FromQuery, WithHeadings
{
    /**
     * Build the query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Visitor::query();
    }

    /**
     * Add headings dynamically from the table columns.
     *
     * @return array
     */
    public function headings(): array
    {
        return \Schema::getColumnListing('visitors');
    }
}
