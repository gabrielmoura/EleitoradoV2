<?php

namespace App\Http\Controllers;

use App\Actions\Tools\GetCep;
use App\Exceptions\GetCepException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * @throws GetCepException
     */
    public function getCep(Request $request): JsonResponse
    {
        $this->validate($request, ['cep' => 'min:8|max:9']);

        return response()->json(GetCep::find($request->input('cep'))->getCached());
    }
}
