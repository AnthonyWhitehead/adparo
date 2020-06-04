<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Models\Item;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response(Item::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateItemRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(CreateItemRequest $request)
    {
        $item = new Item;

        try {
            $item->fill($request->all());

            $item->save();

            return response([
                'message' => 'Created new item'
            ]);

        } catch (Exception $e) {
            return response([
                'message' => 'Could not create item'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Item $item
     * @return Response
     */
    public function show(Item $item)
    {
        return response($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Item $item
     * @return void
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Item $item
     * @return void
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return void
     */
    public function destroy(Item $item)
    {
        //
    }
}
