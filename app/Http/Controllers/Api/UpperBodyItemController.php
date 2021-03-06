<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UpperBodyItem;

class UpperBodyItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'items' => UpperBodyItem::all(),
            'status' => 'success'
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($upperbodyItem)
    {
        return response()->json([
            'item' => UpperBodyItem::find($upperbodyItem),
            'status' => 'success'
            ], 200);
    }
}
