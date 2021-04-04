<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ChangeStatus;

class UserController extends Controller
{

   public function getAllAuthors(Request $request){
        try {
            
            $authors = User::join('user_roles', 'user_roles.user_id', 'users.id')
                            ->where('user_roles.role_id', '=' , '2') //author roles
                            ->select('users.*');

            if(isset($request->is_active) && $request->is_active != ''){
                $authors = $authors->where('is_active', '=', $request->is_active);
            }

            $authors = $authors->get();

            return response()->json([
                'error' => false,
                'data' => $authors
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message'  => 'Internal Server Error.'
            ], 500);
        }
   }

   public function changeStatus(ChangeStatus $request, $id){

        try {
            $user = User::find($id);
            $user->is_active = $request->status;
            $user->save();

            return response()->json([
                'error' => false,
                'message' => 'Statu Updated'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message'  => 'Internal Server Error.'
            ], 500);
        }

       
   }

}
