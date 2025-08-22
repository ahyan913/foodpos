
                                                                                                                                                                                                                                                    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, max-scale=1.0 ">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <meta name="description" content="香港在線自助下單網 - 幫助飲食業"/>
    <meta name="og:title" content="香港網上在線下單網" />
    <meta name="og:url" content="{{ url("/") }}" />
    <meta name="og:website"  content="website" />
    <meta name="og:site_name"  content="site_name" />
    <meta name="og:description"  content="香港網上在線下單網,幫助飲食業提供網上客人自助下單服務 " />

    <meta name="keywords" content="Food online ordering"/>
    <script src="//cdn.tailwindcss.com"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="/js/tailwind.config.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="//code.jquery.com/jquery-3.6.0.js"></script>
    <script src="//code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <title>香港在線自助下單網</title>

    <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        opacity: 1;
    }
    </style>

</head>
<body>
    <div id="app" class="dark:bg-slate-800 dark:text-white pb-20">
    </div>

    <script type="text/javascript">
        const url = `<?= url("/"); ?>`;
    </script>
    @viteReactRefresh
    @vite(['resources/js/app.js'])
</body>
</html>

