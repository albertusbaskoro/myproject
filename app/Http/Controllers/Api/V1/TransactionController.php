<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $transaction = new Transaction;
        
        $transaction->_userid = $request->userid;
        $transaction->credit = $request->credit;
        $transaction->debt = $request->debt;
        
        $transaction->save();

        $payment = new Payment;

        $payment->_userid = $request->userid;
        $payment->status = 'processed';
        $payment->method = 'credit';

        $payment->save();
        
        if ($transaction == true) {
            return response()->json(['status' => true, 'message' => 'Data Inserted', 'data' => $transaction], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => $transaction], 500);
        }
    }

    public function topup(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'userid' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $transaction = new Transaction;

        $transaction->_userid = $request->userid;
        $transaction->credit = $request->credit;
        $transaction->debt = $request->debt;
        
        $transaction->save();

        if ($transaction == true) {
            return response()->json(['status' => true, 'message' => 'Topup Successful', 'data' => $transaction], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => $transaction], 500);
        }
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
    public function update(Request $request)
    {
        if (Payment::where('id', '=', request()->id)->count() == false) {
            return response()->json(['status' => false, 'message' => 'Payment Not Exists'], 500);
        } else {
            $payment = DB::table('payment')->where('id', request()->id)
                    ->update(array('status' => request()->status));

            return response()->json(['status' => true, 'message' => 'Payment Progress Succeed', 'data' => $payment], 200);
        }
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
    }
}
