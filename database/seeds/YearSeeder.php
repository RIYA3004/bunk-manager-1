<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    public $yearNames = [
        'First Year', 
        'Second Year',
        'Third Year',
        'Fourth Year'
    ];
    public $yearAbbrevs = [
        'FY', 'SY', 'TY', 'LY'
    ];

    public function run()
    {
        for ($i = 0; $i < count($this->yearNames); $i++) {
            DB::table('years')->insert([
                'name' => $this->yearNames[$i],
                'abbreviation' => $this->yearAbbrevs[$i]
            ]);
        }
    }
}
