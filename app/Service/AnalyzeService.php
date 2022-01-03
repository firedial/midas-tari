<?php

namespace App\Service;

use App\Models\KindElement;
use App\Models\Dao\AnalyzeDao;

/**
 * balance テーブルの解析用のサービスクラス
 */
class AnalyzeService
{
    public static function getBalanceJsonData(array $params)
    {
        $objectData = (array)AnalyzeDao::getBalanceData($params);
        $arrayData = json_decode(json_encode($objectData), true);
        $data = current($arrayData);
        
        // 集約をしない場合
        if (is_null($params['label'])) {
            return $data;
        }

        // @todo 日付を埋める処理が必要

        $sumData = array();
        foreach ($data as $x) {
            $sumData[$x['dataset_id']][$x['label_id']] = $x['sum'];
        }

        // label の一覧を取得
        $labels = array();
        foreach ($data as $x) {
            if (!isset($labels[$x['label_id']])) {
                $labels[$x['label_id']] = $x['label_description'];
            }
        }

        // dataset の一覧を取得
        $datasets = array();
        foreach ($data as $x) {
            if (!isset($datasets[$x['dataset_id']])) {
                $datasets[$x['dataset_id']] = $x['dataset_description'];
            }
        }

        $filledSumData = self::fillData($sumData, $labels, $datasets);
        $datasetsValue = array();
        foreach ($filledSumData as $datasetId => $record) {
            $datasetsValue[] = array(
                'label' => $datasets[$datasetId],
                'data' => array_values($record)
            );
        }

        $returnData = array();
        $returnData['labels'] = array_values($labels);
        $returnData['datasets'] = $datasetsValue;

        return $returnData;
    }

    private static function fillData($sumData, $labels, $datasets)
    {
        $result = array();
        foreach ($datasets as $datasetId => $datasetDescription) {
            foreach ($labels as $labelId => $labelDescription) {
                if (isset($sumData[$datasetId][$labelId])) {
                    $result[$datasetId][$labelId] = (int)$sumData[$datasetId][$labelId];
                } else {
                    $result[$datasetId][$labelId] = 0;
                }
            }
        }

        return $result;
    }

}
