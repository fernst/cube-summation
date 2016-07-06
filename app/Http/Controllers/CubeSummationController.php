<?php

namespace App\Http\Controllers;

use App\Classes\InstructionHandler;
use App\Exceptions\InstructionParseException;
use App\Exceptions\InvalidInstructionException;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * Controller to handle Cube Summation instruction submission and processing
 *
 * Class CubeSummationController
 * @package App\Http\Controllers
 */
class CubeSummationController extends Controller
{

    /**
     * Render homepage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cube-summation');
    }

    /**
     * Process input and display the output from the cube summation script
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function process(Request $request)
    {
        //Validate input and return if the input is empty
        $validator = Validator::make($request->all(), [
            'instructions' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        //Get parameters from input
        $input = $request->all();

        //Instantiate instructions handler
        $instructionHandler = new \App\Classes\InstructionHandler();

        //Initialize output data
        $outputData = array('instructions' => $input['instructions']);

        try {
            //process input and assign the output fo the appropriate variable.
            //If an exception is triggered, an error message is shown
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
