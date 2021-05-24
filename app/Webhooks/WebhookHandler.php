<?php


namespace App\Webhooks;

use App\Models\Lead;
use App\Models\Product;
use App\Models\Sale;
use Spatie\WebhookClient\ProcessWebhookJob;


class WebhookHandler extends ProcessWebhookJob
{
    /**
     *
     */
    public function handle()
    {
        $data = json_decode($this->webhookCall, true);
        if (isset($data['payload']['hottok'])){
            $lead = (new Lead)->prepareWebhookHotmartLeads($data['account'], $data);
            $product = (new Product)->prepareWebhookHotmartProducts($data['account'], $data);
            $sale = (new Sale)->prepareWebhookHotmartSales($data['account'], $lead, $product, $data);

        }
    }

}
