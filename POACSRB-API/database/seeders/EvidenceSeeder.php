<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evidences = [
            [
                'evidence' => 'http://127.0.0.1:8000/storage/evidence/YLi5YYlij3GJb1bwM0UTo2FDOHsyhGx9bAHqRPKw.png',
                'report_id' => 1,
            ],
            [
                'evidence' => 'http://127.0.0.1:8000/storage/evidence/YLi5YYlij3GJb1bwM0UTo2FDOHsyhGx9bAHqRPKw.png',
                'report_id' => 2,
            ],
            [
                'evidence' => 'http://127.0.0.1:8000/storage/evidence/YLi5YYlij3GJb1bwM0UTo2FDOHsyhGx9bAHqRPKw.png',
                'report_id' => 3,
            ],
            [
                'evidence' => 'http://127.0.0.1:8000/storage/evidence/YLi5YYlij3GJb1bwM0UTo2FDOHsyhGx9bAHqRPKw.png',
                'report_id' => 4,
            ],
            [
                'evidence' => 'http://127.0.0.1:8000/storage/evidence/YLi5YYlij3GJb1bwM0UTo2FDOHsyhGx9bAHqRPKw.png',
                'report_id' => 5,
            ],
        ];

        foreach ($evidences as $evidence) {
            DB::table('evidences')->insert($evidence);
        }
    }
    
}
