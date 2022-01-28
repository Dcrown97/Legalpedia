<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return User::orderBy('name', 'ASC');
    }

    public function map($user): array
    {
        $data = [
            $user->name,
            $user->email,
            $user->phone,
            $user->dob,
            $user->area_of_practice,
            $user->referee,
            $user->call_to_bar_year,
            $user->city,
            $user->state,
            $user->country,
        ];
        return $data;
    }

    public function headings(): array
    {
        $data = [
            'Full name',
            'Email',
            'Phone number',
            'DOB',
            'Area of practice',
            'Referee',
            'Call to bar Year',
            'City',
            'State',
            'Country',
        ];
        return $data;
    }
}
