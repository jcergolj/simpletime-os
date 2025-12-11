@props(['transitions' => true, 'scalable' => false, 'title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', [
            'transitions' => $transitions,
            'scalable' => $scalable,
            'title' => $title,
        ])
    </head>
    <body @class(["min-h-screen antialiased", "hotwire-native" => Turbo::isHotwireNativeVisit()]) style="background: var(--color-bg); position: relative; overflow-x: hidden;">
        <!-- Background gradient accents -->
        <div style="position: absolute; top: -10%; right: 5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(0, 102, 255, 0.08) 0%, transparent 65%); pointer-events: none; border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: -15%; left: 5%; width: 350px; height: 350px; background: radial-gradient(circle, rgba(249, 115, 22, 0.06) 0%, transparent 65%); pointer-events: none; border-radius: 50%; animation: float 10s ease-in-out infinite reverse;"></div>

        <div class="flex min-h-screen flex-col items-center justify-center px-2 py-12" style="position: relative; z-index: 1;">
            <x-in-app-notifications::notification />

            <div class="w-full max-w-lg px-4">
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center group">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover)); border-radius: 16px; display: flex; align-items: center; justify-center; margin-bottom: 12px; transition: all 0.3s var(--ease-smooth); box-shadow: 0 4px 16px rgba(0, 102, 255, 0.2);" class="group-hover:scale-110 group-hover:rotate-3">
                            <svg style="width: 36px; height: 36px; color: white;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="font-display text-xl text-gray-900">{{ config('app.name', 'SimpleTime') }}</span>
                    </a>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </div>

                <div class="card" style="padding: 40px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
