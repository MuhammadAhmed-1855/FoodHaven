<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgeRestriction
{
    private $minAge = 17;

    public function handle(Request $request, Closure $next)
    {
        $reqAge = $this->minAge;

        if ($request->age <= $reqAge) {
            return redirect('register');
        }

        return $next($request);
    }
}
?>