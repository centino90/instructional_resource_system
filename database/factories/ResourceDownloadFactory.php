<?php

namespace Database\Factories;

use App\Models\Resource;
use App\Models\ResourceDownload;
use App\Models\ResourceDownloads;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceDownloadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResourceDownload::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'resource_id' => Resource::all()->random(),
            'user_id' => User::all()->random(),
        ];
    }
}
