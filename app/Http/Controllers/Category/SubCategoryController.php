<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display all Categories
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //
        $subcategories = SubCategory::where([
            ['user_id' , 1],
            ['status' ,  1]
        ])->get();
        return [
            'code' => 200,
            'sub_categories' => $subcategories
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
            'category_id' => 'required',
            
        ]);

        if($validator->fails()){
            return [
                'code' => 409 ,
                'errors' => $validator->errors()
            ];
        }

        $category = SubCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
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
        $subcategory = SubCategory::where(['id' => $id])->where('status' , 1)->with('Category')->first();
        if($subcategory){
            
            return [
                'code' => 200,
                'sub_category' => $subcategory
            ];
        }

        return [
            'code' => 404,
            'message' => "Sub Category Not Found "
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

        $subcategory = SubCategory::where(['id' => $id])->where('status' , 1)->first();
        if($subcategory){

            if($request->name == null){
                return [
                    'code' => 409,
                    'message' => "Name is Required"
                ];
            }

            $subcategory->name = $request->name; 
            $subcategory->category_id = $request->category_id; 
            $subcategory->description = $request->description;

            $subcategory->save();
            return [
                'code' => 200,
                'message' => "Category Updated Successfully ",
                'sub_category' => $subcategory
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
        $subcategory = SubCategory::where(['id' => $id])->where('status' , 1)->first();
        if($subcategory){
            $subcategory->status = 0; 
            $subcategory->save();
            return [
                'code' => 200,
                'message' => "$subcategory->name deleted Successfully "
            ];
        }

        return [
            'code' => 404,
            'message' => "SubCategory Not Found "
        ];
        
        
    }
}
