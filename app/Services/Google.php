<?php


namespace App\Services;

use App\Models\Integration;
use App\Models\IntegrationDet;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Log;
use Psr\Log\Test\LoggerInterfaceTest;


class Google
{
    /**
     * @param $act
     * @return string|null
     */
    public function getRefreshToken($act): ?string
    {
        if (!isset($act)) {
            return null;
        }

        $googleCredentials = (new Integration)->googleCredentials($act);

        if (!isset($googleCredentials)) {
            return null;
        }

        return Crypt::decryptString($googleCredentials->value);
    }

    /**
     * @param string $refreshToken
     * @param null $act
     * @return string|null
     */
    public function getAccessToken(string $refreshToken, $act = null): ?string
    {
        if (!isset($refreshToken)) {
            return null;
        }

        try {
            $response = Http::retry(3, 2000)
                ->post('https://oauth2.googleapis.com/token',
                    [
                        'client_id' => env('GOOGLE_CLIENT_ID'),
                        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                        'refresh_token' => $refreshToken,
                        'grant_type' => 'refresh_token'
                    ]
                )
                ->body();
        } catch (Exception $e) {
            $this->setStatusToInactive($e, $act);
        }

        if (!isset($response) or !$response) {
            return null;
        }

        return json_decode($response)->access_token;
    }

    /**
     * @param $accessToken
     * @param $endpoint
     * @param null $params
     * @return mixed|null
     */
    public function getGoogleData($accessToken, $endpoint, $params = null)
    {
        if (!isset($accessToken) or !isset($endpoint)) {
            return null;
        }

        $response = Http::retry(3, 2000)->withToken($accessToken)->get($endpoint, $params);

        if (!isset($response)) {
            return null;
        }

        return json_decode($response->body());
    }

    /**
     * @param $accessToken
     * @param $endpoint
     * @param $params
     * @return mixed|null
     */
    public function postGoogleData($accessToken, $endpoint, $params = null)
    {
        if (!isset($accessToken) or !isset($endpoint)) {
            return null;
        }

        $response = Http::retry(3, 2000)->withToken($accessToken)->post($endpoint, $params);
        sleep(1.1);

        if (!isset($response)) {
            return null;
        }

        return json_decode($response->body());
    }

    /**
     * @param $accessToken
     * @param $endpoint
     * @param null $params
     * @return mixed|null
     */
    public function putGoogleData($accessToken, $endpoint, $params = null)
    {
        if (!isset($accessToken) or !isset($endpoint)) {
            return null;
        }

        $response = Http::retry(3, 2000)->withToken($accessToken)->put($endpoint, $params);
        sleep(1.1);

        if (!isset($response)) {
            return null;
        }

        return json_decode($response->body());
    }

    /**
     * @param $accessToken
     * @param $name
     * @return mixed|null
     */
    public function createSpreadsheet($accessToken, $name)
    {
        $params = [
            'properties' => [
                'title' => $name,
                'locale' => 'pt_BR',
            ]
        ];

        return $this->postGoogleData($accessToken, 'https://sheets.googleapis.com/v4/spreadsheets', $params);
    }

    /**
     * @param $accessToken
     * @param $spreadsheetId
     * @return mixed
     */
    public function getSpreadsheetById($accessToken, $spreadsheetId)
    {
        return $this->getGoogleData($accessToken, 'https://sheets.googleapis.com/v4/spreadsheets/' . $spreadsheetId);
    }

    /**
     * @param $accessToken
     * @param $spreadsheetId
     * @param $range
     * @return mixed|null
     */
    public function getSpreadsheetValues($accessToken, $spreadsheetId, $range)
    {
        return $this->getGoogleData($accessToken,
            'https://sheets.googleapis.com/v4/spreadsheets/' . $spreadsheetId . '/values/' . $range);
    }

    /**
     * @param $accessToken
     * @param $spreadsheetId
     * @param $range
     * @param $params
     * @return mixed|null
     */
    public function updateSpreadsheetValues($accessToken, $spreadsheetId, $range, $params)
    {
        return $this->putGoogleData($accessToken,
            'https://sheets.googleapis.com/v4/spreadsheets/' . $spreadsheetId . '/values/' . $range .
            '?responseValueRenderOption=FORMATTED_VALUE&valueInputOption=USER_ENTERED&includeValuesInResponse=true',
            $params);
    }

