<?php

namespace App\Http\Middleware;

use App\Auth\Auth;
use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

/**
 * Class JsonMiddleware
 * @package App\Http\Middleware
 */
class JsonResponseMiddleware
{
    /**
     * The Response Factory our app uses
     *
     * @var ResponseFactory
     */
    protected $factory;

    /**
     * JsonMiddleware constructor.
     *
     * @param ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // First, set the header so any other middleware knows we're
        // dealing with a should-be JSON response.
        $request->headers->set('Accept', 'application/json');

        // Get the response
        $response = $next($request);

        // Check whether request header has x-auth-token set
        if ($request->headers->get('X-Auth-Token')) {
            // This set the fresh token and prevent authentication timeout if requested within token token expiry time
            $tokenData = Auth::decodeAuthToken($request);
            $response->headers->set('X-Auth-Token', Auth::encodeAuthToken($tokenData));
        }

        // If the response is not strictly a JsonResponse, we make it
        if (!$response instanceof JsonResponse) {
            $response = $this->factory->json(
                $response->content(),
                $response->status(),
                $response->headers->all()
            );
        }

        return $response;
    }
}
