<?php

use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'qwe',
            'email' => 'qwe@qwe.qwe',
            'login' => 'qwe',
            'password' => '$2y$10$JAJIwL85OyHPzOkd8taA2uMd0AvHKzNedcXO7x9BZTvSMBlGmMjJ2',
        ]);


        DB::table('users_token')->insert([
            'user_id' => 1,
            'token' => 'NwzbA7680nRjCTXvhhgUEQ2wMmRpyNeBRUCoDIDeDLL6IfgPZKTOqJAEFvXg',
            'active' => true,
        ]);


        DB::table('courses')->insert([
            'name' => 'Животные',
            'language' => 'en',
            'created_user_id' => null
        ]);
        DB::table('courses')->insert([
            'name' => 'Страны',
            'language' => 'en',
            'created_user_id' => 1
        ]);


        DB::table('words')->insert([
            'course_id' => 1,
            'word' => 'Pig',
            'translation' => 'Свинья'
        ]);
        DB::table('words')->insert([
            'course_id' => 1,
            'word' => 'Cat',
            'translation' => 'Кошка'
        ]);
        DB::table('words')->insert([
            'course_id' => 1,
            'word' => 'Dog',
            'translation' => 'Собака'
        ]);


        DB::table('words')->insert([
            'course_id' => 2,
            'word' => 'Russia',
            'translation' => 'Россия'
        ]);
        DB::table('words')->insert([
            'course_id' => 2,
            'word' => 'Germany',
            'translation' => 'Германия'
        ]);
        DB::table('words')->insert([
            'course_id' => 2,
            'word' => 'France',
            'translation' => 'Франция'
        ]);


        DB::table('user_course')->insert([
            'course_id' => 2,
            'user_id' => 1,
        ]);
        DB::table('user_course')->insert([
            'course_id' => 1,
            'user_id' => 1,
        ]);
    }
}
