<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class OrderController extends Controller
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
        $validator = Validator::make($request->all(), [
            'userid' => 'required|integer',
            'address' => 'required',
            'addressextra' => 'required|string',
            'message' => 'required|string',
            'deliverydate' => 'required|date',
            'total' => 'required|integer',
            'latitude' => 'required',
            'longitude' => 'required',
            'paymentstatus' => 'required|string',
            'iscompleted' => 'required|integer',
            'couponcode' => 'required|string',
            'subtotal' => 'required|integer',
            'discount' => 'required|integer',
            'credit' => 'required|integer',
            'credit' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $order          = new Order;
        $transaction    = new Transaction;

        $order->_userid = $request->userid;
        $order->address = $request->address;
        $order->addressextra = $request->addressextra;
        $order->notes = $request->message;
        $order->deliverydate = $request->deliverydate;
        $order->total = $request->total;
        $order->latitude = $request->latitude;
        $order->longitude = $request->longitude;
        $order->paymentstatus = $request->paymentstatus;
        $order->iscompleted = $request->iscompleted;
        $order->couponcode = $request->couponcode;
        $order->subtotal = $request->subtotal;
        $order->discount = $request->discount;
        $order->amount  = $request->credit;
        $order->save();

        $transaction->_userid   = $request->userid;
        $transaction->_orderid  = $order->id;
        $transaction->credit    = $request->credit;
        $transaction->save();

        return response()->json(array('success' => true, 'message' => 'data inserted to order', 'order' => $order, 'transaction' => $transaction), 200);     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
