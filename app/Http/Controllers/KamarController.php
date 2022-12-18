<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; 

class KamarController extends Controller
{

public function index(){
      $kamars = Kamar::all(); 

      if(count($kamars) > 0){
          return response([
              'message' => 'Retrieve All Success',
              'data' => $kamars
          ], 200);
      } 

      return response([
          'message' => 'Empty',
          'data' => null
      ], 400); 
  }

  public function show($id){
      $kamars = Kamar::find($id); 

      if(!is_null($kamars)){
          return response([
              'message' => 'Retrieve Buku Success',
              'data' => $kamars
          ], 200);
      } 

      return response([
          'message' => 'Buku Not Found',
          'data' => null
      ], 400); 
  }

 
  public function store(Request $request){
      $storeData = $request->all(); 
      $validate = Validator::make($storeData, [
          'jenis' => 'required',
          'jumlah' => 'required|numeric',
          'harga' => 'required|numeric',
      ]); 

      if($validate->fails()){
          return response(['message' => $validate->errors()], 400); 
      }

      $kamar = Kamar::create($storeData);

      return response([
          'message' => 'Add Buku Success',
          'data' => $kamar
      ], 200); 
  }


  public function destroy($id){
      $kamar = Kamar::find($id); 

      if(is_null($kamar)){
          return response([
              'message' => 'Buku Not Found',
              'date' => null
          ], 404);
      }

      if($kamar->delete()){
          return response([
              'message' => 'Delete Buku Success',
              'data' => $kamar
          ], 200);
      } 

      return response([
          'message' => 'Delete Buku Failed',
          'data' => null,
      ], 400);
  }

  
  public function update(Request $request, $id){
      $kamar = Kamar::find($id); 

      if(is_null($kamar)){
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
