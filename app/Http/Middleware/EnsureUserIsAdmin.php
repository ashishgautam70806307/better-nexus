<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user=$request->user('web');
        if(!$user) {
            return $request->expectsJson()
                ? response()->json(['message'=>'Unauthenticated.'],401)
                : redirect()->guest(route('login'));
        }
        abort_unless($user->isAdmin(),403);
        // Private admin responses should not remain in browser/proxy caches after logout.
        $response=$next($request);
        $response->headers->set('Cache-Control','no-store, private');
        return $response;
    }
}