    /**
     * @param $accessToken
     * @param $spreadsheetId
     * @param $range
     * @param $params
     * @return mixed|null
     */
    public function insertSpreadsheetRow($accessToken, $spreadsheetId, $range, $params)
    {
        return $this->postGoogleData($accessToken,
            'https://sheets.googleapis.com/v4/spreadsheets/' . $spreadsheetId . '/values/' . $range .
            ':append?responseValueRenderOption=FORMATTED_VALUE&valueInputOption=USER_ENTERED&includeValuesInResponse=true&insertDataOption=INSERT_ROWS',
            $params);
    }

    /**
     * @param $accessToken
     * @param $spreadsheetId
     * @param $params
     * @return mixed|null
     */
    public function batchUpdateSpreadsheetById($accessToken, $spreadsheetId, $params)
    {
        return $this->postGoogleData($accessToken,
            'https://sheets.googleapis.com/v4/spreadsheets/' . $spreadsheetId . ':batchUpdate', $params);
    }

    /**
     * @param $range
     * @param $index
     * @return array|null
     */
    public function searchInSpreadsheet($range, $index): ?array
    {
        if (!isset($range) and !isset($index)) {
            return null;
        }

        $alphabet = range('A', 'Z');
        $i = 0;

        foreach ($range->values as $row => $rowValues) {
            foreach ($rowValues as $col => $value) {
                if ($value == $index) {
                    $response[$i] = $alphabet[[$col][0]] . [$row + 1][0];
//                    $response[$i]['value'] = $value;
                    $i = $i + 1;
                }
            }
        }
        return ($response ?? null);
    }

