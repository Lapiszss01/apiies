<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function list()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            // categories/ es la carpeta en la que se guardará el file
            $name = 'categories/'.Str::uuid().'.'.$file->extension();
            //Guardamos el file en la carpeta public + name que hemos puesto antes
            $file->storeAs('', $name,'public');
            $data['photo'] = $name;
        }

        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response(null,Response::HTTP_NO_CONTENT);
        //return response()->noContent();
    }

}
