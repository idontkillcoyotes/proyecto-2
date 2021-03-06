<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Avatar;
use App\User;

class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * RESTFULL: GET ALL
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Obtengo el bearer token que envie en el header
        $api_token = $request->bearerToken();

        // Obtengo el user
        $user = auth()->user();        

        // Comparo si coinciden los tokens
        if($api_token != $user->api_token){
            // Si no coinciden los tokens
            $datos = [
                'status' => 'failed',
                'data' => [],
            ];
        }
        else{
            // Coinciden los tokens
            $datos = [
                'status' => 'success',
                'data' => [
                    'user' => $user,
                    'avatars' =>  $user->avatars,
                ]
            ];
        }
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * RESTFULL: POST ALL
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Obtengo el bearer token que envie en el header
         $api_token = $request->bearerToken();

         // Obtengo el user
         $user = auth()->user();        
 
         // Comparo si coinciden los tokens
         if($api_token != $user->api_token){
             // Si no coinciden los tokens
             $json = [
                 'status' => 'failed',
             ];
             return response()->json($datos, 401);
         }
         else{
            // Coinciden los tokens
            // Valido la entrada
            $datos = $request->validate([
                'name' => 'string|max:32',
            ]);

            // Creo nuevo avatar
            $avatar = new Avatar;
            $avatar->name = $datos['name'];
            $avatar->body_id= $request->get('body_id');
            $avatar->head_id= $request->get('head_id');
            $avatar->upperbody_id= $request->get('upperbody_id');
            $avatar->lowerbody_id= $request->get('lowerbody_id');
            $avatar->extra_id= $request->get('extra_id');
            
            // Guardo avatar
            $user->avatars()->save($avatar);
            
            $json = [
                'status' => 'success',
                'data' => [
                    'avatar' => ($avatar->getAttributes()),
                    ]
                ];
            return response()->json($json, 200);
         }
    }

    /**
     * Display the specified resource.
     *
     * RESTFULL: GET 1
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => User::find($user)->avatars()->find($id)->getAttributes(),
        ],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * RESTFULL: PATCH
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        // Obtengo el bearer token que envie en el header
        $api_token = $request->bearerToken();

        // Obtengo el user
        $user = auth()->user();        

        // Comparo si coinciden los tokens
        if($api_token != $user->api_token){
            // Si no coinciden los tokens
            $json = [
                'status' => 'failed',
            ];
            return response()->json($datos, 401);
        }
        else{
           // Coinciden los tokens
           // Valido la entrada
           
           $datos = $request->validate([
               'name' => 'string|max:32',
           ]);

           // TODO: Deberia checkear que los id coinciden? 

           // Obtengo avatar y edito
           $avatar=$user->avatars()->find($id);
           $avatar->name = $datos['name'];
           $avatar->body_id= $request->get('body_id');
           $avatar->head_id= $request->get('head_id');
           $avatar->upperbody_id= $request->get('upperbody_id');
           $avatar->lowerbody_id= $request->get('lowerbody_id');
           $avatar->extra_id= $request->get('extra_id');
           
           // Guardo avatar
           $user->avatars()->save($avatar);
           
           $json = [
               'status' => 'success',
               'data' => [
                   'avatar' => ($avatar->getAttributes()),
                   ]
               ];
           return response()->json($json, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * RESTFULL: DELETE
     * 
     * @param  int  $id
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        // Obtengo el bearer token que envie en el header
        $api_token = $request->bearerToken();

        // Obtengo el user
        $user = auth()->user();        

        // Comparo si coinciden los tokens
        if($api_token != $user->api_token){
            // Si no coinciden los tokens
            $json = [
                'status' => 'failed',
            ];
            return response()->json($datos, 401);
        }
        else{
           // Coinciden los tokens

           // Obtengo avatar
           $avatar=$user->avatars()->find($id);

           // Elimino
           $avatar->delete();
           
           $json = [
               'status' => 'success',
               ];
           return response()->json($json, 200);
        }
    }
}
