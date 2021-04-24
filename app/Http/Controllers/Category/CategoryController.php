<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display all Categories
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //
        $categories = Category::where([
            ['user_id' , 1],
            ['status' ,  1]
        ])->get();
        return [
            'code' => 200,
            'categories' => $categories
        ];


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            
            
        ]);

        if($validator->fails()){
            return [
                'code' => 409 ,
                'errors' => $validator->errors()
            ];
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            
            'user_id' => Auth::user()->id
        ]);

        return [
            'code' => 200,
            'category' => $category
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = Category::where(['id' => $id])->where('status' , 1)->with('subcategories')->first();
        if($category){
            
            return [
                'code' => 200,
                'category' => $category
            ];
        }

        return [
            'code' => 404,
            'message' => "Category Not Found "
        ];
    

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
       
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());

        $category = Category::where(['id' => $id])->where('status' , 1)->first();
        if($category){

            if($request->name == null){
                return [
                    'code' => 409,
                    'message' => "Name is Required"
                ];
            }

            $category->name = $request->name; 
            $category->description = $request->description;

            $category->save();
            return [
                'code' => 200,
                'message' => "Category Updated Successfully "
            ];
        }

        return [
            'code' => 404,
            'message' => "Category Not Found "
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::where(['id' => $id])->where('status' , 1)->first();
        if($category){
            $category->status = 0; 
            $category->save();
            return [
                'code' => 200,
                'message' => "$category->name deleted Successfully "
            ];
        }

        return [
            'code' => 404,
            'message' => "Category Not Found "
        ];
        
        
    }
}
