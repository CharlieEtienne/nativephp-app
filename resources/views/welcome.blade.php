<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/js/app.js', 'resources/css/app.css'])
    </head>
    <body class="antialiased">
        <div class="relative flex justify-center min-h-screen bg-center bg-gray-100 dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <h2 class="text-center text-2xl font-semibold text-gray-800 mt-8 mb-12">Convert hours to decimal</h2>
                <livewire:hour2decimal-converter />
            </div>

        </div>

        @livewireScriptConfig

        <script>
            function noticesHandler() {
                return {
                    notices: [],
                    visible: [],
                    add(notice) {
                        notice.id = Date.now()
                        this.notices.push(notice)
                        this.fire(notice.id)
                    },
                    fire(id) {
                        this.visible.push(this.notices.find(notice => notice.id == id))
                        const timeShown = 2000 * this.visible.length
                        setTimeout(() => {
                            this.remove(id)
                        }, timeShown)
                    },
                    remove(id) {
                        const notice = this.visible.find(notice => notice.id == id)
                        const index = this.visible.indexOf(notice)
                        this.visible.splice(index, 1)
                    },
                }
            }
        </script>
    </body>
</html>
