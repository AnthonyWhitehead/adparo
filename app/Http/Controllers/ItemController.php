<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\EditItemRequest;
use App\Models\Item;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
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
     * Update the specified resource in storage.
     *
     * @param EditItemRequest $request
     * @param Item $item
     * @return void
     */
    public function update(EditItemRequest $request, Item $item)
    {
        $item->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return void
     * @throws Exception
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
