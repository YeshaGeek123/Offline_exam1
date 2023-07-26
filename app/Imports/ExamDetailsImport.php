<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class ExamDetailsImport implements WithMultipleSheets
{
    use WithConditionalSheets;
    
    private $request;

    public function __construct($request) 
    {
        $this->request = $request;
    }

    public function conditionalSheets(): array
    {
        return [
            0 => new FirstSheetImport($this->request),
            1 => new SecondSheetImport(),
            2 => new ThirdSheetImport(),
            3 => new FourthSheetImport(),
            4 => new FifthSheetImport()
        ];
    }
}
