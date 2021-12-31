<?php

namespace App\Models\Dao;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\KindElement;

/**
 * balance テーブルの解析用の Dao
 */
class AnalyzeDao
{
    public static function getBalanceData(array $params)
    {
        $query = DB::table('m_balance');

        if (!is_null($params['label'])) { 
            $query->select(
                DB::raw('SUM(m_balance.amount) as sum')
            );
        } else {
            $query->select(
                'm_balance.id AS id',
                'm_balance.amount AS amount',
                'm_balance.item AS item',
                'm_balance.kind_element_id AS kind_element_id',
                'm_balance.purpose_element_id AS purpose_element_id',
                'm_balance.place_element_id AS place_element_id',
                'm_balance.date AS date',
                'm_kind_element.description AS kind_element_description',
                'm_purpose_element.description AS purpose_element_description',
                'm_place_element.description AS place_element_description'
            );
        }
        $query
            ->join('m_kind_element', 'm_kind_element.id', '=', 'm_balance.kind_element_id')
            ->join('m_purpose_element', 'm_purpose_element.id', '=', 'm_balance.purpose_element_id')
            ->join('m_place_element', 'm_place_element.id', '=', 'm_balance.place_element_id');


        if ($params['label'] === 'kind') {
            $query->addSelect(
                'm_balance.kind_element_id as label_id',
                'm_kind_element.description AS label_description'
            );
            $query->groupBy('m_balance.kind_element_id');

        } else if ($params['label'] === 'purpose') {
            $query->addSelect(
                'm_balance.purpose_element_id as label_id',
                'm_purpose_element.description AS label_description'
            );
            $query->groupBy('m_balance.purpose_element_id');
        } else if ($params['label'] === 'place') {
            $query->addSelect(
                'm_balance.place_element_id as label_id',
                'm_place_element.description AS label_description'
            );
            $query->groupBy('m_balance.place_element_id');
        } else if ($params['label'] === 'day') {
            $query->addSelect(
                'm_balance.date as label_id',
                'm_balance.date as label_description'
            );
            $query->groupBy('m_balance.date');
        } else if ($params['label'] === 'all') {
            $query->addSelect(
                DB::raw('1 as label_id'),
                DB::raw('"data" as label_description')
            );
            $query->groupBy('m_balance.date');
        }

        if ($params['dataset'] === 'kind') {
            $query->addSelect(
                'm_balance.kind_element_id as dataset_id',
                'm_kind_element.description AS dataset_description'
            );
            $query->groupBy('m_balance.kind_element_id');

        } else if ($params['dataset'] === 'purpose') {
            $query->addSelect(
                'm_balance.purpose_element_id as dataset_id',
                'm_purpose_element.description AS dataset_description'
            );
            $query->groupBy('m_balance.purpose_element_id');
        } else if ($params['dataset'] === 'place') {
            $query->addSelect(
                'm_balance.place_element_id as dataset_id',
                'm_place_element.description AS dataset_description'
            );
            $query->groupBy('m_balance.place_element_id');
        } else if ($params['dataset'] === 'day') {
            $query->addSelect(
                'm_balance.date as dataset_id',
                'm_balance.date as dataset_description'
            );
            $query->groupBy('m_balance.date');
        } else if ($params['dataset'] === 'all') {
            $query->addSelect(
                DB::raw('1 as dataset_id'),
                DB::raw('"data" as dataset_description')
            );
        }

        if ($params['isMoveIgnore']) {
            $query->where('kind_element_id', '<>', KindElement::MOVE_ID);
        }

        if ($params['filterKindElements'] !== array()) {
            $query->whereIn('kind_element_id', $params['filterKindElements']);
        }
        if ($params['filterPurposeElements'] !== array()) {
            $query->whereIn('purpose_element_id', $params['filterPurposeElements']);
        }
        if ($params['filterPlaceElements'] !== array()) {
            $query->whereIn('place_element_id', $params['filterPlaceElements']);
        }

        if ($params['startDate'] !== '') {
            $query->whereDate('m_balance.date', '>=', $params['startDate']);
        }
        if ($params['endDate'] !== '') {
            $query->whereDate('m_balance.date', '<=', $params['endDate']);
        }

        return $query->get();
    }

}
