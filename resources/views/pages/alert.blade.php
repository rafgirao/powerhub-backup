<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

Teste

</body>
{{--<script src="//cdn.jsdelivr.net/npm/notify@10"></script>--}}
<script src="https://powerhub.app/vendor/notify/notify.js"></script>
<script>
    // let data = fetch('https://powerhub.app/api/v1/notify/37ca1b90-a3c5-11eb-b732-d1f09573bc4d/sale')
    let data = fetch('https://powerhub.app/api/v1/notify/0067fa70-b2a8-11eb-ae16-bfd1a38ef5f3/sale')
    // let data = fetch('http://localhost/api/v1/notify/4f175f00-7b0a-11eb-a474-cb61603c55c6/sale')
        .then(res => { return res.json()})
        .then(data => {
            let i = 0;
            function myLoop() {
                let title = (data[i].get_lead.first_name
                    +" "
                    +data[i].get_lead.last_name
                    +" comprou "
                    +data[i].get_product.product_name
                    +" "+data[i].dtfh);
                let toastMixin = Swal.mixin({
                    toast: true,
                    icon: 'success',
                    position: 'bottom-left',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    heightAuto: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                setTimeout(function() {
                    toastMixin.fire({
                        title: title,
                        // text: title
                    });
                    i++;
                    if (i < 10) {
                        myLoop();
                    }
                }, 3000)
            }
            myLoop();
        });
</script>
