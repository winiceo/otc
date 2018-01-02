<?php



namespace Genv\Otc\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CrossDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (! $response instanceof Response) {
            return $response;
        }

        $response->headers->set('Access-Control-Allow-Credentials', $this->getCredentials());
        // $response->headers->set('Access-Control-Allow-Methods', implode(', ', ['GET', 'POST', 'PATCH', 'PUT', 'OPTIONS']));
        $response->headers->set('Access-Control-Allow-Methods', '*');
        // $response->headers->set('Access-Control-Allow-Headers', implode(', ', ['Origin', 'Content-Type', 'Accept', 'Cookie']));
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Access-Control-Allow-Origin', $this->getOrigin($request));

        return $response;
    }

    protected function getCredentials(): string
    {
        $credentials = config('http.cros.credentials');
        if ($credentials) {
            return 'true';
        }

        return 'false';
    }

    protected function getOrigin($request): string
    {
        $origin = config('http.cros.origin');
        if ($origin === '*') {
            return '*';
        }

        $requestOrigin = $request->headers->get('origin');
        if (in_array($requestOrigin, (array) $origin)) {
            return $requestOrigin;
        }

        return (string) '';
    }
}
