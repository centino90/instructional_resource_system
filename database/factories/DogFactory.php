<?php

namespace Database\Factories;

use App\Models\Dog;
use Illuminate\Database\Eloquent\Factories\Factory;

class DogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'types' => [
                'paragraphs' => [
                    'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, totam.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo a nisi, in magni velit sit culpa necessitatibus rerum eligendi voluptates ea ducimus, exercitationem, dicta aliquam.'
                ],
                'colors' => collect(['white', 'black', 'red'])->take(rand(1, 3))
            ]
        ];
    }
}