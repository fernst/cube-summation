<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Matrix;
use App\Persistence\DataMatrixService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Controller to handle Cube Summation using the database
 *
 * Class CubeSummationDBController
 * @package App\Http\Controllers
 */
class CubeSummationDBController extends Controller
{
    private $dataMatrixService;

    /**
     * Constructor, used to initialize the DataMatrixDB class
     */
    public function __construct()
    {
        $this->dataMatrixService = new DataMatrixService();
    }

    /**
     * Show the Cube Summation Database UI
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $matrix = Matrix::first();
        return view('cube-summation-db', array('size' => $matrix->size));
    }

    /**
     * Create a new Matrix
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        //Validate input and return if the input is empty
        $validator = Validator::make($request->all(), [
            'size' => array('numeric', 'required', 'min:1', 'max:21'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        //Get the size from input
        $size = $request->all()['size'];

        $this->dataMatrixService->createMatrix($size);

        Session::flash(
            'flash_message',
            "Create new Matrix of size $size X $size X $size successfully."
        );

        return redirect()->back();
    }

    /**
     * Update a cell in the matrix
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $matrix = Matrix::first();

        $upperBound = $matrix->size;

        //Validate input and return if the input is empty
        $validator = Validator::make($request->all(), [
            'x' => array('numeric', 'required', "min:1", "max:$upperBound"),
            'y' => array('numeric', 'required', "min:1", "max:$upperBound"),
            'z' => array('numeric', 'required', "min:1", "max:$upperBound"),
            'value' => array('required', 'min:-1000000000', 'max:1000000000'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        //Get values from input
        $x = $request->all()['x'];
        $y = $request->all()['y'];
        $z = $request->all()['z'];
        $value = $request->all()['value'];

        $this->dataMatrixService->updateCell($matrix->id, $x, $y, $z, $value);

        Session::flash('flash_message', "Updated cell $x,$y,$z to $value");

        return redirect()->back();
    }

    /**
     * Query the matrix
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function query(Request $request)
    {
        $matrix = Matrix::first();

        $upperBound = $matrix->size;

        //Validate input and return if the input is empty
        $validator = Validator::make($request->all(), [
            'x1' => array('numeric', 'required', "min:1", "less_than_equal:x2"),
            'y1' => array('numeric', 'required', "min:1", "less_than_equal:y2"),
            'z1' => array('numeric', 'required', "min:1", "less_than_equal:z2"),
            'x2' => array('numeric', 'required', "greater_than_equal:x1", "max:$upperBound"),
            'y2' => array('numeric', 'required', "greater_than_equal:y1", "max:$upperBound"),
            'z2' => array('numeric', 'required', "greater_than_equal:z1", "max:$upperBound")
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        //Get values from input
        $x1 = $request->all()['x1'];
        $y1 = $request->all()['y1'];
        $z1 = $request->all()['z1'];
        $x2 = $request->all()['x2'];
        $y2 = $request->all()['y2'];
        $z2 = $request->all()['z2'];

        $value = $this->dataMatrixService->queryMatrix($matrix->id, $x1, $y1, $z1, $x2, $y2, $z2);

        Session::flash(
            'flash_message',
            "The sum of cells between $x1,$y1,$z1 and $x2,$y2,$z2 is $value");

        return redirect()->back();
    }
}
