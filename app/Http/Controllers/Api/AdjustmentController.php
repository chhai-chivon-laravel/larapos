<?php

namespace App\Http\Controllers\Api;

use App\Adjustment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AdjustmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $request->all();

        // inject current user id
        $form['user_id'] = $request->user()->id;

        $rules = Adjustment::$rules;
        $rules['items'] = 'required';

        $validator = Validator::make($form, $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        Adjustment::createAll($form);

        return response()->json([], 201);
    }
}
