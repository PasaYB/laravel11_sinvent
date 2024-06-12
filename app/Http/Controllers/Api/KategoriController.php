<?php

namespace App\Http\Controllers\Api;

//import model Post
use App\Models\Kategori;

use App\Http\Controllers\Controller;

//import resource PostResource
use App\Http\Resources\KategoriResource;

//import Http request
use Illuminate\Http\Request;

//import facade Validator
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Kategori::all();

        //return collection of posts as a resource
        return new KategoriResource(true, 'List Data Kategori', $posts);
    }
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'deskripsi'              => 'required',
            'kategori'              => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //create post
        $post = Kategori::create([
            'deskripsi'          => $request->deskripsi,
            'kategori'          => $request->kategori,
        ]);

        //return response
        return new KategoriResource(true, 'Data Kategori Berhasil Ditambahkan!', $post);
    }
    public function show($id)
    {
        //find post by ID
        $post = Kategori::find($id);

        //return single post as a resource
        return new KategoriResource(true, 'Detail Data Kategori!', $post);
    }
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required',
            'kategori' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Kategori::find($id);

        $post->update([
            'deskripsi'     => $request->deskripsi,
            'kategori'   => $request->kategori,
        ]);

        //return response
return new KategoriResource(true, 'Data Kategori Berhasil Diubah!', $post);
    }
    public function destroy($id)
    {

        //find post by ID
        $post = Kategori::find($id);
        //delete post
        $post->delete();

        //return response
        return new KategoriResource(true, 'Data Kategori Berhasil Dihapus!', null);
    }
    
}
