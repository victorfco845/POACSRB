<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('jobs');
            $table->string('description');
            $table->timestamps();
        });

       

        $companys = [
            'ABC Corporation',
            'XYZ Ltd.',
            'Tech Innovators Inc.',
            'Global Solutions Co.',
            'Green Energy Enterprises',
            'Dynamic Tech Solutions',
            'Creative Minds Agency',
            'Pinnacle Industries',
            'Infinite Innovations',
            'Future Builders Ltd.',
            'EcoTech Ventures',
            'Strategic Solutions Group',
            'Visionary Technologies Inc.',
            'Swift Logistics Services',
            'Quantum Computing Systems',
            'Digital Harmony Ltd.',
            'Alpha Omega Software',
            'Peak Performance Consultants',
            'United Global Enterprises',
            'Golden Gate Marketing',
        ];

        $descriptions = [
            'Leading the way in innovation and technology.',
            'Your partner for success and growth.',
            'Transforming ideas into reality.',
            'Providing global solutions for a connected world.',
            'Dedicated to sustainable and eco-friendly practices.',
            'Bringing creativity and technology together.',
            'Your go-to agency for out-of-the-box solutions.',
            'Setting new standards in industry excellence.',
            'Innovating without limits.',
            'Building the future, one project at a time.',
            'Committed to a greener and cleaner planet.',
            'Strategizing for success in a dynamic world.',
            'Shaping the future of technology.',
            'Swift and reliable logistics for your business.',
            'Revolutionizing the way we compute.',
            'Where digital meets creativity.',
            'Software solutions from start to finish.',
            'Guiding businesses to peak performance.',
            'Connecting businesses across the globe.',
            'Marketing excellence for a golden future.',
        ];

        for ($i = 0; $i < count($companys); $i++) {
            DB::table('jobs')->insert([
                'jobs' => $companys[$i],
                'description' => $descriptions[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};