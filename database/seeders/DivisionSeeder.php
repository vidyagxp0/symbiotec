<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\QMSDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $division = new QMSDivision();
        $division->name = "Corporate Quality Assurance (CQA)";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Plant 1";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Plant 2";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Plant 3";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "Plant 4";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->name = "C1";
        $division->status = 1;
        $division->save();
    }
}
