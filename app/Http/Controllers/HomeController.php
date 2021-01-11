<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ConnectionUsers;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $connectionUsers = ConnectionUsers::select('request_user_id')
                                          ->where('request_user_id','!=',$user_id)
                                          ->where('sender_user_id',$user_id)
                                          // ->whereIn('status',[0,1])
                                          ->get();
        $connectionUserArr = [];                                  
        if($connectionUsers && $connectionUsers->count()>0){
            $connectionUserArr = array_column($connectionUsers->toArray(), "request_user_id");
        }                                  
        $user = User::whereNotIn('id',$connectionUserArr)
                    ->where('id','!=',$user_id)
                    ->get();
        return view('home',compact('user'));
    }

    public function sendConnectRequest($request_user_id){
        $user_id = Auth::user()->id;
        ConnectionUsers::create([
            "sender_user_id"=>$user_id,
            "request_user_id"=>$request_user_id
        ]);        
        return redirect('/home')->with('status',"Request Sent Successfully");
    }

    public function pendingRequest(){
        $user_id = Auth::user()->id;
        $connectionUsers = ConnectionUsers::select('sender_user_id')
                                          ->where('request_user_id',$user_id)
                                          ->where('status',0)
                                          ->get();
        $pendingUsers = [];                                  
        if($connectionUsers && $connectionUsers->count()>0){
            $connectionUserArr = array_column($connectionUsers->toArray(), "sender_user_id");
            $pendingUsers = User::whereIn('id',$connectionUserArr)
                                ->get();
        }                                  
        return view('home',compact('pendingUsers'));   
    }

    public function myConnection(){
        $user_id = Auth::user()->id;
        $connectionUsers = ConnectionUsers::select('sender_user_id','request_user_id')
                                          ->where('request_user_id',$user_id)
                                          ->Orwhere('sender_user_id',$user_id)
                                          ->where('status',1)
                                          ->get();
        $myConnection = [];                                  
        if($connectionUsers && $connectionUsers->count()>0){
            $arrData = [];
            
            $requestUserIds = array_column($connectionUsers->toArray(), "sender_user_id");
            $senderUserIds = array_column($connectionUsers->toArray(), "request_user_id");
            if (($key = array_search($user_id, $requestUserIds)) !== false) {
                unset($requestUserIds[$key]);
                $requestUserIds = array_values($requestUserIds);
            }
            if (($key = array_search($user_id, $senderUserIds)) !== false) {
                unset($senderUserIds[$key]);
                $senderUserIds = array_values($senderUserIds);

            }
            array_push($arrData,$requestUserIds);
            array_push($arrData,$senderUserIds);
            $myConnection = User::whereIn('id',$arrData)->get();
        }                                  
                
        return view('home',compact('myConnection'));   
    }

    public function acceptRejectRequest($request_user_id,$type){
        $user_id = Auth::user()->id;
        $connectionUser = ConnectionUsers::where('request_user_id',$user_id)
                        ->where('sender_user_id',$request_user_id)
                        ->first();
        $message = '';
        if($connectionUser && $connectionUser->count()>0){
            if($type == 'accept'){
                $connectionUser->status = 1;
                $connectionUser->save();
                $message = "Request Accepted Successfully.";
            }else if($type == 'reject'){
                $connectionUser->status = 2;
                $connectionUser->save();
                $message = "Request Declined Successfully.";
            }else{
                $message = "No Type Selected";
            }
        }else{
            $message = "No Data Found";
        }
        return redirect('/home')->with('status',$message);   
    }
}
