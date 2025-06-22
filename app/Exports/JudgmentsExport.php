<?php

namespace App\Exports;

use App\Models\JudgementSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class JudgmentsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return JudgementSummary::with('court')->select('title', 'judgement_date', 'court_id')->get();
    }

    /**
     * Define column headings
     */
    public function headings(): array
    {
        return ['Title', 'Court', 'Date'];
    }

    /**
     * Format each row of the data
     */
    public function map($judgement_summary): array
    {
        return [
            $judgement_summary->title,
            $judgement_summary->court->court ?? 'In the Court of Appeal', // Get court name or fallback value
            Carbon::parse($judgement_summary->judgement_date)->format('D, M d Y') // Format date
        ];
    }
}
