<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class RentController extends Controller
{
    //
    public function create(Request $request){
        $rent=new Rent();
        $rent->user_id=$request->user_id;
        $rent->post_id=$request->post_id;
        $rent->rent_endtime=$request->rent_endtime;
        $rent->save();
        return redirect('/account/my-posts/');
    }

    public function deleteRent(Request $request){
        $id=$request->id;
        $rent=Rent::find($id);
        $data =array();
//        $data['user_id'] = $rent->user_id;
//        $data['post_id'] = $rent->user_id;
        $data = '<form action="'.route('setRent').'" method="POST" id="setRentForm">
                <label for="setRent">Set Rent Scheduler (date and time):</label>
                <input type="hidden" name="post_id" value="'.$rent->user_id.'">
                <input type="hidden" name="user_id" value="'.$rent->user_id.'">
                <input type="datetime-local" id="renttime" name="rent_endtime">
                <button type="submit" class="btn btn-primary" >Submit</button>
            </form>';
//        dd($data);
        $rent->delete();
        return response()->json($data);
    }

    public function get_rent_data(Request $request){
        $rent=Rent::where('post_id',$request->post_id)->where('user_id', $request->user_id)->orderBy('id','desc')->get()->first();
//        dd($rent);
        if (empty($rent)){
            $html = array();
            $html['code'] = '<form action="'.route('setRent').'" method="POST" id="setRentForm">
                <label for="setRent">Set Rent Scheduler (date and time):</label>
                <input type="hidden" name="post_id" value="'.$request->post_id.'">
                <input type="hidden" name="user_id" value="'.$request->user_id.'">
                <input type="datetime-local" id="renttime" name="rent_endtime">
                <button type="submit" class="btn btn-primary" >Submit</button>
            </form>';
            $html['status'] = 0;
            return response()->json($html);
        }else{

            $html_timer['status'] = 1;
            $html_timer['rent_endtime'] = $rent->rent_endtime;
            $html_timer['id'] = $rent->id;
            $html_timer['code'] = '<button class="btn btn-danger" onclick="delete_rent('.$rent->id.')">End Rent</button>';
            return response()->json($html_timer);
        }
    }
}
