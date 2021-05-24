<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N2455H2');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">

</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N2455H2"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Section 1 -->
<section id="home" class="w-full px-6 pb-12 antialiased bg-gradient-to-br from-indigo-600 to-indigo-500">
    <div class="mx-auto max-w-7xl">

        <nav class="relative z-50 h-24 select-none" x-data="{ showMenu: false }">
            <div class="container relative flex flex-wrap items-center justify-between h-24 mx-auto overflow-hidden font-medium border-b border-gray-200 md:overflow-visible lg:justify-center sm:px-4 md:px-2">
                <div class="flex items-center justify-start w-1/4 h-full pr-4">
                    <a href="/" class="inline-block py-4 md:py-0">
                        <span class="p-1 text-xl font-black leading-none text-white"><span>PowerHub</span><span class="text-white">.</span></span>
                    </a>
                </div>
                <div class="top-0 left-0 items-start hidden w-full h-full p-4 text-sm bg-gray-900 bg-opacity-50 md:items-center md:w-3/4 md:absolute lg:text-base md:bg-transparent md:p-0 md:relative md:flex" :class="{'flex fixed': showMenu, 'hidden': !showMenu }">
                    <div class="flex-col w-full h-auto overflow-hidden bg-indigo-500 rounded-lg md:bg-transparent md:overflow-visible md:rounded-none md:relative md:flex md:flex-row">
                        <a href="#_" class="inline-flex items-center block w-auto h-16 px-6 text-xl font-black leading-none text-gray-900 md:hidden">PowerHub<span class="text-indigo-600">.</span></a>
                        <div class="flex flex-col items-start justify-center w-full space-x-6 text-center lg:space-x-8 md:w-2/3 md:mt-0 md:flex-row md:items-center">
                            <a href="/#home" class="inline-block w-full py-2 mx-0 ml-6 font-medium text-left text-white md:ml-0 md:w-auto md:px-0 md:mx-2 lg:mx-3 md:text-center">Home</a>
                            <a href="/#howitwork" class="inline-block w-full py-2 mx-0 font-medium text-left text-white md:w-auto md:px-0 md:mx-2 hover:text-indigo-200 lg:mx-3 md:text-center">Como Funciona</a>
                            <a href="/#resources" class="inline-block w-full py-2 mx-0 font-medium text-left text-white md:w-auto md:px-0 md:mx-2 hover:text-indigo-200 lg:mx-3 md:text-center">Recursos</a>
{{--                            <a href="#_" class="absolute top-0 left-0 hidden py-2 mt-6 ml-10 mr-2 text-white lg:inline-block md:mt-0 md:ml-2 lg:mx-3 md:relative">--}}
{{--                                <svg class="inline w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>--}}
{{--                            </a>--}}
                        </div>
                        <div class="flex flex-col items-start justify-end w-full pt-4 md:items-center md:w-1/3 md:flex-row md:py-0">
                            <a href="/login" class="w-full px-6 py-2 mr-0 text-white md:px-0 lg:pl-2 md:mr-4 lg:mr-5 md:w-auto">Fazer Login</a>
                            <a href="/register" class="inline-flex items-center w-full px-6 py-3 text-sm font-medium leading-4 text-indigo-600 bg-white md:px-3 md:w-auto md:rounded-full lg:px-5 hover:bg-green-400 hover:text-white focus:outline-none md:focus:ring-2 focus:ring-0 focus:ring-offset-2 focus:ring-indigo-600">Cadastrar</a>
                        </div>
                    </div>
                </div>
                <div @click="showMenu = !showMenu" class="absolute right-0 flex flex-col items-center items-end justify-center w-10 h-10 bg-white rounded-full cursor-pointer md:hidden hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-700" x-show="!showMenu" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" x-cloak="">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6 text-gray-700" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak="">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </nav>

        <!-- Main Hero Content -->
        <div class="container max-w-lg px-4 py-32 mx-auto text-left md:max-w-none md:text-center">
            <h1 class="text-5xl font-extrabold leading-10 tracking-tight text-left text-white md:text-center sm:leading-none md:text-6xl lg:text-7xl"><span class="inline md:block">Bem-vindo ao seu novo</span> <span class="relative mt-2 text-transparent bg-clip-text text-indigo-200 md:inline-block">Business Intelligence</span></h1>
            <div class="mx-auto mt-5 text-indigo-200 md:mt-12 md:max-w-lg md:text-center lg:text-lg">Todas as informações do seu negócio digital em uma única plataforma!</div>
            <div class="flex flex-col items-center mt-12 text-center">
                <span class="relative inline-flex w-full md:w-auto">
                    <a href="/register" class="inline-flex items-center justify-center w-full px-8 py-4 text-base font-bold leading-6 text-white bg-green-400 border border-transparent rounded-full md:w-auto hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                        Iniciar Período Gratuito
                    </a>
{{--                    <span class="absolute top-0 right-0 px-2 py-1 -mt-3 -mr-6 text-xs font-medium leading-tight text-indigo-600 bg-white rounded-full">only $15/mo</span>--}}
                </span>
{{--                <a href="#" class="mt-3 text-sm text-indigo-100">Learn More</a>--}}
            </div>
        </div>
        <!-- End Main Hero Content -->

    </div>
</section>


{{--<!-- Section 1 -->--}}
{{--<section class="w-full px-3 antialiased bg-gradient-to-br from-indigo-600 to-indigo-500 lg:px-6">--}}
{{--    <div class="mx-auto max-w-7xl">--}}
{{--        <nav class="flex items-center w-full h-24 select-none" x-data="{ showMenu: false }">--}}
{{--            <div class="relative flex flex-wrap items-center justify-between w-full h-24 mx-auto font-medium md:justify-center">--}}
{{--                <a href="#_" class="w-1/4 py-4 pl-6 pr-4 md:pl-4 md:py-0">--}}
{{--                    <span class="p-1 text-xl font-black leading-none text-white select-none"><span>tails</span><span class="text-indigo-300">.</span></span>--}}
{{--                </a>--}}
{{--                <div class="fixed top-0 left-0 z-40 items-center hidden w-full h-full p-3 text-xl bg-gray-900 bg-opacity-50 md:text-sm lg:text-base md:w-3/4 md:bg-transparent md:p-0 md:relative md:flex" :class="{'flex': showMenu, 'hidden': !showMenu }">--}}
{{--                    <div class="flex-col w-full h-auto h-full overflow-hidden bg-white rounded-lg select-none md:bg-transparent md:rounded-none md:relative md:flex md:flex-row md:overflow-auto">--}}
{{--                        <div class="flex flex-col items-center justify-center w-full h-full mt-12 text-center text-indigo-700 md:text-indigo-200 md:w-2/3 md:mt-0 md:flex-row md:items-center">--}}
{{--                            <a href="#" class="inline-block px-4 py-2 mx-2 font-medium text-left text-indigo-700 md:text-white md:px-0 lg:mx-3 md:text-center">Home</a>--}}
{{--                            <a href="#" class="inline-block px-0 px-4 py-2 mx-2 font-medium text-left md:px-0 hover:text-indigo-800 md:hover:text-white lg:mx-3 md:text-center">Features</a>--}}
{{--                            <a href="#" class="inline-block px-0 px-4 py-2 mx-2 font-medium text-left md:px-0 hover:text-indigo-800 md:hover:text-white lg:mx-3 md:text-center">Blog</a>--}}
{{--                            <a href="#" class="inline-block px-0 px-4 py-2 mx-2 font-medium text-left md:px-0 hover:text-indigo-800 md:hover:text-white lg:mx-3 md:text-center">Contact</a>--}}
{{--                        </div>--}}
{{--                        <div class="flex flex-col items-center justify-end w-full h-full pt-4 md:w-1/3 md:flex-row md:py-0">--}}
{{--                            <a href="#_" class="w-full pl-6 mr-0 text-indigo-200 hover:text-white md:pl-0 md:mr-3 lg:mr-5 md:w-auto">Sign In</a>--}}
{{--                            <a href="#_" class="inline-flex items-center justify-center px-4 py-2 mr-1 text-base font-medium leading-6 text-indigo-600 whitespace-no-wrap transition duration-150 ease-in-out bg-white border border-transparent rounded-full hover:bg-white focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700">Sign Up</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div @click="showMenu = !showMenu" class="absolute right-0 z-50 flex flex-col items-end w-10 h-10 p-2 mr-4 rounded-full cursor-pointer md:hidden hover:bg-gray-900 hover:bg-opacity-10" :class="{ 'text-gray-400': showMenu, 'text-gray-100': !showMenu }">--}}
{{--                    <svg class="w-6 h-6" x-show="!showMenu" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" x-cloak="">--}}
{{--                        <path d="M4 6h16M4 12h16M4 18h16"></path>--}}
{{--                    </svg>--}}
{{--                    <svg class="w-6 h-6" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak="">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>--}}
{{--                    </svg>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </nav>--}}
{{--        <div class="container py-32 mx-auto text-center sm:px-4">--}}

{{--            <h1 class="text-4xl font-extrabold leading-10 tracking-tight text-white sm:text-5xl sm:leading-none md:text-6xl xl:text-7xl"><span class="block">Simplify the way you</span> <span class="relative inline-block mt-3 text-transparent text-white">design websites</span></h1>--}}
{{--            <div class="max-w-lg mx-auto mt-6 text-sm text-center text-indigo-200 md:mt-12 sm:text-base md:max-w-xl md:text-lg xl:text-xl">If you are ready to change the way you design websites, then you'll want to use our block builder to make it fun and easy!</div>--}}
{{--            <div class="relative flex items-center max-w-md mx-auto mt-12 overflow-hidden text-center rounded-full">--}}
{{--                <input type="text" name="email" placeholder="Email Address" class="w-full h-12 px-6 py-2 font-medium text-indigo-800 focus:outline-none">--}}
{{--                <span class="relative top-0 right-0 block">--}}
{{--                    <button type="button" class="inline-flex items-center w-32 h-12 px-8 text-base font-bold leading-6 text-white transition duration-150 ease-in-out bg-indigo-400 border border-transparent hover:bg-indigo-700 focus:outline-none active:bg-indigo-700">--}}
{{--                        Sign Up--}}
{{--                    </button>--}}
{{--                </span>--}}
{{--            </div>--}}
{{--            <div class="mt-8 text-sm text-indigo-300">By signing up, you agree to our terms and services.</div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}




<!-- Section 2 -->
<section id="howitwork" class="px-2 pt-32 bg-white md:px-0">
    <div class="container items-center max-w-6xl px-5 mx-auto space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-left text-gray-900 sm:text-5xl md:text-6xl md:text-center">
            <span class="block">Faça um Upgrade <span class="block mt-1 text-indigo-600 lg:inline lg:mt-0">Em seu Negócio Digital</span></span>
        </h1>
        <p class="w-full mx-auto text-base text-left text-gray-500 md:max-w-md sm:text-lg lg:text-2xl md:max-w-3xl md:text-center">
            Uma Plataforma premium que levará seu jogo para o próximo nível!
        </p>
        <div class="relative flex flex-col justify-center md:flex-row md:space-x-4">
            <a href="/register" class="flex items-center rounded-full w-full px-6 py-3 mb-3 text-lg text-white bg-indigo-600 rounded-md md:mb-0 hover:bg-indigo-700 md:w-auto">
                Teste Gratuitamente
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
{{--            <a href="#_" class="flex items-center px-6 py-3 text-gray-500 bg-gray-100 rounded-md hover:bg-gray-200 hover:text-gray-600">--}}
{{--                Learn More--}}
{{--            </a>--}}
        </div>
    </div>
    <div class="container items-center max-w-4xl px-5 mx-auto mt-16 text-center">
        <img src="https://cdn.devdojo.com/images/november2020/hero-image.png">
    </div>
</section>

<!-- Section 3 -->
<section id="section03" class="flex items-center justify-center py-10 text-white bg-white sm:py-16 md:py-24 lg:py-32">
    <div class="relative max-w-3xl px-10 text-center text-white auto lg:px-0">
        <div class="flex flex-col w-full md:flex-row">

            <!-- Top Text -->
            <div class="flex justify-between">
                <h1 class="relative flex flex-col text-6xl font-bold text-left text-indigo-600">
                    Desbloqueie
                    <span>Informações</span>
                    <span>Poderosas</span>
                </h1>
            </div>
            <!-- Right Image -->
            <div class="relative top-0 right-0 h-64 mt-12 md:-mt-16 md:absolute md:h-96">
                <img src="https://cdn.devdojo.com/images/december2020/designs3d.png" class="object-cover mt-3 mr-5 h-80 lg:h-96">
            </div>
        </div>

        <!-- Separator -->
        <div class="my-16 border-b border-gray-300 lg:my-24"></div>

        <!-- Bottom Text -->
        <h2 class="text-left text-gray-500 xl:text-xl">
            Nós desvendamos o segredo para você investir menos, ter menos trabalho, converter mais clientes e faturar mais.
        </h2>
    </div>
</section>

<!-- Section 4 -->
<section id="section04" class="w-full bg-white pt-7 pb-7 md:pt-20 md:pb-24">
    <div class="box-border flex flex-col items-center content-center px-8 mx-auto leading-6 text-black border-0 border-gray-300 border-solid md:flex-row max-w-7xl lg:px-16">

        <!-- Image -->
        <div class="box-border relative w-full max-w-md px-4 mt-5 mb-4 -ml-5 text-center bg-no-repeat bg-contain border-solid md:ml-0 md:mt-0 md:max-w-none lg:mb-0 md:w-1/2 xl:pl-10">
            <img src="https://cdn.devdojo.com/images/december2020/productivity.png" class="p-2 pl-6 pr-5 xl:pl-16 xl:pr-20 ">
        </div>

        <!-- Content -->
        <div class="box-border order-first w-full text-black border-solid md:w-1/2 md:pl-10 md:order-none">
            <h2 class="m-0 text-xl font-semibold leading-tight border-0 border-gray-300 lg:text-3xl md:text-2xl">
                Aumente a produtividade
            </h2>
            <p class="pt-4 pb-8 m-0 leading-7 text-gray-700 border-0 border-gray-300 sm:pr-12 xl:pr-32 lg:text-lg">
                Construa uma atmosfera produtiva em seu negócio.
            </p>
            <ul class="p-0 m-0 leading-6 border-0 border-gray-300">
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-yellow-300 rounded-full"><span class="text-sm font-bold">✓</span></span> Maximize a produtividade
                </li>
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-yellow-300 rounded-full"><span class="text-sm font-bold">✓</span></span> Deixe seus concorrentes para trás.
                </li>
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-yellow-300 rounded-full"><span class="text-sm font-bold">✓</span></span> Aplique as melhores técnicas de Growth Hacking
                </li>
            </ul>
        </div>
        <!-- End  Content -->
    </div>
    <div class="box-border flex flex-col items-center content-center px-8 mx-auto mt-2 leading-6 text-black border-0 border-gray-300 border-solid md:mt-20 xl:mt-0 md:flex-row max-w-7xl lg:px-16">

        <!-- Content -->
        <div class="box-border w-full text-black border-solid md:w-1/2 md:pl-6 xl:pl-32">
            <h2 class="m-0 text-xl font-semibold leading-tight border-0 border-gray-300 lg:text-3xl md:text-2xl">
                Tarefas Automatizadas
            </h2>
            <p class="pt-4 pb-8 m-0 leading-7 text-gray-700 border-0 border-gray-300 sm:pr-10 lg:text-lg">
                Economize tempo e dinheiro com nossas automações revolucionários.
            </p>
            <ul class="p-0 m-0 leading-6 border-0 border-gray-300">
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-yellow-300 rounded-full"><span class="text-sm font-bold">✓</span></span> Fluxo de tarefas automatizado
                </li>
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-yellow-300 rounded-full"><span class="text-sm font-bold">✓</span></span> Análise detalhada de seus dados
                </li>
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-yellow-300 rounded-full"><span class="text-sm font-bold">✓</span></span> Muitas integrações incríveis
                </li>
            </ul>
        </div>
        <!-- End  Content -->

        <!-- Image -->
        <div class="box-border relative w-full max-w-md px-4 mt-10 mb-4 text-center bg-no-repeat bg-contain border-solid md:mt-0 md:max-w-none lg:mb-0 md:w-1/2">
            <img src="https://cdn.devdojo.com/images/december2020/settings.png" class="pl-4 sm:pr-10 xl:pl-10 lg:pr-32">
        </div>
    </div>
</section>

<!-- Section 5 -->
<section id="resources" class="py-20 bg-white">
    <div class="container max-w-6xl mx-auto">
        <h2 class="text-4xl font-bold tracking-tight text-center">Nossos Recursos</h2>
        <p class="mt-2 text-lg text-center text-gray-600">Confira a lista completa de recursos impressionantes abaixo.</p>
        <div class="grid grid-cols-4 gap-8 mt-10 sm:grid-cols-8 lg:grid-cols-12 sm:px-8 xl:px-0">

            <div class="relative flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 overflow-hidden bg-indigo-100 sm:rounded-xl">
                <div class="p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/></svg>
                </div>
                <h4 class="text-xl font-medium text-gray-700">Planilha de Vendas Automatizada</h4>
                <p class="text-base text-center text-gray-500">Geração imediata de Planilha de Vendas e Recuperação automatizada e integrada ao Hotmart em tempo real.</p>
            </div>

            <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl">
                <div class="p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 8a3 3 0 0 1 0 6"></path><path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5"></path><path d="M12 8h0l4.524 -3.77a0.9 .9 0 0 1 1.476 .692v12.156a0.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8"></path></svg>
                </div>
                <h4 class="text-xl font-medium text-gray-700">Debriefing Inteligente</h4>
                <p class="text-base text-center text-gray-500">Tenha acesso a informações exclusivas e poderosas sobre seu lançamento ou campanha de vendas.</p>
            </div>

            <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-indigo-100 sm:rounded-xl">
                <div class="p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"></polyline><line x1="12" y1="12" x2="20" y2="7.5"></line><line x1="12" y1="12" x2="12" y2="21"></line><line x1="12" y1="12" x2="4" y2="7.5"></line><line x1="16" y1="5.25" x2="8" y2="9.75"></line></svg>
                </div>
                <h4 class="text-xl font-medium text-gray-700">Integração com ferramentas</h4>
                <p class="text-base text-center text-gray-500">Integre com as melhores ferramentas de Marketing Digital como Hotmart, Active Campaign, Google Sheets, Facebook Ads e Outros</p>
            </div>

            <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl">
                <div class="p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 10 10H12V2zM21.18 8.02c-1-2.3-2.85-4.17-5.16-5.18"/></svg>
                </div>
                <h4 class="text-xl font-medium text-gray-700">Dashboard de Métricas</h4>
                <p class="text-base text-center text-gray-500">Todas as Métricas consolidadas para te ajudar na produção e tomada de decisões do seu lançamento.</p>
            </div>

            <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-indigo-100 sm:rounded-xl">
                <div class="p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="9.5" y1="11" x2="9.51" y2="11"></line><line x1="14.5" y1="11" x2="14.51" y2="11"></line><path d="M9.5 15a3.5 3.5 0 0 0 5 0"></path><path d="M7 5h1v-2h8v2h1a3 3 0 0 1 3 3v9a3 3 0 0 1 -3 3v1h-10v-1a3 3 0 0 1 -3 -3v-9a3 3 0 0 1 3 -3"></path></svg>
                </div>
                <h4 class="text-xl font-medium text-gray-700">Concepção de Projeto</h4>
                <p class="text-base text-center text-gray-500">Uma ferramenta para você planejar corretamente todos os detalhes importantes do seu lançamento</p>
            </div>

            <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl">
                <div class="p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><g fill="none" fill-rule="evenodd"><path d="M18 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h5M15 3h6v6M10 14L20.2 3.8"/></g></svg>
                </div>
                <h4 class="text-xl font-medium text-gray-700">Deeplinks</h4>
                <p class="text-base text-center text-gray-500">Agora você pode criar e gerenciar deeplinks inteligentes para utilizar no seus lançamentos e campanhas.</p>
            </div>

        </div>
    </div>
</section>

<!-- Section 6 -->
<section id="section06" class="py-20 bg-gray-50">
    <div class="container items-center max-w-6xl px-4 px-10 mx-auto sm:px-20 md:px-32 lg:px-16">
        <div class="flex flex-wrap items-center -mx-3">
            <div class="order-1 w-full px-3 lg:w-1/2 lg:order-0">
                <div class="w-full lg:max-w-md">
                    <h2 class="mb-4 text-3xl font-bold leading-tight tracking-tight sm:text-4xl font-heading">O PowerHub tem as ferramentas e recursos que você precisa para crescer seu Negócio Digital!</h2>
                    <p class="mb-4 font-medium tracking-tight text-gray-400 xl:mb-6">Nunca foi tão fácil gerenciar seu negócio digital. O Powerhub vai te ajudar a:</p>
                    <ul>
                        <li class="flex items-center py-2 space-x-4 xl:py-3">
                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                            <span class="font-medium text-gray-500">Identificar rapidamente os pontos de melhoria</span>
                        </li>
                        <li class="flex items-center py-2 space-x-4 xl:py-3">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span class="font-medium text-gray-500">gerenciar métricas importantes sem sofrimento</span>
                        </li>
                        <li class="flex items-center py-2 space-x-4 xl:py-3">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span class="font-medium text-gray-500">Criar automações de tarefas sem esforço</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-full px-3 mb-12 lg:w-1/2 order-0 lg:order-1 lg:mb-0"><img class="mx-auto sm:max-w-sm lg:max-w-full" src="https://cdn.devdojo.com/images/november2020/feature-graphic.png" alt="feature image"></div>
        </div>
    </div>
</section>

<!-- Section 7 -->
<section id="section07" class="w-full px-8 py-16 bg-gray-100 xl:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col items-center md:flex-row">

            <div class="w-full space-y-5 md:w-3/5 md:pr-16">
                <p class="font-medium text-blue-500 uppercase">Construa seu Negócio Digital</p>
                <h2 class="text-2xl font-extrabold leading-none text-black sm:text-3xl md:text-5xl">
                    Mudando a forma como negócios digitais são gerenciados.
                </h2>
                <p class="text-xl text-gray-600 md:pr-16">Aprenda como gerenciar seu info-business de uma forma completamente diferente. Estamos revolucionando a forma como empresas digitais funcionam.</p>
            </div>

            <div class="w-full mt-16 md:mt-0 md:w-2/5">
                <div class="relative z-10 h-auto p-8 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7">
                    <h3 class="mb-6 text-2xl font-medium text-center">Quero o PowerHub</h3>
{{--                    <input type="text" name="email" class="block w-full px-4 py-3 mb-4 border border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none" placeholder="Email address">--}}
{{--                    <input type="password" name="password" class="block w-full px-4 py-3 mb-4 border border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none" placeholder="Password">--}}
                    <div class="block">
                        <a href="/register">
                            <button class="w-full px-3 py-4 font-medium rounded-full text-white bg-indigo-500 hover:bg-indigo-600 rounded-lg">Crie uma Conta</button>
                        </a>
                    </div>
                    <p class="w-full mt-4 text-sm text-center text-gray-500">Já tem uma conta? <a href="/login" class="text-blue-500 underline">Acesse neste link</a></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- AlpineJS Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.0/alpine.js"></script>

</body>
</html>
