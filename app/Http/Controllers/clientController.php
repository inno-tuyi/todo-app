<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class clientController extends Controller
{
    //


    public function createClient(Request $request){

       $client=  DB::insert('INSERT INTO oauth_clients (user_id,name,redirect) 
         values (?, ?,?)', [auth()->user()->id,$request->name, $request->url]);

        if($client) {
            return response()->json(
            ["message"=>"client created successfully", $client=>$client]);

        }

    }
}
