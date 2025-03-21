<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //check if the token allow the result
        if(!auth()->user()->tokenCan('clients:list')) {
            return ApiResponse::error('Access denied', 401);
        }

        //return all clients in the database
        //return response()->json(Client::all(), 200);
        return ApiResponse::success(Client::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required'
        ]);

        //add a new client to the database
        $client = Client::create($request->all());

        /*return response()->json(
            [
                'message' => 'Client created successfully',
                'data' => $client
            ], 200
        );*/
        return ApiResponse::success($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //check if the token allow the result
        if(!auth()->user()->tokenCan('clients:detail')) {
            return ApiResponse::error('Access denied', 401);
        }

        //show client details
        $client = Client::find($id);

        //return a response
        if($client) {
            //return response()->json($client, 200);
            return ApiResponse::success($client);
        } else {
            //return response()->json(['message' => 'Client not found'], 404);
            return ApiResponse::error('Client not found');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,' . $id,
            'phone' => 'required'
        ]);

        //update the client data in database
        $client = Client::find($id);
        if($client) {
            $client->update($request->all());
            /*return response()->json(
                [
                    'message' => 'Client update successfully',
                    'data' => $client
                ], 200
            );*/
            return ApiResponse::success($client);
        } else {
            //return response()->json(['message' => 'Client not found'], 404);
            return ApiResponse::error('Client not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete the client
        $client = Client::find($id);
        if($client) {
            $client->delete();
            /*return response()->json(
                [
                    'message' => 'Client deleted successfully'
                ], 200
            );*/
            return ApiResponse::success('Client deleted successfully');
        } else {
            //return response()->json(['message' => 'Client not found'], 404);
            return ApiResponse::error('Client not found');
        }
    }
}
