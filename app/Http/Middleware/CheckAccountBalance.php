<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;
use Illuminate\Http\Response;

class CheckAccountBalance
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
        $account = Account::whereUserId($request->from)->firstOrFail();
        if($this->equal($account->amount, $request->amount))
        {
            return $next($request);
        }
        else {
            return response()->json(['error' => 'Sorry, you haven\'t needed balance to plan transfer. Your balance: '.$account->amount], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    private function equal($first_value, $second_value)
    {
        $result = round(floatval($first_value) - floatval($second_value), 2);
        if ($result > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
