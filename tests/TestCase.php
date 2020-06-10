<?php

namespace Tests;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker, RefreshDatabase, DatabaseMigrations;

    /**
     * @return Collection|Model|mixed
     *
     * Create a user from User factory
     */
    public function createUser()
    {
        return factory(User::class)->create();
    }

    /**
     * @return Collection|Model|mixed
     *
     * Create an Item from Item factory
     */
    public function createItem()
    {
        return factory(Item::class)->create();
    }
}
