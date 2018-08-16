<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * @param string $resourceName
     * @param array ...$args
     *
     * @return object
     */
    public function resource($resourceName, ...$args)
    {
        // Get's the request's api version, or the latest if undefined
        $v = config('app.api_version', config('app.api_latest'));

        $className = $this->getResourceClassname($resourceName, $v);
        $class = new \ReflectionClass($className);
        return $class->newInstanceArgs($args);
    }

    /**
     * Parse Api\Resource for
     * App\Http\Resources\Api\v{$v}\Resource
     *
     * @param string $className
     * @param string $v
     *
     * @return string
     */
    protected function getResourceClassname($className, $v)
    {
        $re = '/.*\\\\(.*)/';
        return 'App\Http\Resources\\' .
            preg_replace($re, 'Api\\v' . $v . '\\\$1', $className);
    }

    /**
     * Success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Return error response.
     *
     * @param string $error Unique error message.
     * @param array $errorMessages An array of error messages.
     * @param integer $code HTTP error code.
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}