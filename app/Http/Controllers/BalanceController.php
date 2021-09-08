<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Balance;

class BalanceController extends Controller
{
    public function index()
    {
        return DB::table('m_balance')
            ->select(
                'm_balance.id AS id',
                'm_balance.amount AS amount',
                'm_balance.item AS item',
                'm_balance.kind_element_id AS kind_element_id',
                'm_balance.purpose_element_id AS purpose_element_id',
                'm_balance.place_element_id AS place_element_id',
                'm_balance.date AS date',
                'm_kind_element.description AS kind_description',
                'm_purpose_element.description AS purpose_description',
                'm_place_element.description AS place_description'
            )
            ->join('m_kind_element', 'm_kind_element.id', '=', 'm_balance.kind_element_id')
            ->join('m_purpose_element', 'm_purpose_element.id', '=', 'm_balance.purpose_element_id')
            ->join('m_place_element', 'm_place_element.id', '=', 'm_balance.place_element_id')
            ->get();
    }

    public function show(Balance $balance)
    {
        return $balance;
    }

    public function store(Request $request)
    {
        return Balance::create($request->all());
    }

    public function update(Request $request, Balance $balance)
    {
        $balance->update($request->all());
        return $balance;
    }

    public function destroy(Balance $balance)
    {
        $balance->delete();

        return $balance;
    }
}