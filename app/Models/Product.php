<?php

namespace App\Models;

use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Services\Hotmart;


class Product extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'account',
        'integration',
        'gateway_product_id',
        'product_name',
        'seller_id',
        'seller_name',
        'payment_mode',
        'cover_photo',
        'coproduction',
        'approved',
        'revised',
        'enabled',
        'deleted',
        'pixel',
        'smart_installment',
        'price',
        'price_currency',
        'payment_engine',
        'status',
        'gateway_creation_date',
    ];

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return MorphMany
     */
    public function getProjectDetByKey(): MorphMany
    {
        return $this->morphMany(ProjectDet::class, 'key');
    }

    /**
     * @return BelongsToMany
     */
    public function salesProductLeads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'sales', 'product', 'lead')
            ->using('App\Sale')
            ->withPivot(
                'transaction',
                'commission',
                'commission_currency',
                'price',
                'price_currency',
                'payment_type',
                'payment_method',
                'payment_mode',
                'recurrence_number',
                'warranty_refund',
                'installments_number',
                'affiliate',
                'payment_engine',
                'sales_nature',
                'coupon_code',
                'offer',
                'status',
                'purchase_date',
                'confirmation_date',
            )
            ->withTimestamps();
    }

    /**
     * @param $act
     */
    public function createProductsFromHotmart($act)
    {
        $response = (new Hotmart)->getHotmartProducts($act);
        $total = ($response->size ?? 0) / 100;

        for ($page = 1; $page < $total + 1; $page = $page + 1) {
            $products = (new Hotmart)->getHotmartProducts($act, 100, $page)->data;
            foreach ($products as $product) {
                $this->prepareHotmartProducts($act, $product);
            };
        }
    }

    /**
     * @param $product
     * @param $act
     * @param $source
     * @return mixed
     */
    protected function prepareHotmartProducts($act, $product)
    {
        $account = $act;
        $integration = Integration::where('account', $act)->where('provider_name', 'Hotmart')->first()->id;
        $gateway_product_id = $product->product->id;
        $product_name = $product->product->name ?? null;
        $seller_id = $product->sellerId ?? null;
        $seller_name = $product->sellerName ?? null;
        $payment_mode = $product->product->paymentMode ?? null;
        $cover_photo = $product->product->urlCoverPhoto ?? 'https://s3-sa-east-1.amazonaws.com/powerhub.app/media/product.png';
        $coproduction = $product->product->hasCoProduction ?? null;
        $approved = $product->product->approved ?? null;
        $revised = $product->product->revised ?? null;
        $enabled = $product->product->enabled ?? null;
        $deleted = $product->product->deleted ?? null;
        $pixel = $product->product->pixelEnabled ?? null;
        $smart_installment = $product->product->hasSmartInstallmentOffer ?? null;
        $price = $product->product->price->value ?? null;
        $price_currency = $product->product->price->currencyCode ?? null;
        $payment_engine = 'Hotmart';
        $status = $product->product->status ?? 'ACTIVE';
        $gateway_creation_date = isset($product->product->creationDate) ? date("Y-m-d H:i:s",
            $product->product->creationDate / 1000) : null;

        $product = $this->updateOrCreateHotmartProducts($account, $integration, $gateway_product_id, $product_name,
            $seller_id, $seller_name, $payment_mode, $cover_photo, $coproduction, $approved, $revised, $enabled,
            $deleted, $pixel, $smart_installment, $price, $price_currency, $payment_engine, $status,
            $gateway_creation_date);

        return $product;
    }

    /**
     * @param $act
     * @param $data
     * @return mixed|null
     */
    public function prepareWebhookHotmartProducts($act, $data)
    {
        $account = $act;
        $integration = Integration::where('account', $act)->where('provider_name', 'Hotmart')->first()->id;
        $gateway_product_id = $data['payload']['prod'] ?? ($data['payload']['productId'] ?? null);
        $product_name = $data['payload']['prod_name'] ?? ($data['payload']['productName'] ?? null);
        $seller_id = null;
        $seller_name = $data['payload']['producer_name'] ?? null;
        $payment_mode = $data['payload']['productOfferPaymentMode'] ?? null;
        $cover_photo = null;
        $coproduction = $data['payload']['has_co_production'] ?? null;
        $approved = null;
        $revised = null;
        $enabled = null;
        $deleted = null;
        $pixel = null;
        $smart_installment = null;
        $price = null;
        $price_currency = null;
        $payment_engine = 'Hotmart';
        $status = 'ACTIVE';
        $gateway_creation_date = null;

        return $this->updateOrCreateHotmartProducts($account, $integration, $gateway_product_id, $product_name,
            $seller_id, $seller_name, $payment_mode, $cover_photo, $coproduction, $approved, $revised, $enabled,
            $deleted, $pixel, $smart_installment, $price, $price_currency, $payment_engine, $status,
            $gateway_creation_date);
    }


    /**
     * @param $account
     * @param $integration
     * @param $gateway_product_id
     * @param $product_name
     * @param $seller_id
     * @param $seller_name
     * @param $payment_mode
     * @param $cover_photo
     * @param $coproduction
     * @param $approved
     * @param $revised
     * @param $enabled
     * @param $deleted
     * @param $pixel
     * @param $smart_installment
     * @param $price
     * @param $price_currency
     * @param string $payment_engine
     * @param string $status
     * @param $gateway_creation_date
     * @return mixed
     */
    public function updateOrCreateHotmartProducts(
        $account,
        $integration,
        $gateway_product_id,
        $product_name,
        $seller_id,
        $seller_name,
        $payment_mode,
        $cover_photo,
        $coproduction,
        $approved,
        $revised,
        $enabled,
        $deleted,
        $pixel,
        $smart_installment,
        $price,
        $price_currency,
        string $payment_engine,
        string $status,
        $gateway_creation_date
    ) {
        if (!$gateway_product_id){
            return null;
        }

        $dataToUpdate = [
            'product_name' => $product_name,
            'seller_id' => $seller_id,
            'seller_name' => $seller_name,
            'payment_mode' => $payment_mode,
            'cover_photo' => $cover_photo,
            'coproduction' => $coproduction,
            'approved' => $approved,
            'revised' => $revised,
            'enabled' => $enabled,
            'deleted' => $deleted,
            'pixel' => $pixel,
            'smart_installment' => $smart_installment,
            'price' => $price,
            'price_currency' => $price_currency,
            'payment_engine' => $payment_engine,
            'status' => $status,
            'gateway_creation_date' => $gateway_creation_date,
        ];

        foreach ($dataToUpdate as $key => $data){
            if (!$data) {
                unset($dataToUpdate[$key]);
            }
        }

        return self::updateOrCreate(
            [
                'account' => $account,
                'integration' => $integration,
                'gateway_product_id' => $gateway_product_id,
            ],
            $dataToUpdate
        );
    }

    /**
     * @param $coproduction
     * @return mixed|string
     */
    public function getCoproductionAttribute($coproduction)
    {
        if ($coproduction == 1) {
            $coproduction = 'Sim';
        } elseif ($coproduction == 0) {
            $coproduction = 'Não';
        }
        return $coproduction;
    }

    /**
     * @param $approved
     * @return mixed|string
     */
    public function getApprovedAttribute($approved)
    {
        if ($approved == 1) {
            $approved = 'Sim';
        } elseif ($approved == 0) {
            $approved = 'Não';
        }
        return $approved;
    }

    /**
     * @param $revised
     * @return mixed|string
     */
    public function getRevisedAttribute($revised)
    {
        if ($revised == 1) {
            $revised = 'Sim';
        } elseif ($revised == 0) {
            $revised = 'Não';
        }
        return $revised;
    }

    /**
     * @param $enabled
     * @return mixed|string
     */
    public function getEnabledAttribute($enabled)
    {
        if ($enabled == 1) {
            $enabled = 'Sim';
        } elseif ($enabled == 0) {
            $enabled = 'Não';
        }
        return $enabled;
    }

    /**
     * @param $deleted
     * @return mixed|string
     */
    public function getDeletedAttribute($deleted)
    {
        if ($deleted == 1) {
            $deleted = 'Sim';
        } elseif ($deleted == 0) {
            $deleted = 'Não';
        }
        return $deleted;
    }

    /**
     * @param $pixel
     * @return mixed|string
     */
    public function getPixelAttribute($pixel)
    {
        if ($pixel == 1) {
            $pixel = 'Sim';
        } elseif ($pixel == 0) {
            $pixel = 'Não';
        }
        return $pixel;
    }

    /**
     * @param $smartInstallment
     * @return mixed|string
     */
    public function getSmartInstallmentAttribute($smartInstallment)
    {
        if ($smartInstallment == 1) {
            $smartInstallment = 'Sim';
        } elseif ($smartInstallment == 0) {
            $smartInstallment = 'Não';
        }
        return $smartInstallment;
    }

    /**
     * @param $status
     * @return mixed|string
     */
    public function getStatusAttribute($status)
    {
        if ($status === 'ACTIVE') {
            $status = 'Ativado';
        } elseif ($status === 'PAUSED') {
            $status = 'Pausado';
        } elseif ($status === 'CHANGES_PENDING_ON_PRODUCT') {
            $status = 'Pendente';
        }
        return $status;
    }


}
