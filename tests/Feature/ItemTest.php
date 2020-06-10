<?php

namespace Tests\Feature;

use Illuminate\Support\Arr;
use Tests\TestCase;

class ItemTest extends TestCase
{

    public function testItCanStoreItem()
    {
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

    public function testItCanUpdateItem()
    {
        $user = $this->createUser();
        $assignee = $this->createUser();
        $reporter = $this->createUser();

        $item = $this->createItem();
        $item->reporter_id = $user->id;
        $item->type = config('item.types')[0];
        $item->effort = config('item.effort_points')[0];
        $item->status = config('item.statuses')[0];

        $this->assertDatabaseHas('items', [
            'title' => $item->title
        ]);

        $originalItemAttributes = collect($item->getAttributes())->reject(function ($attr, $key) {
            return $key === 'updated_at' || $key === 'created_at' || $key === 'id';
        });

        $requestFields = collect([
            'type' => config('item.types')[1],
            'title' => $this->faker->word(),
            'effort' => config('item.effort_points')[1],
            'description' => $this->faker->paragraph(),
            'status' => config('item.statuses')[1],
            'acceptance_criteria' => $this->faker->paragraph(),
            'assignee_id' => $assignee->id,
            'reporter_id' => $reporter->id,
            'priority' => 1
        ]);


        $response = $this->actingAs($user, 'api')
            ->json('patch', route('item_update', ['item' => $item->id]),
                $requestFields->toArray(),
                ['Content-type' => 'application/json']
            );

        $response->assertOk();

        $requestFields->map(function ($value, $key) {
            $this->assertDatabaseHas('items', [
                $key => $value
            ]);
        });

        $originalItemAttributes->map(function ($value, $key) {
            $this->assertDatabaseMissing('items', [
                $key => $value
            ]);
        });
    }

    public function testItCanDeleteItem()
    {

        $this->refreshDatabase();
        $user = $this->createUser();
        $item = $this->createItem();

        $this->assertDatabaseHas('items', [
            'title' => $item->title
        ]);

        $response = $this->actingAs($user, 'api')->json('delete', route('item_destroy', ['item' => $item->id]),
            ['Content-type' => 'application/json']
        );

        $response->assertOk();
        $this->assertDatabaseMissing('items', [
            'title' => $item->title
        ]);
    }
}
