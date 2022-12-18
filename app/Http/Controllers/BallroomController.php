<?php

namespace App\Http\Controllers;

use App\Models\Ballroom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; 

class BallroomController extends Controller
{
 public function index(){
    $ballrooms = Ballroom::all(); 

    if(count($ballrooms) > 0){
        return response([
            'message' => 'Retrieve All Success',
            'data' => $ballrooms
        ], 200);

    return response([
        'message' => 'Empty',
        'data' => null
    ], 400); 
}

public function show($id){
    $ballrooms = Ballroom::find($id); 

    if(!is_null($ballrooms)){
        return response([
            'message' => 'Retrieve ballrooms Success',
            'data' => $ballrooms
        ], 200);
    }

    return response([
        'message' => 'Ballrooms Not Found',
        'data' => null
    ], 400);
}

public function store(Request $request){
    $storeData = $request->all();
    $validate = Validator::make($storeData, [
        'judulBuku' => 'required|max:60|regex:/^[\pL\s\-]+$/u',
        'isbn' => 'required|unique:bukus|numeric',
        'pengarang' => 'required',
        'tahunTerbit' => 'required|numeric|digits:4'
    ]); 

    if($validate->fails()){
        return response(['message' => $validate->errors()], 400);
    }

    $buku = Buku::create($storeData);

    return response([
        'message' => 'Add Buku Success',
        'data' => $buku
    ], 200); 
}


public function destroy($id){
    $buku = Buku::find($id); 

    if(is_null($buku)){
        return response([
            'message' => 'Buku Not Found',
            'date' => null
        ], 404);
    } 

    if($buku->delete()){
        return response([
            'message' => 'Delete Buku Success',
            'data' => $buku
        ], 200);
    } 

    return response([
        'message' => 'Delete Buku Failed',
        'data' => null,
    ], 400);
}


public function update(Request $request, $id){
    $buku = Buku::find($id); 

    if(is_null($buku)){
        return response([
            'message' => 'Buku Not Found',
            'data' => null
        ], 404);
    } 

    $updateData = $request->all();
    $validate = Validator::make($updateData, [
        'judulBuku' => 'required|max:60|regex:/^[\pL\s\-]+$/u',
        'isbn' => 'required|numeric',
        'pengarang' => 'required',
        'tahunTerbit' => 'required|numeric|digits:4'
    ]); 

    if($validate->fails()){
        return response(['message' => $validate->errors()], 400); 
    }

    $buku->judulBuku = $updateData['judulBuku']; 
    $buku->isbn = $updateData['isbn']; 
    $buku->tahunTerbit = $updateData['tahunTerbit']; 
    $buku->pengarang = $updateData['pengarang'];

    if($buku->save()){
        return response([
            'message' => 'Update Buku Success',
            'data' => $buku
        ], 200);
    }

    return response([
        'message' => 'Update Buku Failed',
        'data' => null
    ], 400);
}
}
