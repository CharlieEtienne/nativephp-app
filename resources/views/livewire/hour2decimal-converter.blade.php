<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $timeInput    = '';
    public float  $decimalValue = 0.0;
    public bool   $copySuccess  = false;

    public function timeToDecimal(): void {
        $timeInput = preg_replace('/h/', ':', $this->timeInput);

        // Extract the valid characters for hours and minutes only
        preg_match('/^(\d{1,2})[:h]?(\d{0,2})/', $timeInput, $matches);

        if( count($matches) >= 2 ) {
            $hours   = intval($matches[ 1 ]);
            $minutes = isset($matches[ 2 ]) ? intval(substr($matches[ 2 ], 0, 2)) : 0;

            // Convert minutes in decimal number between 0 and 59
            $minutesDecimal     = $minutes / 60;
            $this->decimalValue = number_format(( $hours + $minutesDecimal ), 2);
        } else {
            $this->decimalValue = 0.0;
        }
    }
}

?>

<div>

    {{-- Input --}}
    <input type="text"
           class="text-center w-full p-2 rounded-full border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700"
           placeholder="hh:mm"
           wire:model.live="timeInput"
           @keydown.enter="$clipboard($wire.$get('decimalValue')); $dispatch('notice')"
           wire:keydown="timeToDecimal"
           autofocus
    >

    {{-- Result --}}
    <div class="text-center my-8 text-3xl text-gray-600 font-semibold">{{ $decimalValue }}</div>

    {{-- How to --}}
    <div class="text-gray-500">Hit <code class="rounded bg-gray-200 p-1">Enter</code> to copy the decimal value</div>

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
                <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none rounded-full flex inline-flex" role="alert">
                    <span class="flex rounded-full bg-indigo-500 px-2 py-1 font-bold mr-3">Copied!</span>
                    <span class="font-semibold mr-2 text-left flex-auto">Successfully copied <code class="rounded-full bg-indigo-700 p-1">{{$this->decimalValue}}</code> to clipboard!</span>
                </div>
            </div>
        </template>
    </div>


</div>
