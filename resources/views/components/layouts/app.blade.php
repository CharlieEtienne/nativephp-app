<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="antialiased">
<div
    class="relative flex justify-center min-h-screen bg-center bg-gray-100 dark:bg-gray-800 selection:bg-indigo-500 selection:text-white">

    <div class="max-w-full mx-auto p-6 lg:p-8">

        <nav class="flex items-center">
            <a class="text-center rounded-full text-sm py-2 px-3 mx-1 bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 hover:bg-gray-300" href="/meteo" wire:navigate>Météo</a>
            <a class="text-center rounded-full text-sm py-2 px-3 mx-1 bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 hover:bg-gray-300" href="/" wire:navigate>Hours to decimal</a>
            <a class="text-center rounded-full text-sm py-2 px-3 mx-1 bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 hover:bg-gray-300" href="/base64-decode" wire:navigate>Base64 Decode</a>
            <a class="text-center rounded-full text-sm py-2 px-3 mx-1 bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 hover:bg-gray-300" href="/markdown2text" wire:navigate>Markdown to text</a>
        </nav>

        {{$slot}}

        {{-- Notification --}}
        <div
            x-data="noticesHandler()"
            class="fixed inset-0 flex flex-col-reverse items-end justify-start h-screen w-screen"
            @notice.window="add($event.detail)"
            style="pointer-events:none">
            <template x-for="notice of notices" :key="notice.id">
                <div
                    x-show="visible.includes(notice)"
                    x-transition:enter="transition ease-in duration-200"
                    x-transition:enter-start="transform opacity-0 translate-y-2"
                    x-transition:enter-end="transform opacity-100"
                    x-transition:leave="transition ease-out duration-500"
                    x-transition:leave-start="transform translate-x-0 opacity-100"
                    x-transition:leave-end="transform translate-x-full opacity-0"
                    @click="remove(notice.id)"
                    class="rounded mx-4 my-6 h-16 flex items-center justify-center cursor-pointer"
                    style="pointer-events:all">
                    <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none rounded-full flex inline-flex"
                         role="alert">
                        <span class="flex rounded-full bg-indigo-500 px-2 py-1 font-bold mr-3">Copied!</span> <span
                            class="font-semibold mr-2 text-left flex-auto">Successfully copied to clipboard!</span>
                    </div>
                </div>
            </template>
        </div>

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
                this.notices.push( notice )
                this.fire( notice.id )
            },
            fire(id) {
                this.visible.push( this.notices.find( notice => notice.id == id ) )
                const timeShown = 2000 * this.visible.length
                setTimeout( () => {
                    this.remove( id )
                }, timeShown )
            },
            remove(id) {
                const notice = this.visible.find( notice => notice.id == id )
                const index  = this.visible.indexOf( notice )
                this.visible.splice( index, 1 )
            },
        }
    }
</script>
</body>
</html>
