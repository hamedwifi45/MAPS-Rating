<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('reviews')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Review::create([
           'review' => "ممتاز جدًا ممتاز جدًا ممتاز جدًا ممتاز جدًا ممتاز جدًا ممتاز جدًا ممتاز جدًا",
           'service_rating' => 5,
           'quality_rating' => 5,
           'cleanliness_rating' => 5,
           'pricing_rating' => 5,
           'place_id' => 1,
           'user_id' => 1,
        ]);

        Review::create([
           'review' => "جيد جدًا جيد جدًا جيد جدًا جيد جدًا جيد جدًا جيد جدًا جيد جدًا جيد جدًا",
           'service_rating' => 5,
           'quality_rating' => 4,
           'cleanliness_rating' => 3,
           'pricing_rating' => 4,
           'place_id' => 1,
           'user_id' => 2,
        ]);

        Review::create([
            'review' => " جيد جيد جيد جيد جيد جيد جيد جيد جيد جيد جيد ",
            'service_rating' => 4,
            'quality_rating' => 1,
            'cleanliness_rating' => 3,
            'pricing_rating' => 3,
            'place_id' => 1,
            'user_id' => 3,
         ]);

         Review::create([
            'review' => "  جيد جدًاجيد جدًا جيد جدًا",
            'service_rating' => 5,
            'quality_rating' => 4,
            'cleanliness_rating' => 3,
            'pricing_rating' => 4,
            'place_id' => 2,
            'user_id' => 1,
         ]);
    }
}
