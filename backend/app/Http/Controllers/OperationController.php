<?php

namespace App\Http\Controllers;

use App\Operation\OperationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class OperationController
 * @package App\Http\Controllers
 */
class OperationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', Rule::in(OperationType::getAll(true))],
            'from_account_id' => 'nullable|exists:accounts,id|required_if:type,' . OperationType::TYPE_INTERNAL_TRANSFER,
            'to_account_id' => 'nullable|exists:accounts,id|required_if:type,' . OperationType::TYPE_INTERNAL_TRANSFER,
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        return response()->json(['ok']);
    }
}
