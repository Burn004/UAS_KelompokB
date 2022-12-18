<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; 

class PenggunaController extends Controller
{

 public function index(){
    $users = User::all(); 

    if(count($users) > 0){
        return response([
            'message' => 'Retrieve All Success',
            'data' => $users
        ], 200);
    } 

    return response([
        'message' => 'Empty',
        'data' => null
    ], 400); 
}

public function show($id){
    $users = User::find($id); 

    if(!is_null($users)){
        return response([
            'message' => 'Retrieve User Success',
            'data' => $users
        ], 200);
    } 

    return response([
        'message' => 'User Not Found',
        'data' => null
    ], 400); 
}


public function store(Request $request){
    $storeData = $request->all(); 
    $validate = Validator::make($storeData, [
        'name' => 'required|max:60',
        'email' => 'required|email:rfc,dns|unique:users',
        'nomorIdentitas' => 'required|unique:users',
        'username' => 'required|unique:users',
        'password' => 'required',
    ]); 

    if($validate->fails()){
        return response(['message' => $validate->errors()], 400); 
    }
    $storeData['password'] = bcrypt($request->password);
    $User = User::create($storeData);

    return response([
        'message' => 'Add User Success',
        'data' => $User
    ], 200);
}


public function destroy($id){
    $User = User::find($id); 

    if(is_null($User)){
        return response([
            'message' => 'User Not Found',
            'date' => null
        ], 404);
    } 

    if($User->delete()){
        return response([
            'message' => 'Delete User Success',
            'data' => $User
        ], 200);
    } 

    return response([
        'message' => 'Delete User Failed',
        'data' => null,
    ], 400);
}


public function update(Request $request, $id){
    $User = User::find($id); 

    if(is_null($User)){
        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    } 

    $updateData = $request->all();
    $validate = Validator::make($updateData, [
        'name' => 'required|max:60',
        'email' => 'required|email:rfc,dns|unique:users,email,'.$id,
        'nomorIdentitas' => 'required',
        'username' => 'required',
        'password' => 'required',
    ]); 

    if($validate->fails()){
        return response(['message' => $validate->errors()], 400); 
    }

    $User->name = $updateData['name']; 
    $User->email = $updateData['email'];
    $User->nomorIdentitas = $updateData['nomorIdentitas']; 
    $User->username = $updateData['username']; 
    $User->password = bcrypt($updateData['password']);

    if($User->save()){
        return response([
            'message' => 'Update User Success',
            'data' => $User
        ], 200);
    } 

    return response([
        'message' => 'Update User Failed',
        'data' => null
    ], 400);
}
}
