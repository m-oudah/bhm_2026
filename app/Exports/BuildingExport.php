<?php

namespace App\Exports;

use App\Models\Building;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BuildingExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $buildings = Building::all();
        return $buildings;
    }

    public function map($buildings): array
    {
        return [
            $buildings->id,
            $buildings->building_number,
            $buildings->block_number,
//            $buildings->user->name,
//            Date::dateTimeToExcel($invoice->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'User',
            'Date',
        ];
    }
}
