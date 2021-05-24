<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectDet;
use App\Models\Sale;

class HomeController extends Controller
{
    public function notify($projectUuid, $param)
    {
        $project = Project::whereUuid($projectUuid)->first();

        if ($param === 'sale') {
            $projectsDet = ProjectDet::whereProject($project->id)->where('key_type', 'App\Models\Product')->get();

            foreach ($projectsDet as $projectDet) {
                $products[] = $projectDet->keyable;
                $productIds[] = $projectDet->keyable->id;
                $productPrices[] = $projectDet->keyable->price;
            }

            $product = Product::whereIn('id', $productIds)->where('price', max($productPrices))->first();
            $response = Sale::whereProduct($product->id)
                ->whereBetween('purchase_date', [$project->start_at, $project->end_at])
                ->with('getLead')
                ->with('getProduct')
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        if ($param === 'lead') {
            $projectDet = ProjectDet::whereProject($project->id)->where('key_type', 'App\Models\Tag')->first();
            $tags = $projectDet->keyable;

            foreach ($projectsDet as $projectDet) {
                $tags[] = $projectDet->keyable;
                $tagIds[] = $projectDet->keyable->id;
            }

            $response = Sale::whereProduct($product->id)->whereBetween('purchase_date', [$project->start_at, $project->end_at])->with('getLead')->with('getProduct')->get();
            $response->verb = 'Se cadastrou no';
        }

        return response()->json($response);
    }
}
