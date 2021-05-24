<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<script type="text/javascript">
    window.onload = function () {

        let uri = {!!json_encode($uri)!!},
            desktopFallback = "https://youtube.com/" + uri,
            mobileFallback = "https://youtube.com/" + uri;

        if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            iOsApp = "vnd.youtube://www.youtube.com/" + uri,
                window.location = iOsApp;
            window.setTimeout(function () {
                window.location = mobileFallback;
            }, 25);
        } else if (/Android/i.test(navigator.userAgent)) {
            androidApp = "intent://www.youtube.com/" + uri + "#Intent;package=com.google.android.youtube;scheme=https;end";
            window.location = androidApp;
            window.setTimeout(function () {
                window.location = mobileFallback;
            }, 25);
        } else {
            window.location = desktopFallback;
        }

        function killPopup() {
            window.removeEventListener('pagehide', killPopup);
        }

        window.addEventListener('pagehide', killPopup);

    };
</script>
</body>
</html>
