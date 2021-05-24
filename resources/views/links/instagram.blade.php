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
            desktopFallback = "https://www.instagram.com/" + uri,
            mobileFallback = "https://www.instagram.com/" + uri;

        if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            iOsApp = uri.includes("live") ? "instagram://live?username=" + uri.replace("/live", "") : ("instagram://user?username=" + uri.replace("/", "")),
                window.location = iOsApp;
            window.setTimeout(function () {
                window.location = mobileFallback;
            }, 25);
        } else if (/Android/i.test(navigator.userAgent)) {
            let androidApp = "intent://www.instagram.com/" + uri + "#Intent;package=com.instagram.android;scheme=https;end";
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
