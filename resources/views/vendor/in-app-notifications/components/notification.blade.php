@if (InAppNotification::hasMessage())
    <div id="flash"
        @class([
            'absolute top-0 right-0 mr-10 mt-6 px-4 py-4 text-base border rounded-lg font-regular text-white block z-50',
            'bg-red-500 border-red-500' => InAppNotification::isError(),
            'bg-green-500 border-green-500' => InAppNotification::isSuccess(),
            'bg-yellow-500 border-yellow-500' => InAppNotification::isWarning(),
            'bg-blue-500 border-blue-500' => InAppNotification::isInfo(),
        ])
        style="opacity:1;"
        role="alert"
    >
        <span class="font-medium text-white">
            {{ InAppNotification::print() }}
        </span>
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash');
            if(flash){
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500);
            }
        }, {{ InAppNotification::timeout() }});
    </script>
@endif
