<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use YearSeeder;
use Tests\TestCase;

class YearTableTest extends TestCase
{   
    use RefreshDatabase;

    public function testYearTableShouldContainData() {
        // Run the Year Seeder
        $this->seed(YearSeeder::class);

        // Check if the years table contain following data
        $this->assertDatabaseHas('years', [
            'name' => 'First Year',
            'abbreviation' => 'FY'
        ]);
    }

    public function testYearTableShouldNotContainData() {
        // Run the Year Seeder
        $this->seed(YearSeeder::class);

        // Check if the years table does not contain following data
        $this->assertDatabaseMissing('years', [
            'name' => 'Fifth Year',
            'abbreviation' => 'BY'
        ]);
    }
}
