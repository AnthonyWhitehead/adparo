<?php

namespace Tests\Feature;

use Illuminate\Support\Arr;
use Tests\TestCase;

class ItemTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItCanStoreItem()
    {
        $this->refreshDatabase();

        $user = $this->createUser();

        $assignee = $this->createUser();

        $uniqueTitle = 'it can store';

        $response = $this->actingAs($user, 'api')->json('post', route('item_store',
            [
                'type' => Arr::random(config('item.types')),
                'title' => $uniqueTitle,
                'effort' => Arr::random(config('item.effort_points')),
                'description' => $this->faker->paragraph(),
                'status' => Arr::random(config('item.statuses')),
                'acceptance_criteria' => $this->faker->paragraph(),
                'assignee_id' => $assignee->id,
                'reporter_id' => $user->id,
                'priority' => 1
            ],
            [
                'Content-type' => 'application/json'
            ]
        ));

        $response->assertOk();
        $this->assertDatabaseHas('items', [
            'title' => $uniqueTitle
        ]);
    }
}
