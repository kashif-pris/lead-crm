<?php

namespace App\Exports;

use App\Models\Leads;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExportLeads implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Leads::select('created_at','name','phone','email')->get();
    }
    public function headings() :array
    {
        return [
            'Date',
            'name',
            'phone',
            'email'

        ];
    }
}
