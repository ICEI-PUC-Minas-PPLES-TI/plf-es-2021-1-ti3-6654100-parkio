<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\View;

class WebMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->cookie('X-token');
        $colorMode = !empty($request->cookie('X-colormode')) ? $request->cookie('X-colormode'): 'dark';
        View::share('colormode', $colorMode);
        
        if(!$token) {
            // Unauthorized response if token not there
            return redirect('/auth');
        }
        $pages = [
            '/' => ['A','S','P','R'],
            '/gate/{id}' => ['A','P'],
            '/vehiclelist' => ['A','S','R'],
            '/userlist' => ['A'],
            '/admin' => ['A'],
            '/report' => ['A'],
        ];
        
        $url = $request->getPathInfo();
        $url = preg_replace('/[0-9]+/', '{id}', $url);

        try {
            $decode = JWT::decode($token, env('JWTSECRET'), ['HS256']);
            if(in_array($decode->tip, $pages[$url])) {
                $res = $next($request);
                return $res->withCookie(new Cookie('PARKIO_UIF', json_encode([
                    't' => $decode->tip,
                    'n' => $decode->nm
                ]), 0, '/', null, null, false));
            } else {
                return redirect('/'); //Permission Denied
            }

        } catch(ExpiredException $e) {
            return redirect('/auth'); //Expired Token
        } catch(Exception $e) {
            return redirect('/auth'); //Invalid Token
        }
    }
}