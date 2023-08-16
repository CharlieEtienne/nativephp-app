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
    <title>Markdown to text</title>
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
                <x-copy-button @click="$clipboard($wire.$get('plainText')); $dispatch('notice')" />
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
                <x-copy-button @click="$clipboard($wire.$get('htmlResult')); $dispatch('notice')" />
            </div>
        </div>
    </div>
    <textarea
        id="htmlResult"
        class="w-full p-2 rounded-lg dark:text-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700"
        readonly
        rows="4"
    >{{ $htmlResult }}</textarea>

</div>
