<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{layout};

layout('components.layouts.app');

new class extends Component {
    public string $base64Input   = '';
    public string $base64Decoded = '';

    public function base64Decode(): void {
        $this->base64Decoded = utf8_encode(base64_decode(strtr($this->base64Input, '-_', '+/')));
    }
}

?>

<div>

    {{-- Title --}}
    <h2 class="text-center text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-8">Base64 decode</h2>

    {{-- Input --}}
    <textarea
        x-data="{ shiftPressed: false }"
        class="w-full p-2 rounded-lg dark:text-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700"
        placeholder="Type or paste a base64 encoded string"
        wire:model.live="base64Input"
        @keydown.shift="shiftPressed = true"
        @keyup.shift="shiftPressed = false"
        @keydown.enter.prevent="
           if (shiftPressed) {
                $event.target.value = $event.target.value + '\n'
                return;
            }
            $clipboard($wire.$get('base64Decoded')); $dispatch('notice')"
        wire:keydown="base64Decode"
        autofocus
        rows="4"
    ></textarea>

    {{-- Result --}}
    <div class="max-w-full break-words text-center my-8 text-lg text-gray-600 dark:text-gray-400 font-semibold">{{ $base64Decoded }}</div>

    {{-- How to --}}
    <div class="text-center text-gray-500 dark:text-gray-400">Hit <code class="rounded bg-gray-200 dark:bg-gray-700 p-1">Enter</code> to copy the decoded string</div>
    <div class="text-center text-gray-500 dark:text-gray-400 mt-1">Hit <code class="rounded bg-gray-200 dark:bg-gray-700 p-1">Shift</code> + <code class="rounded bg-gray-200 dark:bg-gray-700 p-1">Enter</code> to insert a new line</div>

</div>
