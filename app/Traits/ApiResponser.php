<?php

namespace App\Traits;


trait ApiResponser{

    protected function successResponse($message = null, $data, $code = 200)
	{
		return response()->json([
			'status'=> 'Success', 
			'message' => $message, 
			'data' => $data,
            'code' => $code
		], $code);
	}

	protected function errorResponse($message = null, $code)
	{
		return response()->json([
			'status'=>'Error',
			'message' => $message,
			'data' => null,
            'code' => $code
		], $code);
	}
}