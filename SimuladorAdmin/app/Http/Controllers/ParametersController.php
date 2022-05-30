<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use Illuminate\Http\Request;

class ParametersController extends Controller
{

    public function SetStart()
    {
        $simulatorState = $this->setParameter(1,2);
        $this->setParameter(2,2);
        return $simulatorState;

    }

    public function Pause()
    {
        $simulatorState = $this->getParameter(1);
        if($simulatorState == 1)
            $this->setParameter(1,3);
        else if($simulatorState == 4)
            $this->setParameter(1,5);

        return $simulatorState;

    }
    private function setParameter($id, $value)
    {
        $simulatorState = Parameters::find($id);
        $simulatorState->value = $value;
        $simulatorState->save();
        return $simulatorState;
    }
    private function getParameter($id)
    {
        $simulatorState = Parameters::find($id);
        return $simulatorState->value;
    }


}
