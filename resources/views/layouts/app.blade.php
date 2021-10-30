<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        @livewireScripts
        @if (Auth::check())
            <script>
                window.Laravel = {};
                window.Laravel.user = {{ Auth::id() }}
            </script>
        @endif
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <div x-data="" x-init="$watch('$store.toast.openAlertBox', value => {
            if (value) {
                setTimeout(function () {
                    $store.toast.closeAlert();
                }, 3000)
            }
        })">
            <template x-if="$store.toast.isAlertOpen()">
                <div
                    class="fixed bottom-0 right-0"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                >
                    <div class="p-10">
                        <div class="flex items-center text-white text-sm font-bold px-4 py-3 rounded shadow-md" :class="$store.toast.alertBackgroundColor" role="alert">
                            <span x-html="$store.toast.alertMessage" class="flex"></span>
                            <button type="button" class="flex" @click="$store.toast.closeAlert()">
                                <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 ml-4"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </body>
</html>
