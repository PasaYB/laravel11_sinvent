<?php

namespace App\Http\Controllers\Api;

//import model Post
use App\Models\Barang;

use App\Http\Controllers\Controller;

//import resource PostResource
use App\Http\Resources\BarangResource;

//import Http request
use Illuminate\Http\Request;

//import facade Validator
use Illuminate\Support\Facades\Validator;

//import facade Storage
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Barang::all();

        //return collection of posts as a resource
        return new BarangResource(true, 'List Data Barang', $posts);
    }
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'merk' => 'required|unique:barang,merk',
            'seri' => 'required|unique:barang,seri',
            'spesifikasi' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //create post
        $post = Barang::create([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        //return response
        return new BarangResource(true, 'Data Barang Berhasil Ditambahkan!', $post);
    }
   public function show($id)
    {
        //find post by ID
        $post = Barang::find($id);

        //return single post as a resource
        return new BarangResource(true, 'Detail Data Barang!', $post);
    }
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'merk' => 'required|unique:barang,merk,' . $id,
            'seri' => 'required|unique:barang,seri,' . $id,
            'spesifikasi' => 'required',
            'stok' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Barang::find($id);

        //return response
        return new BarangResource(true, 'Data Barang Berhasil Diubah!', $post);
    }
    
}
