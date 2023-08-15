import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'

Alpine.plugin(Clipboard)

const getCurrentScheme = () => {
    if (!window.matchMedia) {
        return "light";
    }
    // Check if the dark-mode Media-Query matches
    if(window.matchMedia('(prefers-color-scheme: dark)').matches){
        return "dark";
    }
    return "light";
};

window.getCurrentScheme = getCurrentScheme();

Livewire.start()

