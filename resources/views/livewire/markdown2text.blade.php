<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{layout};

layout('components.layouts.app');

new class extends Component {
    public string $markdownInput   = '';
    public string $plainText = '';
    public string $htmlResult = '';

    public function markdown2Text(): void {
        $parser = new Parsedown();
        $this->htmlResult = $parser->text($this->markdownInput);
        $this->plainText = strip_tags($this->htmlResult);
    }
}

?>

<div>

    {{-- Title --}}
    <h2 class="text-center text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-8">Markdown to text</h2>

    {{-- Input --}}
    <textarea
        x-data="{ shiftPressed: false }"
        class="w-full p-2 rounded-lg dark:text-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700"
        placeholder="Type or paste some markdown..."
        wire:model.live="markdownInput"
        @keydown.shift="shiftPressed = true"
        @keyup.shift="shiftPressed = false"
        @keydown.enter.prevent="
           if (shiftPressed) {
                $event.target.value = $event.target.value + '\n'
                return;
            }
            $clipboard($wire.$get('plainText')); $dispatch('notice')"
        wire:keydown="markdown2Text"
        autofocus
        rows="4"
    ></textarea>

    {{-- Plain Text Result --}}
    <div class="flex w-full mt-6 mb-1">
        <span class="w-33 flex-1 text-left"></span>
        <label for="plainText" class="w-33 flex-1 text-center text-sm text-gray-500 dark:text-gray-400 font-semibold">Plain Text</label>
        <div class="w-33 flex-1 text-right">
            <div class="inline-block has-tooltip dark:text-gray-400 hover:dark:text-white">
                <span class="position-absolute tooltip rounded-full shadow-lg py-px px-2 bg-white dark:bg-gray-900 -mt-8 text-sm text-gray-800 dark:text-white" style="margin-left: -33px;">Copy</span>
                <svg @click="$clipboard($wire.$get('plainText')); $dispatch('notice')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard ml-auto cursor-pointer" viewBox="0 0 16 16">
                  <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                  <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                </svg>
            </div>
        </div>
    </div>
    <textarea
        id="plainText"
        class="w-full p-2 rounded-lg dark:text-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700"
        readonly
        rows="4"
    >{{ $plainText }}</textarea>

    {{-- HTML Result --}}
    <div class="flex w-full mt-6 mb-1">
        <span class="w-33 flex-1 text-left"></span>
        <label for="htmlResult" class="w-33 flex-1 text-center text-sm text-gray-500 dark:text-gray-400 font-semibold">HTML</label>
        <div class="w-33 flex-1 text-right">
            <div class="inline-block has-tooltip dark:text-gray-400 hover:dark:text-white">
                <span class="position-absolute tooltip rounded-full shadow-lg py-px px-2 bg-white dark:bg-gray-900 -mt-8 text-sm text-gray-800 dark:text-white" style="margin-left: -33px;">Copy</span>
                <svg @click="$clipboard($wire.$get('htmlResult')); $dispatch('notice')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard ml-auto cursor-pointer" viewBox="0 0 16 16">
                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                </svg>
            </div>
        </div>
    </div>
    <textarea
        id="htmlResult"
        class="w-full p-2 rounded-lg dark:text-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700"
        readonly
        rows="4"
    >{{ $htmlResult }}</textarea>

    {{-- How to --}}
    {{-- <div class="text-center text-gray-500 mt-6">Hit <code class="rounded bg-gray-200 p-1">Enter</code> to copy plain text result</div> --}}
    {{-- <div class="text-center text-gray-500 mt-1">Hit <code class="rounded bg-gray-200 p-1">Shift</code> + <code class="rounded bg-gray-200 p-1">Enter</code> to insert a new line</div> --}}

</div>
