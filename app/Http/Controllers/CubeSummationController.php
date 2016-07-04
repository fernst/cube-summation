<?php

namespace App\Http\Controllers;

use App\Classes\InstructionHandler;
use App\Exceptions\InstructionParseException;
use App\Exceptions\InvalidInstructionException;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CubeSummationController extends Controller
{

    public function index()
    {
        return view('cube-summation');
    }

    public function process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instructions' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        $input = $request->all();

        $instructionHandler = new \App\Classes\InstructionHandler();

        $outputData = array('instructions' => $input['instructions']);

        try {
            $instructionHandler->processInput($input['instructions']);

            $outputData['output'] = $instructionHandler->getOutputAsString();

            Session::flash('flash_message', "Input processed successfully.");
        } catch (InvalidInstructionException $e) {
            return view('cube-summation', $outputData)->withErrors($e->getMessage());
        } catch (InstructionParseException $e) {
            return view('cube-summation', $outputData)->withErrors($e->getMessage());
        }

        return view('cube-summation', $outputData);
    }
}
