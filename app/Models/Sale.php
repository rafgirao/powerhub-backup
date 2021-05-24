<?php

namespace App\Models;

use App\Services\Google;
use App\Services\Helper;
use App\Traits\AccountTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Notifications\Notifiable;
use App\Services\Hotmart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use stdClass;


class Sale extends Pivot
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    protected $appends = [
        'dtfh'
    ];

    /**
     * @var string
     */
    protected $table = 'sales';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account',
        'lead',
        'product',
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
    ];

    /**
     * @param array $projectsDetProducts
     * @param $project
     * @return mixed
     */
    public static function getSaleSummary(array $projectsDetProducts, $project)
    {
        return Sale::selectRaw('commission_currency, status, count(product) as count, sum(commission) as sum')
            ->whereIn('product', $projectsDetProducts)
            ->whereBetween('purchase_date', [
                date('Y-m-d', strtotime($project->start_at . ' - 1 days')),
                date('Y-m-d', strtotime($project->end_at . ' + 1 days'))
            ])
            ->groupBy('status', 'commission_currency')
            ->get();
    }

    /**
     * @param array $projectsDetProducts
     * @param $project
     * @return mixed
     */
    public static function getSaleSummaryDaily(array $projectsDetProducts, $project)
    {
        return Sale::selectRaw('commission_currency, status, product, date_format(purchase_date, "%Y-%m-%d") as date, count(product) as count, sum(commission) as sum')
            ->whereIn('product', $projectsDetProducts)
            ->whereBetween('purchase_date', [
                date('Y-m-d', strtotime($project->start_at . ' - 1 days')),
                date('Y-m-d', strtotime($project->end_at . ' + 1 days'))
            ])
            ->orderBy('date', 'ASC')
            ->groupBy('status', 'commission_currency', 'date', 'product')
            ->get();
    }

    /**
     * @return BelongsTo
     */
    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return HasOne
     */
    public function getLead(): HasOne
    {
        return $this->hasOne(Lead::class, 'id', 'lead');
    }

    /**
     * @return HasOne
     */
    public function getProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product');
    }

    public function getDtfhAttribute()
    {
        return Carbon::parse($this->purchase_date)->diffForHumans();
    }

    /**
     * @param $act
     * @param $datePreset
     */
    protected function hotmartSales($act, $datePreset)
    {
        $response = $this->getHotmartSales($act, $datePreset) ?? null;
        $integration = Integration::where('account', $act)->where('provider_name', 'Hotmart')->first();

        if ($integration === null) {
            return;
        }

        $total = isset($response->size) ? $response->size / 1000 : 0;

        for ($page = 1; $page < $total + 1; $page = $page + 1) {
            $sales = $this->getHotmartSales($act, $datePreset, 1000, $page)->data;

            foreach ($sales as $sale) {

                $lead = (isset($sale->buyer->email)
                    ? (Lead::where('account', $act)->where('email',
                            $sale->buyer->email)->first() ?? Lead::prepareHotmartLeads($act, $sale))
                    : Lead::prepareHotmartLeads($act, $sale));

                $product = (Product::where('account', $act)->where('gateway_product_id', $sale->product->id)
                        ->where('integration', $integration->id)
                        ->first()) ?? Product::prepareHotmartProducts($act, $sale);

                $this->prepareHotmartSales($act, $lead, $product, $sale);
            }
        }

    }

    /**
     * @param $act
     * @param $datePreset
     * @param null $rows
     * @param null $page
     * @return mixed|null
     */
    protected function getHotmartSales($act, $datePreset, $rows = null, $page = null)
    {

        $transactionStatus = 'WAITING_PAYMENT,APPROVED,PRINTED_BILLET,CANCELLED,CHARGEBACK,COMPLETE,UNDER_ANALISYS,EXPIRED,STARTED,PROTESTED,REFUNDED,OVERDUE';

        list($startDate, $endDate) = (new Helper)->datePreset($datePreset);

        $sales = (new Hotmart)->getHotmartSalesHistory($act, $startDate, $endDate, '', $rows, $page, '', '',
                $transactionStatus) ?? null;
        return $sales;
    }

    /**
     * @param $act
     * @param $lead
     * @param $product
     * @param $sale
     * @return mixed|null
     */
    protected function prepareHotmartSales($act, $lead, $product, $sale)
    {
        $account = $act;
        $lead = $lead->id;
        $product = $product->id;
        $transaction = $sale->purchase->transaction ?? null;
        $commission = $sale->commission->value ?? null;
        $commission_currency = $sale->commission->currencyCode ?? null;
        $price = (isset($sale->purchase->salesNature) and ($sale->purchase->salesNature === 'Co-producao')) ? ($sale->commission->value ?? null) : ($sale->purchase->price->value ?? null);
        $price_currency = $sale->purchase->price->currencyCode ?? null;
        $payment_type = $sale->purchase->paymentType ?? null;
        $payment_method = $sale->purchase->paymentMethod ?? null;
        $payment_mode = $sale->offer->paymentMode ?? null;
        $recurrence_number = $sale->purchase->recurrencyNumber ?? null;
        $warranty_refund = $sale->purchase->warrantyRefund ?? null;
        $installments_number = $sale->purchase->installmentsNumber ?? null;
        $affiliate = $sale->affiliate->name ?? null;
        $payment_engine = $sale->purchase->paymentEngine ?? null;
        $sales_nature = ($sale->purchase->salesNature ?? null);
        $coupon_code = $sale->purchase->couponCode ?? null;
        $offer = $sale->offer->key ?? null;
        $status = $sale->purchase->status ?? null;
        $purchase_date = isset($sale->purchase->orderDate) ? date("Y-m-d H:i:s",
            $sale->purchase->orderDate / 1000) : null;
        $confirmation_date = isset($sale->purchase->approvedDate) ? date("Y-m-d H:i:s",
            $sale->purchase->approvedDate / 1000) : null;

        return $this->updateOrCreateHotmartSales($account, $lead, $product, $transaction, $commission,
            $commission_currency, $price, $price_currency, $payment_type, $payment_method, $payment_mode,
            $recurrence_number, $warranty_refund, $installments_number, $affiliate, $payment_engine, $sales_nature,
            $coupon_code, $offer, $status, $purchase_date, $confirmation_date);
    }

    /**
     * @param $act
     * @param $lead
     * @param $product
     * @param $data
     * @return mixed|null
     */
    public function prepareWebhookHotmartSales($act, $lead, $product, $data)
    {
        $account = $act;
        $lead = $lead->id;
        $product = $product->id;
        $transaction = $data['payload']['transaction'] ?? null;
        $commission = $data['payload']['cms_vendor'] ?? null;
        $commission_currency = $data['payload']['currency'] ?? null;
        $price = ((isset($data['payload']['receiver_type'])) and $data['payload']['receiver_type'] === 'COPRODUCER')
            ? ($data['payload']['cms_vendor'] ?? null)
            : ($data['payload']['price'] ?? null);
        $price_currency = $data['payload']['currency'] ?? null;
        $payment_type = $data['payload']['payment_type'] ?? null;
        $payment_method = null;
        $payment_mode = $data['payload']['productOfferPaymentMode'] ?? null;
        $recurrence_number = $data['payload']['recurrency'] ?? null;
        $warranty_refund = $data['payload']['prod_name'] ?? null;
        $installments_number = $data['payload']['installments_number'] ?? null;
        $affiliate = null;
        $payment_engine = $data['payload']['payment_engine'] ?? null;
        $sales_nature = ((isset($data['payload']['receiver_type'])) and $data['payload']['receiver_type'] === 'COPRODUCER') ? 'Co-producao' : null;
        $coupon_code = null;
        $offer = $data['payload']['off'] ?? null;
        $status = $data['payload']['status'] ?? (isset($data['payload']['buyerVO']) ? 'ABANDONED' : null);
        $purchase_date = isset($data['payload']['purchase_date']) ? date("Y-m-d H:i:s",
            strtotime($data['payload']['purchase_date']))
            : (isset($data['payload']['buyerVO']) ? date("Y-m-d H:m:s") : null);
        $confirmation_date = isset($data['payload']['confirmation_purchase_date']) ? date("Y-m-d H:i:s",
            strtotime($data['payload']['confirmation_purchase_date'])) : null;

        return $this->updateOrCreateHotmartSales($account, $lead, $product, $transaction, $commission,
            $commission_currency, $price, $price_currency, $payment_type, $payment_method, $payment_mode,
            $recurrence_number, $warranty_refund, $installments_number, $affiliate, $payment_engine, $sales_nature,
            $coupon_code, $offer, $status, $purchase_date, $confirmation_date);
    }

    /**
     * @param $account
     * @param $lead
     * @param $product
     * @param $transaction
     * @param $commission
     * @param $commission_currency
     * @param $price
     * @param $price_currency
     * @param $payment_type
     * @param $payment_method
     * @param $payment_mode
     * @param $recurrence_number
     * @param $warranty_refund
     * @param $installments_number
     * @param $affiliate
     * @param $payment_engine
     * @param $sales_nature
     * @param $coupon_code
     * @param $offer
     * @param $status
     * @param $purchase_date
     * @param $confirmation_date
     * @return mixed
     */
    protected function updateOrCreateHotmartSales(
        $account,
        $lead,
        $product,
        $transaction,
        $commission,
        $commission_currency,
        $price,
        $price_currency,
        $payment_type,
        $payment_method,
        $payment_mode,
        $recurrence_number,
        $warranty_refund,
        $installments_number,
        $affiliate,
        $payment_engine,
        $sales_nature,
        $coupon_code,
        $offer,
        $status,
        $purchase_date,
        $confirmation_date
    ) {
        if (!$lead or !$product) {
            return null;
        }

        $dataIndex = [
            'account' => $account,
            'lead' => $lead,
            'product' => $product,
            'transaction' => $transaction,
        ];

        if (!$transaction) {
            unset($dataIndex['transaction']);
        }

        $dataToUpdate = [
            'commission' => $commission,
            'commission_currency' => $commission_currency,
            'price' => $price,
            'price_currency' => $price_currency,
            'payment_type' => $payment_type,
            'payment_method' => $payment_method,
            'payment_mode' => $payment_mode,
            'recurrence_number' => $recurrence_number,
            'warranty_refund' => $warranty_refund,
            'installments_number' => $installments_number,
            'affiliate' => $affiliate,
            'payment_engine' => $payment_engine,
            'sales_nature' => $sales_nature,
            'coupon_code' => $coupon_code,
            'offer' => $offer,
            'status' => $this->setSaleStatus($status),
            'purchase_date' => $purchase_date,
            'confirmation_date' => $confirmation_date,
        ];

        foreach ($dataToUpdate as $key => $data) {
            if (!$data) {
                unset($dataToUpdate[$key]);
            }
        }

        $saleOld = $this->where('account', $account)->where('lead', $lead)->where('product', $product)->where('status',
            'ABANDONED')->latest('created_at')->first();

        if (isset($saleOld) and ($purchase_date > $saleOld->purchase_date)) {
            unset($dataIndex['transaction']);
            $dataToUpdate['transaction'] = $transaction;
        }

        return $this->updateOrCreate(
            $dataIndex,
            $dataToUpdate
        );
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $stat
     * @return array|null
     */
    public function getSalesStats($act, $datePreset, $stat): ?array
    {
        list($startDate, $endDate) = (new Helper)->datePreset($datePreset);

        $currencies = (new Helper)->listCurrencies($act);

        foreach ($currencies as $currency) {

            $record = $this->where('account', $act)
                ->where('price_currency', $currency)
                ->where('purchase_date', '>=', $startDate)
                ->where('purchase_date', '<', $endDate)
                ->where(function (Builder $query) {
                    return $query->where('status', '=', 'APPROVED')
                        ->orWhere('status', '=', 'COMPLETED');
                });

            if ($stat === 'salesCount') {
                $record = $record->count();
            } elseif ($stat === 'salesValue') {
                $record = $record->sum('price');
            }
            $salesStat = new stdClass();;
            $salesStat->act = $act;
            $salesStat->stat = $stat;
            $salesStat->value = $record;
            $salesStat->currency = $currency;
            $salesStat->datePreset = $datePreset;
            $salesStats[] = $salesStat;
        }
        if (!isset($salesStats)) {
            return null;
        }
        return $salesStats;
    }


    /**
     * @param $act
     * @param $datePreset
     * @return array|null
     */
    public function getChartSumValues($act, $datePreset): ?array
    {
        list($startDate, $endDate) = (new Helper)->datePreset($datePreset);

        if (in_array($datePreset, ['Today', 'Yesterday'])) {
            $startDate = date('Y-m-d', strtotime("-7 days"));
            $endDate = date('Y-m-d', strtotime("1 days"));
        }

        $currencies = (new Helper)->listCurrencies($act);


        foreach ($currencies as $currency) {

            $records = DB::select(DB::raw("SELECT DATE_FORMAT(purchase_date, '%d/%m/%Y') as label,
                    	SUM(price) as value
                    FROM sales
                    WHERE account = :act AND price_currency = :price_currency AND
                    purchase_date >= :start_date AND purchase_date <= :end_date AND
                    (status = 'APPROVED' OR status = 'COMPLETED')
                    GROUP BY DATE_FORMAT(purchase_date, '%d/%m/%Y')
                    ORDER BY purchase_date ASC
                    ;"),
                ['act' => $act, 'price_currency' => $currency, 'start_date' => $startDate, 'end_date' => $endDate]);

            $chartStats["$currency"] = $records;
        }
        if (!isset($chartStats)) {
            return null;
        }
        return $chartStats;
    }

    /**
     * @param $act
     * @param $datePreset
     * @return array|null
     */
    public function getChartCountValues($act, $datePreset): ?array
    {
        list($startDate, $endDate) = (new Helper)->datePreset($datePreset);
        $currencies = (new Helper)->listCurrencies($act);


        if (in_array($datePreset, ['Today', 'Yesterday'])) {
            $startDate = date('Y-m-d', strtotime("-7 days"));
            $endDate = date('Y-m-d', strtotime("1 days"));
        }

        foreach ($currencies as $currency) {

            $records = DB::select(DB::raw("SELECT DATE_FORMAT(purchase_date, '%d/%m/%Y') as label,
                    	COUNT(status) as value
                    FROM sales
                     WHERE account = :act AND price_currency = :price_currency AND
                    purchase_date >= :start_date AND purchase_date <= :end_date AND
                    (status = 'APPROVED' OR status = 'COMPLETED')
                    GROUP BY DATE_FORMAT(purchase_date, '%d/%m/%Y')
                    ORDER BY purchase_date ASC
                    ;"),
                ['act' => $act, 'price_currency' => $currency, 'start_date' => $startDate, 'end_date' => $endDate]);

            $chartStats["$currency"] = $records;
        }
        if (!isset($chartStats)) {
            return null;
        }
        return $chartStats;
    }

    /**
     * @param $project
     * @param $datePreset
     * @return null
     * @throws Exception
     */
    public function updateSpreadsheet($project, $datePreset)
    {
        $act = $project->account;

        $getRefreshToken = (new Google)->getRefreshToken($act);
        if (!isset($getRefreshToken)) {
            return null;
        }

        $getAccessToken = (new Google)->getAccessToken($getRefreshToken, $act);
        if (!isset($getAccessToken)) {
            return null;
        }
        $projectsDet = $project->getProjectsDet->where('account', $act);

        foreach ($projectsDet as $projectDet) {
            if ($projectDet->key_type === 'App\Models\Product') {
                $projectsDetProducts[] = $projectDet->key_id;
            }
            if ($projectDet->key_type === 'App\Models\Sheet') {
                $projectsDetSheet = $projectDet;
            }
        }

        if (!isset($projectsDetProducts) or !isset($projectsDetSheet)) {
            return null;
        }

        $sheet = $projectsDetSheet->keyable;
        if (!isset($sheet)) {
            return null;
        }

        $dateCut = ($datePreset !== 0) ? Carbon::now()->subMinutes($datePreset) : $project->start_at;

        $sales = $this->where('updated_at', '>', $dateCut)
            ->whereIn('product', $projectsDetProducts)
            ->whereBetween('purchase_date', [$project->start_at, $project->end_at])
            ->with('getLead')->with('getProduct')->get();

        if (!isset($sales)) {
            return null;
        }

        $range = (new Google)->getSpreadsheetValues($getAccessToken, $sheet->sheet_id, 'A:A');

        foreach ($sales as $sale) {

            $row = [
                "'" . ($sale->id ?? null),
                ($sale->getLead->first_name ?? null) . " " . ($sale->getLead->last_name ?? null),
                $sale->getLead->email ?? null,
                "'" . ($sale->getLead->phone_number ? (new Helper)->prepareBrPhoneNumber($sale->getLead->phone_number) : null),
                $sale->transaction ?? null,
                $sale->getProduct->product_name ?? null,
                $sale->price_currency ?? "BRL",
                (new Helper)->brFormat($sale->price) ?? null,
                (new Helper)->brFormat($sale->commission) ?? null,
                $sale->status ?? null,
                "",
                $sale->purchase_date ?? null,
                Carbon::now()->format('Y-m-d H:i:s'),
                "Hotmart",
            ];

            $search = (new Google)->searchInSpreadsheet($range, $sale->id);

            if (!isset($search)) {
                $insertRows[] = $row;
            } else {
                $params = ['values' => [$row]];
                (new Google)->updateSpreadsheetValues($getAccessToken, $sheet->sheet_id, $search[0], $params);
            }
        }

        if (!isset($insertRows)) {
            return null;
        }

        $params = ['values' => $insertRows];

        (new Google)->insertSpreadsheetRow($getAccessToken, $sheet->sheet_id, 'Vendas!A:A', $params);

        if ($range->values[1][0] == "-") {

            $format = [
                "requests" => [
                    [
                        "deleteDimension" => [
                            "range" => [
                                "sheetId" => 0,
                                "dimension" => "ROWS",
                                "startIndex" => 1,
                                "endIndex" => 2
                            ]
                        ]
                    ]
                ]
            ];
            $update = (new Google)->batchUpdateSpreadsheetById($getAccessToken, $sheet->sheet_id, $format);
        }
    }

    /**
     * @param $status
     * @return string
     */
    public function setSaleStatus($status): string
    {
        $status = strtoupper($status);

        if (in_array($status, ['APPROVED','APPROVE'])) {
            return 'APPROVED';
        } elseif (in_array($status, ['CANCELLED', 'CANCELED'])) {
            return 'CANCELLED';
        } elseif (in_array($status, ['PRINTED_BILLET'])) {
            return 'PRINTED_BILLET';
        } elseif (in_array($status, ['COMPLETE', 'COMPLETED'])) {
            return 'COMPLETED';
        } elseif (in_array($status, ['WAITING_PAYMENT'])) {
            return 'WAITING_PAYMENT';
        } elseif (in_array($status, ['ABANDONED'])) {
            return 'ABANDONED';
        } elseif (in_array($status, ['CHARGEBACK'])) {
            return 'CHARGEBACK';
        } elseif (in_array($status, ['UNDER_ANALISYS', 'UNDER_ANALYSIS'])) {
            return 'UNDER_ANALYSIS';
        } elseif (in_array($status, ['EXPIRED'])) {
            return 'EXPIRED';
        } elseif (in_array($status, ['STARTED'])) {
            return 'STARTED';
        } elseif (in_array($status, ['PROTESTED'])) {
            return 'PROTESTED';
        } elseif (in_array($status, ['REFUNDED'])) {
            return 'REFUNDED';
        } elseif (in_array($status, ['OVERDUE'])) {
            return 'OVERDUE';
        } elseif (in_array($status, ['DISPUTE'])) {
            return 'DISPUTE';
        } elseif (in_array($status, ['DELAYED'])) {
            return 'DELAYED';
        }
        return 'UNDEFINED_' . $status;
    }

    /**
     * @param $status
     * @return string
     */
    public function getSaleStatus($status): string
    {
        if ($status === 'APPROVED') {
            return 'Aprovada';
        } elseif ($status === 'CANCELLED') {
            return 'Cancelada';
        } elseif ($status === 'PRINTED_BILLET') {
            return 'Boleto Impresso';
        } elseif ($status === 'COMPLETED') {
            return 'Completa';
        } elseif ($status === 'WAITING_PAYMENT') {
            return 'Aguardando Pgto';
        } elseif ($status === 'ABANDONED') {
            return 'Abandonada';
        } elseif ($status === 'CHARGEBACK') {
            return 'Chargeback';
        } elseif ($status === 'UNDER_ANALYSIS') {
            return 'Aguardando Análise';
        } elseif ($status === 'EXPIRED') {
            return 'Expirada';
        } elseif ($status === 'STARTED') {
            return 'Iniciada';
        } elseif ($status === 'PROTESTED') {
            return 'Protestada';
        } elseif ($status === 'REFUNDED') {
            return 'Reembolsada';
        } elseif ($status === 'OVERDUE') {
            return 'Vencida';
        } elseif ($status === 'DISPUTE') {
            return 'Disputa';
        } elseif ($status === 'DELAYED') {
            return 'Atrasada';
        }
        return $status;
    }

    public function getSaleStatusReport(): string
    {
        $status = $this->status;

        if ($status === 'APPROVED') {
            return 'Realizada';
        } elseif ($status === 'CANCELLED') {
            return 'Cancelada';
        } elseif ($status === 'PRINTED_BILLET') {
            return 'Boleto';
        } elseif ($status === 'COMPLETED') {
            return 'Realizada';
        } elseif ($status === 'WAITING_PAYMENT') {
            return 'Aguardando Pgto';
        } elseif ($status === 'ABANDONED') {
            return 'Abandonada';
        } elseif ($status === 'CHARGEBACK') {
            return 'Realizada';
        } elseif ($status === 'UNDER_ANALYSIS') {
            return 'Aguardando Análise';
        } elseif ($status === 'EXPIRED') {
            return 'Boleto';
        } elseif ($status === 'STARTED') {
            return 'Iniciada';
        } elseif ($status === 'PROTESTED') {
            return 'Realizada';
        } elseif ($status === 'REFUNDED') {
            return 'Realizada';
        } elseif ($status === 'OVERDUE') {
            return 'Realizada';
        } elseif ($status === 'DISPUTE') {
            return 'Realizada';
        } elseif ($status === 'DELAYED') {
            return 'Atrasada';
        }
        return $status;
    }

}
