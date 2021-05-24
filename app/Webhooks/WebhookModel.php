<?php


namespace App\Webhooks;

use Exception;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\Models\WebhookCall;


class WebhookModel extends WebhookCall
{
    /**
     * @var array
     */
    public $guarded = [];

    /**
     * @var string[]
     */
    protected $casts = [
        'payload' => 'array',
        'exception' => 'array',
    ];

    /**
     * @param WebhookConfig $config
     * @param Request $request
     * @return WebhookCall
     */
    public static function storeWebhook(WebhookConfig $config, Request $request): WebhookCall
    {
        return (new WebhookCall)->create([
            'account' => $request->act,
            'name' => $request->name ?? $config->name,
            'payload' => $request->input(),
        ]);
    }

    /**
     * @param Exception $exception
     * @return $this
     */
    public function saveException(Exception $exception): self
    {
        $this->exception = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ];

        $this->save();

        return $this;
    }

    /**
     * @return $this
     */
    public function clearException(): self
    {
        $this->exception = null;

        $this->save();

        return $this;
    }
}
