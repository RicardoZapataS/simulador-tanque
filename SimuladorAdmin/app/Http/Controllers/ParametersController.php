<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use Illuminate\Http\Request;

class ParametersController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function show(Parameters $parameters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameters $parameters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameters $parameters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameters $parameters)
    {
        //
    }
    public function SetStart()
    {
        $simulatorState = Parameters::find(1);
        $simulatorState->value = 2;
        $simulatorState->save();
        $lastState = Parameters::find(2);
        $lastState->value = 2;
        $lastState->save();

        return $simulatorState;

    }
}
