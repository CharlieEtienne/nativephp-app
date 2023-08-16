<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{layout};

layout('components.layouts.app');

new class extends Component {

}

?>

<div>
    <title>Météo</title>
    {{-- Title --}}
    <h2 class="text-center text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-8">Météo</h2>
    <script data-navigate-once>
        const getWidget = () => {
            let iframe = document.createElement( 'iframe' );

            iframe.width  = "100%";
            iframe.height = "465.2px";
            iframe.src    = "https://www.tomorrow.io/v1/widget?language=FR&unitSystem=METRIC&widgetType=upcoming&skin=" + window.getCurrentScheme + "&locationId=046323";

            document.getElementById( 'tomorrow-widget' ).replaceWith( iframe );
            return iframe;
        };

        document.addEventListener('livewire:initialized', () => {
            document.getElementById( 'tomorrow-widget' ).replaceWith( getWidget() );
        })

        document.addEventListener('livewire:navigated', () => {
            document.getElementById( 'tomorrow-widget' ).replaceWith( getWidget() );
        })
    </script>


    @persist('tomorrow-widget')
    <div id="tomorrow-widget"></div>
    @endpersist

</div>
