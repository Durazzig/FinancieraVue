<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Loan;
use App\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::with('client')->get();
        return response()->json($loans);
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
        
    }

    public function export_excel(Request $request)
    {
        dd('Hola');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //dd($request->input('abono'));
        $payments = Payment::all()->where('loan_id',$id);
        $pago = $request->input('abono');
        $aux = $request->input('abono');
        foreach($payments as $payment)
        {
            //Cuando pago justo lo que pide la cuota
            if($payment->pago_registrado == 0)
            {
                if($pago == ($payment->cantidad))
                {
                    $payment->pago_registrado = $pago;
                    $payment->pagado = 1;
                    $payment->save();
                    $pago = 0;
                }
                //Cuando pago mas de lo que pide la cuota
                elseif($pago > $payment->cantidad)
                {
                    $pago = $payment->cantidad;
                    $payment->pago_registrado = $pago;
                    $payment->pagado = 1;
                    $payment->save();
                    $pago = $aux - $payment->cantidad;
                    $aux = $aux - $payment->cantidad;
                }
                elseif($pago < $payment->cantidad)
                {
                    $payment->pago_registrado = $pago;
                    $payment->save();
                    $pago = 0;
                }
            }
            elseif(($payment->pago_registrado > 0) && ($payment->pago_registrado < $payment->cantidad))
            {
                if($pago < $payment->cantidad)
                {
                    if(($pago + $payment->pago_registrado) < ($payment->cantidad))
                    {
                        $payment->pago_registrado += $pago;
                        $pago = 0;
                        $payment->save();
                    }
                    else{
                        $payment->pago_registrado += $pago;
                        $payment->pagado = 1;
                        $pago = 0;
                        $payment->save();
                    }
                }
                else
                {
                    $subcantidad = $payment->cantidad - $payment->pago_registrado;
                    $pago = $pago - $subcantidad;
                    $payment->pago_registrado = $payment->cantidad;
                    $payment->save();
                }
            }
            elseif($payment->pago_registrado == $payment->cantidad)
            {
                $payment->pagado = true;
                $payment->save();
            }
        }
        $saldo_abonado = 0;
        $saldo_pendiente = 0;
        $deuda = Loan::select('cantidad')->where('id',$id)->get();
        foreach($payments as $payment)
        {
            $saldo_abonado += $payment->pago_registrado;
            $saldo_pendiente = $deuda[0]->cantidad - $saldo_abonado;
        }
        //dd($loans->id);
        return response()->json($payments);
    }

    public function list($id)
    {
        //dd($id);
        //$payments = Payment::all();
        $payments = Payment::where('loan_id',$id)->get();
        $saldo_abonado = 0;
        $saldo_pendiente = 0;
        $deuda = Loan::select('cantidad')->where('id',$id)->get();
        foreach($payments as $payment)
        {
            $saldo_abonado += $payment->pago_registrado;
            $saldo_pendiente = $deuda[0]->cantidad - $saldo_abonado;
        }
        return response()->json($payments);
        //return view('payments.paymentsList',compact('payments'))->with(compact('deuda','saldo_abonado','saldo_pendiente'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