    /**
     * @param string|null $accessToken
     * @param $sheet
     */
    public function updateSpreadsheet(?string $accessToken, $sheet): void
    {
        $linkWhats = '=ArrayFormula(IF(D1:D="N. Telefone";"Link WhatsApp";(IF(D1:D="";"";(IFERROR("https://wa.me/"&REGEXREPLACE(D1:D;"[^0-9]+";"")&"?text=Olá%20"&LEFT(TRIM(B1:B);FIND(" ";TRIM(B1:B))-1)&",%20tudo%20bem?";"https://wa.me/"&REGEXREPLACE(D1:D;"[^0-9]+";"")&"?text=Oi%20"&TRIM(B1:B)&",%20tudo%20bem?"))))))';

        $params = [
            'values' => [
                [
                    "Id",
                    "Nome Completo",
                    "Email do Comprador",
                    "N. Telefone",
                    "N. da Transação",
                    "Nome do Produto",
                    "Moeda",
                    "Preço",
                    "Comissão",
                    "Status Compra",
                    $linkWhats,
                    "Data da Compra",
                    "Atualizado em",
                    "Origem",
                    "Observações",
                    "Status Recuperação"
                ],
                ["-"],
            ]
        ];

        $update = (new Google)->updateSpreadsheetValues($accessToken, $sheet->sheet_id, 'A1', $params);

        $format = [
            "requests" => [
                [
                    "addSheet" => [
                        "properties" => [
                            "title" => "Resumo",
                            "gridProperties" => [
                                "rowCount" => 1,
                                "columnCount" => 1
                            ],
                            "tabColor" => [
                                "red" => 1.0,
                                "green" => 0.3,
                                "blue" => 0.4
                            ]
                        ]
                    ]
                ],
                [
                    "updateSheetProperties" => [
                        "properties" => [
                            "sheetId" => 0,
                            "title" => 'Vendas',
                        ],
                        "fields" => "title",
                    ]
                ],
                [
                    "repeatCell" => [
                        "range" => [
                            "sheetId" => 0,
                            "startRowIndex" => 0,
                            "endRowIndex" => 1,
                            "startColumnIndex" => 0,
                            "endColumnIndex" => 16,

                        ],
                        "cell" => [
                            "userEnteredFormat" => [
                                "backgroundColor" => [
                                    "red" => 0.0,
                                    "green" => 100.0,
                                    "blue" => 0.0
                                ],
                                "horizontalAlignment" => "LEFT",
                                "wrapStrategy" => "CLIP",
                                "textFormat" => [
                                    "foregroundColor" => [
                                        "red" => 1.0,
                                        "green" => 1.0,
                                        "blue" => 1.0
                                    ],
                                    "fontSize" => 10,
                                    "bold" => true
                                ]
                            ]
                        ],
                        "fields" => "userEnteredFormat(backgroundColor,textFormat,horizontalAlignment,wrapStrategy)"
                    ]
                ],
                [
                    "repeatCell" => [
                        "range" => [
                            "sheetId" => 0,
                            "startColumnIndex" => 0,
                            "endColumnIndex" => 16,
                        ],
                        "cell" => [
                            "userEnteredFormat" => [
                                "horizontalAlignment" => "LEFT",
                                "wrapStrategy" => "CLIP",
                            ]
                        ],
                        "fields" => "userEnteredFormat(wrapStrategy)"
                    ]
                ],
                [
                    "updateSheetProperties" => [
                        "properties" => [
                            "sheetId" => 0,
                            "gridProperties" => [
                                "frozenRowCount" => 1
                            ]
                        ],
                        "fields" => "gridProperties.frozenRowCount"
                    ]
                ],
                [
                    "addProtectedRange" => [
                        "protectedRange" => [
                            "range" => [
                                "sheetId" => 0,
                                "startColumnIndex" => 0,
                                "endColumnIndex" => 1,
                            ],
                            "description" => "Protecting total col",
                            "warningOnly" => true
                        ]
                    ],
                ],
                [
                    "addProtectedRange" => [
                        "protectedRange" => [
                            "range" => [
                                "sheetId" => 0,
                                "startColumnIndex" => 10,
                                "endColumnIndex" => 11,
                            ],
                            "description" => "Protecting total col",
                            "warningOnly" => true
                        ]
                    ],
                ],
            ]
        ];

        $update = (new Google)->batchUpdateSpreadsheetById($accessToken, $sheet->sheet_id, $format);

        $format2 = [
            "requests" => [
                [
                    "autoResizeDimensions" => [
                        "dimensions" => [
                            "sheetId" => 0,
                            "dimension" => "COLUMNS",
                            "startIndex" => 0,
                            "endIndex" => 16
                        ]
                    ]
                ],
                [
                    "updateCells" => [
                        "rows" => [
                            "values" => [
                                [
                                    "pivotTable" => [
                                        "source" => [
                                            "sheetId" => 0,
                                            "startRowIndex" => 0,
                                            "startColumnIndex" => 0,
                                            "endColumnIndex" => 16
                                        ],
                                        "rows" => [
                                            [
                                                "sourceColumnOffset" => 5,
                                                "showTotals" => true,
                                                "sortOrder" => "DESCENDING",
                                            ],
                                            [
                                                "sourceColumnOffset" => 6,
                                                "showTotals" => true,
                                                "sortOrder" => "DESCENDING",
                                            ],
                                            [
                                                "sourceColumnOffset" => 9,
                                                "showTotals" => false,
                                                "sortOrder" => "DESCENDING",
                                            ]
                                        ],
                                        "values" => [
                                            [
                                                "name" => "Quantidade",
                                                "summarizeFunction" => "COUNTA",
                                                "sourceColumnOffset" => 3
                                            ],
                                            [
                                                "name" => "Valor Total",
                                                "summarizeFunction" => "SUM",
                                                "sourceColumnOffset" => 7
                                            ],
                                            [
                                                "name" => "Comissão Total ",
                                                "summarizeFunction" => "SUM",
                                                "sourceColumnOffset" => 8
                                            ],

                                        ],
                                        "valueLayout" => "HORIZONTAL"
                                    ]
                                ]
                            ]
                        ],
                        "start" => [
                            "sheetId" => $update->replies[0]->addSheet->properties->sheetId,
                            "rowIndex" => 0,
                            "columnIndex" => 0
                        ],
                        "fields" => "pivotTable"
                    ]
                ]
            ]
        ];

        (new Google)->batchUpdateSpreadsheetById($accessToken, $sheet->sheet_id, $format2);
    }

    /**
     * @param Exception $e
     * @param $act
     */
    protected function setStatusToInactive(Exception $e, $act = null): void
    {
        $act = session()->get('account')->id ?? $act;

        $googleIntegration = (new Integration)
            ->where('account', $act)
            ->where('provider_name', 'Google')
            ->where('status', '<>', 0)
            ->first();

        $googleIntegrationDet = IntegrationDet::whereIntegration($googleIntegration->id)
                ->where('key', 'googleRefreshToken')
                ->where('status', '<>', 0)
                ->first() ?? null;

        $googleIntegration->status = 0;
        $googleIntegration->save();
        $googleIntegrationDet->status = 0;
        $googleIntegrationDet->save();

        Log::debug('Integração com o Google foi alterada para inativa');

        if (isset(session()->get('account')->id)) {
            session()->forget('modal');
            echo '<script>alert("A integração com o Google Drive expirou e precisa ser autorizada novamente. Autorize novamente...")</script>';
        }
    }
}
