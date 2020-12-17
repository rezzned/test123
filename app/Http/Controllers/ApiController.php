<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $successStatus = 200;
    protected $errorStatus = 500;
    //
    public function index(Request $request){
        if($request->postdate){
            $date = $request->postdate;
            $timestamp = strtotime($date);
            $weekday= date("l", $timestamp );
            $normalized_weekday = strtolower($weekday);
            if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
                $flag = $this->errorStatus;
                $success['message']    =  "Not available";
            } else {

                // slot
                $vstart = strtotime('08:00');
                $vend   = strtotime('20:00');
                
                $varray = array();

                while ($vstart <= $vend) {

                    // Set dates to display
                    $vdate1 = $vstart;   
                    //if($start )   
                    if($vstart >= strtotime('18:00')){  
                        $vdate2 = $vstart + (30*60);
                    }else{
                        $vdate2 = $vstart + (60*60);   
                    }
                    
                    $slot_merge = date('g:i A',$vdate1) . " (10 Slot) - " . date('g:i A',$vdate2) . " (10 Slot)";

                    $varray_merge[] = $slot_merge;
                    //echo date('g:i A',$vdate1) . " - " . date('g:i A',$vdate2) . '<br>';
                    
                    // Increment Start date
                    if($vstart >= strtotime('18:00')){
                        $vstart += (30*60);
                    }else{
                        $vstart += (60*60);
                    }
                    
                
                }
                
                $flag = $this->successStatus;
                $success['message']    =  implode(",",$varray_merge);
            }
        }else{
            $flag = $this->errorStatus;
            $success['message']    =  "You enter wrong value.";
        }


        
        return response()->json(['success'=>$success, 'status' =>$flag])->setStatusCode($flag);

    }

}
