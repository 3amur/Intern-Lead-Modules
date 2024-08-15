<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use Modules\PotentialCustomer\app\Models\SalesTarget;
use Modules\PotentialCustomer\app\Models\TargetLayer;

class TargetLayerController extends Controller
{
    public static function createTargetLayers($targetLayers, $salesTarget)
    {
        if ($targetLayers) {
            foreach ($targetLayers['from'] as $index => $layer) {
                TargetLayer::create([

                    'from' => floatval(str_replace(',', '',  $targetLayers['from'][$index])),
                    'to' => floatval(str_replace(',', '',  $targetLayers['to'][$index])),
                    'percentage' => floatval(str_replace(',', '',  $targetLayers['percentage'][$index])) ?? 0,
                    'target_type_id' => $targetLayers['layer_target_type_id'][$index],
                    'sales_target_id' => $salesTarget->id,
                    'created_by' => auth()->id(),
                ]);
            }
        }
    }


    public static function updateTargetLayers($targetLayers, $salesTarget)
    {
        $salesTarget->targetLayers()->delete();

        if ($targetLayers) {
            foreach ($targetLayers['from'] as $index => $layer) {
                TargetLayer::create([
                    'from' => floatval(str_replace(',', '',  $targetLayers['from'][$index])),
                    'to' => floatval(str_replace(',', '',  $targetLayers['to'][$index])),
                    'percentage' => floatval(str_replace(',', '',  $targetLayers['percentage'][$index])) ?? 0,
                    'target_type_id' => $targetLayers['layer_target_type_id'][$index],
                    'sales_target_id' => $salesTarget->id,
                    'created_by' => auth()->id(),
                ]);
            }
        }
    }

    public function getTargetLayersData($salesTargetId)
    {
        $salesTarget = SalesTarget::findOrFail($salesTargetId);
        return response()->json([
            'success' => true,
            'data' => [
                'target_type' => $salesTarget->targetTypes,
                'target_layers' => $salesTarget->targetLayers
            ]
        ]);
    }
}
