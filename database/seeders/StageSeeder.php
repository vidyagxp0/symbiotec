<?php

namespace Database\Seeders;
use App\Models\Stage;
use App\Models\RecordNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $stage = new Stage();
        $stage->name = "Draft";
        $stage->save();

        $stage = new Stage();
        $stage->name = "In Review";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Reviewer Cycle-I";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Final Review";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Initiator Update";
        $stage->save();

        $stage = new Stage();
        $stage->name = "In-Approval";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Approval Cycle-I";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Final Approval";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Training Pending";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Training Started";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Training Complete";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Effective";
        $stage->save();

        $stage = new Stage();
        $stage->name = "Obsolete";
        $stage->save();

        $stage = new RecordNumber();
        $stage->counter = 0;
        $stage->save();
    }
}
