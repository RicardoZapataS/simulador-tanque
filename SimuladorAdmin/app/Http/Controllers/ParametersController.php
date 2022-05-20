<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use Illuminate\Http\Request;

class ParametersController extends Controller
{
    public function Api(Type $var = null)
    {
        # code...
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

    public function pause()
    {
        $simulatorState = Parameters::find(1);
        $simulatorState->value = 3;
        $simulatorState->save();

        return $simulatorState;

    }
    public function unpause()
    {
        $simulatorState = Parameters::find(1);
        $simulatorState->value = 1;
        $simulatorState->save();

        return $simulatorState;

    }


}
