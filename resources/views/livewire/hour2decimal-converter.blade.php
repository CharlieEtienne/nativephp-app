

<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{layout};

layout('components.layouts.app');

new class extends Component {
    public string $timeInput    = '';
    public float  $decimalValue = 0.0;

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

<div
    {{-- x-data="{ show: false }" --}}
    {{-- x-transition:enter="transition duration-700" --}}
    {{-- x-transition:enter-start="opacity-0 -translate-y-4" --}}
    {{-- x-transition:enter-end="opacity-100 translate-y-0" --}}
    {{-- x-show="show" --}}
>
    <title>Hours to decimal</title>
    {{-- Title --}}
    <h2 class="text-center text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-8">Convert hours to decimal</h2>

    {{-- Input --}}
    <input type="text"
           class="block mx-auto text-center p-2 rounded-full dark:text-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700"
           placeholder="hh:mm"
           wire:model.live="timeInput"
           @keydown.enter="$clipboard($wire.$get('decimalValue')); $dispatch('notice')"
           wire:keydown="timeToDecimal"
           autofocus
    >

    {{-- Result --}}
    <div class="max-w-full break-words text-center my-8 text-3xl text-gray-600 dark:text-gray-400 font-semibold">{{ $decimalValue }}</div>

    {{-- How to --}}
    <div class="text-center text-gray-500 dark:text-gray-400">Hit <code class="rounded bg-gray-200 dark:bg-gray-700 p-1">Enter</code> to copy the decimal value</div>

</div>
