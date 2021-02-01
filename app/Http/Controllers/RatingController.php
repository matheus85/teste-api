<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class RatingController extends BaseController
{
    public function index()
    {
        $ratings = Rating::all();

        return $this->sendOk(null, $ratings);
    }

    public function show($id)
    {
        $rating = Rating::find($id);

        if (empty($rating)) {
            return $this->sendError('Rating not found.');
        }

        return $this->sendOk(null, $rating);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'movie_id' => 'required|integer|exists:movies,id',
            'rating'   => 'required|numeric|between:0.00,10.00',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Request failed.', $validator->messages(), null, 400);
        }

        DB::beginTransaction();
        try {
            $rating = Rating::create($input);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->sendError('Request failed.', null, null, 400);
        }
        DB::commit();

        return $this->sendOk('Avaliação criada com sucesso.', $rating);
    }
}
