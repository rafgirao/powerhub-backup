<?php


namespace App\Services;

use App\Models\Integration;
use Illuminate\Support\Facades\Http;


class Hotmart
{
    /**
     * @param $act
     * @return mixed|null
     */
    protected function getHotmartCredentials($act)
    {

        $hotmartCredentials = (new Integration)->hotmartCredentials($act);

        if (empty($hotmartCredentials->clientId) or empty($hotmartCredentials->clientSecret)) {
            return null;
        }

        $response = Http::retry(3, 700)->withHeaders(['Authorization' => $hotmartCredentials->basic])
            ->post('https://api-sec-vlc.hotmart.com/security/oauth/token?grant_type=client_credentials&client_id='
                . $hotmartCredentials->clientId . '&client_secret=' . $hotmartCredentials->clientSecret);

        if (!isset($response)) {
            return null;
        }

        return $response['access_token'];
    }

    /**
     * @param $act
     * @param $params
     * @return mixed|null
     */
    protected function getHotmartData($act, $params)
    {
        $hotmartAccessToken = self::getHotmartCredentials($act);

        if (!isset($hotmartAccessToken) or empty($hotmartAccessToken)) {
            return null;
        }

        $response = Http::retry(3,
            700)->withToken($hotmartAccessToken)->get('https://api-hot-connect.hotmart.com/' . $params);

        if (!isset($response)) {
            return null;
        }

        return json_decode($response->body());
    }

    /**
     * @param $act
     * @param null $startDate
     * @param null $endDate
     * @param null $productId
     * @param null $rows
     * @param null $page
     * @param null $email
     * @param null $transaction
     * @param null $transactionStatus
     * @param null $cpf
     * @param null $orderBy
     * @return mixed|null
     */
    public function getHotmartSalesHistory(
        $act,
        $startDate = null,
        $endDate = null,
        $productId = null,
        $rows = null,
        $page = null,
        $email = null,
        $transaction = null,
        $transactionStatus = null,
        $cpf = null,
        $orderBy = null
    ) {

        $startDate = ($startDate ? (strtotime($startDate) - strtotime('1970-01-01 00:00:00')) * 1000 : '');
        $endDate = ($endDate ? (strtotime($endDate) - strtotime('1970-01-01 00:00:00')) * 1000 + 86340000 : '');

        $params = 'reports/rest/v2/history?'
            . ($startDate ? '&startDate=' . $startDate : '')
            . ($endDate ? '&endDate=' . $endDate : '')
            . ($productId ? 'productId=' . $productId : '')
            . ($rows ? '&rows=' . $rows : '')
            . ($page ? '&page=' . $page : '')
            . ($email ? '&email=' . $email : '')
            . ($transaction ? '&transaction=' . $transaction : '')
            . ($transactionStatus ? '&transactionStatus=' . $transactionStatus : '')
            . ($cpf ? '&cpf=' . $cpf : '')
            . ($orderBy ? '&orderBy=' . $orderBy : '');

        return self::getHotmartData($act, $params);
    }

    /**
     * @param $act
     * @param null $startDate
     * @param null $endDate
     * @param $transactionStatus
     * @param null $productId
     * @param null $rows
     * @param null $page
     * @return mixed|null
     */
    public function getHotmartPurchaseDetails(
        $act,
        $startDate = null,
        $endDate = null,
        $transactionStatus,
        $productId = null,
        $rows = null,
        $page = null
    ) {
        $startDate = ($startDate ? (strtotime($startDate) - strtotime('1970-01-01')) * 1000 : '');
        $endDate = ($endDate ? (strtotime($endDate) - strtotime('1970-01-01')) * 1000 : '');

        $params = 'reports/rest/v2/purchaseDetails?'
            . ($startDate ? '&startDate=' . $startDate : null)
            . ($endDate ? '&endDate=' . $endDate : null)
            . ($transactionStatus ? '&transactionStatus=' . $transactionStatus : null)
            . ($productId ? 'productId=' . $productId : null)
            . ($rows ? '&rows=' . $rows : null)
            . ($page ? '&page=' . $page : null);

        return self::getHotmartData($act, $params);
    }

    /**
     * @param $act
     * @param null $rows
     * @param null $page
     * @return mixed|null
     */
    public function getHotmartProducts($act, $rows = null, $page = null)
    {
        $params = 'product/rest/v2/?' . ($rows ? '&rows=' . $rows : '') . ($page ? '&page=' . $page : '');
        return self::getHotmartData($act, $params);
    }

    /**
     * @param $act
     * @return mixed|null
     */
    public function getHotmartUsers($act)
    {
        $params = 'user/rest/v2?';
        return self::getHotmartData($act, $params);
    }
}
