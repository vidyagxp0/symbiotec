<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing records
        DocumentType::truncate();

        // Seed new records
        $documentTypes = [
            ['name' => 'Quality Control', 'departmentid' => 1, 'typecode' => 'QC'],
            ['name' => 'Production – Plant 01', 'departmentid' => 2, 'typecode' => 'PP01'],
            ['name' => 'Production – Plant 03', 'departmentid' => 3, 'typecode' => 'PP03'],
            ['name' => 'Production – C1', 'departmentid' => 4, 'typecode' => 'PC1'],
            ['name' => 'Production – Plant 02', 'departmentid' => 5, 'typecode' => 'PP02'],
            ['name' => 'Production Biotechnology – Plant 02', 'departmentid' => 6, 'typecode' => 'PB02'],
            ['name' => 'Commercial', 'departmentid' => 7, 'typecode' => 'CM'],
            ['name' => 'Microbiology', 'departmentid' => 8, 'typecode' => 'MB'],
            ['name' => 'Regulatory Affairs', 'departmentid' => 9, 'typecode' => 'RA'],
            ['name' => 'Warehouse', 'departmentid' => 10, 'typecode' => 'WH'],
            ['name' => 'Quality Assurance', 'departmentid' => 11, 'typecode' => 'QA'],
            ['name' => 'Engineering and Maintenance', 'departmentid' => 12, 'typecode' => 'EG'],
            ['name' => 'Personnel and Administration/ Human Resource/ Corporate Human Resource', 'departmentid' => 13, 'typecode' => 'PA/HR/CHR'],
            ['name' => 'General Production SOP', 'departmentid' => 14, 'typecode' => 'GN'],
            ['name' => 'Information Technology', 'departmentid' => 15, 'typecode' => 'IT'],
            ['name' => 'Central Information Technology', 'departmentid' => 16, 'typecode' => 'CIT']
        ];

        foreach ($documentTypes as $type) {
            $documentType = new DocumentType();
            $documentType->name = $type['name'];
            $documentType->departmentid = $type['departmentid'];
            $documentType->typecode = $type['typecode'];
            $documentType->save();
        }
    }
}
