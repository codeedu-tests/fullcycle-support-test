<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Video;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Video::class, function (Faker $faker) {
    $rating = Video::RATING_LIST[array_rand(Video::RATING_LIST)];

    $videoFile =  new UploadedFile(
        storage_path('faker/thumbs/Laravel Framework.png'),
        'Laravel Framework.png'
    );

    $imageFile = new UploadedFile(
        storage_path('faker/videos/01-Como vai funcionar os uploads.mp4'),
        '01-Como vai funcionar os uploads.mp4'
    );

    return [
        'title'=>$faker->sentence(3),
        'description'=>$faker->sentence(10),
        'year_launched'=>rand(1895, 2022),
        'rating'=>$rating,
        'duration'=>rand(1, 30),
        'thumb_file'=>$imageFile,
        'banner_file'=>$imageFile,
        'trailer_file'=>$videoFile,
        'video_file'=>$videoFile,
    ];

});
