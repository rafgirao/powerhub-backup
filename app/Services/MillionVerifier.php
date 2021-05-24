<?php


namespace App\Services;

define('MM_API_KEY', env('MM_API_KEY', ''));
define("UPLOAD_URL",   "https://bulkapi.millionverifier.com/bulkapi/v2/upload");
define("PROGRESS_URL", "https://bulkapi.millionverifier.com/bulkapi/v2/fileinfo");
define("DOWNLOAD_URL", "https://bulkapi.millionverifier.com/bulkapi/v2/download");

use Illuminate\Support\Facades\Http;

class MillionVerifier
{
    /**
     * @param $email
     * @return string
     */
    public function singleEmailVerifier($email): ?string
    {
        $response = Http::retry(3, 100)->get("https://api.millionverifier.com/api/v3/?api=".MM_API_KEY."&email=$email");

        if (!isset($response)) {
            return null;
        }

        $response = json_decode($response->body());

        dd($response);

//        $j = json_decode(file_get_contents("https://api.millionverifier.com/api/v3/?api=".MM_API_KEY."&email=$email"));

        switch($response->resultcode) {
            case 1:
                $result = "Email Ok";
                break;
            case 2:
                $result = "Catch All";
                break;
            case 3:
                $result = "Unknown";
                break;
            case 4:
                $result = "Error: ".$response->error;
                break;
            case 5:
                $result = "Disposable";
                break;
            case 6:
                $result = "Invalid";
                break;
        }

        return $result;
    }

    /**
     *
     */
    public function bulkEmailVerifier()
    {
        $key=@$_POST["key"];
        if (!$key) $key=@$_GET["key"];

        $file_id = @$_GET["file_id"];

        if (@$_FILES['file_contents']) {
            $cFile = curl_file_create($_FILES['file_contents']['tmp_name'], $_FILES['file_contents']['type'], $_FILES['file_contents']['name']);
            $settings['file_contents'] = $cFile;
            $settings['key'] = $key;
            $ch = curl_init(UPLOAD_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $settings);
            $res = curl_exec($ch);
            curl_close($ch);
            $o = @json_decode($res);
            $error = @$o->error;
            $file_id = @$o->file_id;
            if (!$error) {
                header("Location: ".$_SERVER['QUERY_STRING']."?file_id=$file_id&key=$key");
                exit;
            }
        } elseif (@$file_id) {
            $res = file_get_contents(PROGRESS_URL."?key=$key&file_id=$file_id");
            $o = @json_decode($res);
        }

        if (!@$error && @$file_id) {
            echo "<pre>".json_encode($o, JSON_PRETTY_PRINT)."</pre>";
            if (!in_array($o->status,['finished', 'canceled'])) {
                echo '<meta http-equiv="refresh" content="1">auto refresh...';
            } else {
                $url = DOWNLOAD_URL."?key=$key&file_id=$file_id&filter=";
                ?>
                Download reports:<br>
                <li><a href="<?php echo $url?>ok">Ok only</a>
                <li><a href="<?php echo $url?>ok_and_catch_all">Ok &amp; Catch All</a>
                <li><a href="<?php echo $url?>unknown">Unknown only</a>
                <li><a href="<?php echo $url?>invalid">Invalid only</a>
                <li><a href="<?php echo $url?>all">Full report</a>
                <?php
            }
        }

        if (@$error) {
            echo "<pre>Error: $error</pre>";
        }

        if (!@$file_id) { ?>
            <form method="post" enctype="multipart/form-data">
                <table border="1" cellpadding="20" cellspacing="0">
                    <tr><th>Key</th><td><input name="key" value="<?php echo $key; ?>" placeholder="your api key"></td></tr>
                    <tr><th>File</th><td><input type="file" name="file_contents"></td></tr>
                    <tr><td colspan="2" align="center"><input type="submit" value="Verify"></td></tr>
                </table>
            </form>
            <?php
        }
    }

}
