<?php

namespace App\Http\Controllers;

use App\Account;
use App\Plan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function users()
    {
        try
        {
            return response()->json(['users' => User::all()], Response::HTTP_OK);
        }
        catch (\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function search(Request $request)
    {
        $error = ['error' => 'No results found, please try with different keywords.'];

        if($request->has('q') && !empty($request->get('q'))) {
            $users = User::search($request->get('q'))->get();
            return $users->count() ? $users : $error;

        }
        return $error;
    }

    public function account(Request $request)
    {
        try {
            $account = Account::whereUserId($request->id)->firstOrFail();
            return response()->json(['amount' => $account->amount], Response::HTTP_OK);
        }
        catch(\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


    }

    public function plan(Request $request)
    {
        $to = User::whereId($request->to)->firstOrFail();
        $from = User::whereId($request->from)->firstOrFail();
        try
        {
            Plan::create([
                'user_id' => $from->id,
                'to' => $to->id,
                'amount' => round(floatval($request->amount),2),
                'planned_at' => Carbon::parse($request->when)->format('Y-m-d H:i:s')
            ]);
            $account = $from->account()->where('user_id', $from->id)->first();
            $result = floatval($account->amount) - floatval($request->amount);
            $account->amount = round($result, 2);
            $account->save();
            return response()->json(['success' => 'You successfully planned transfer', 'amount' => $account->amount], Response::HTTP_OK);

        }
        catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


    }
}
