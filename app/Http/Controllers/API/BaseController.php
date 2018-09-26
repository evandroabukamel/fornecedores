<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

/**
 * Base controller classe, to be extended for all controller classes.
 * 
 * @category Controller
 * @package  App\Http\Controllers\Api
 * @author   Evandro Abu Kamel <evandro.abukamel@gmail.com>
 * @license  BSD-3-Clause <https://opensource.org/licenses/BSD-3-Clause>
 * @link     https://github.com/evandroabukamel/fornecedores 
 */
class BaseController extends Controller
{
    /**
     * Get the resouce for a class name and API version.
     * 
     * @param string $resourceName Resouce name.
     * @param array  ...$args      Arguments.
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
     * @param string $className Classname for versioning.
     * @param string $v         API Verion to be called.
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
     * @param array|object $result  Data structure to be returned.
     * @param string       $message Text message for the response.
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Return error response.
     *
     * @param string  $error         Unique error message.
     * @param array   $errorMessages An array of error messages.
     * @param integer $code          HTTP error code.
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}