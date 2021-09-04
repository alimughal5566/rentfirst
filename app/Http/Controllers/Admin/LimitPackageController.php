<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LimitPackage;
use Illuminate\Http\Request;

class LimitPackageController extends Controller
{
    public function create(Request $request){
//        dd($request->all());
        $limit  = new LimitPackage();
        $limit->name = $request->name;
        $limit->category_id = $request->category_id;
        $limit->post_limit = $request->post_limit;
        $limit->price = $request->price;
        $limit->status = 1;
        $limit->save();
        $limit_send = LimitPackage::where('id', $limit->id)->first();
        return response()->json([
            'success'=> true,
            'package'=> $limit_send
        ]);
    }
    public function getPackages (){
        $packages = LimitPackage::all();
        $categories = Category::where('parent_id', NULL)->get();
//        dd($categories);
        return view('packages', compact('packages','categories'));
    }
    public function get_package_detail(Request $request){
        $limit  = LimitPackage::where('id', $request->id)->first();
        return response()->json([
            'success'=> true,
            'package'=>$limit,
            'update' => true
        ]);
    }
    public function update(Request $request){
        $limit  = LimitPackage::where('id', $request->id)->first();
        $limit->name = $request->name;
        $limit->category_id = $request->category_id;
        $limit->post_limit = $request->post_limit;
        $limit->price = $request->price;
        $limit->status = 1;
        $limit->update();
        return response()->json([
            'success'=> true,
            'package'=>$limit,
            'update' => true
        ]);
    }
    public function change_status(){
        $id = $_GET['id'];
        $package = LimitPackage::where('id',$id)->first();
        $package->status = $_GET['status'];
        $package->update();
        return response()->json([
            'success'=> true,
        ]);
    }
    public function delete(){
        $id = $_GET['id'];
        LimitPackage::where('id', $id)->delete();
        return response()->json([
            'success'=> true,
        ]);
    }

}
