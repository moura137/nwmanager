<?php

namespace NwManager\Http\Controllers;

use Illuminate\Http\Request;
use NwManager\Http\Controllers\Controller;
use NwManager\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return Client::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Client::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());
        
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Client::findOrFail($id)->delete();

        return response()
                ->json(['error' => null], 204);
    }
}
