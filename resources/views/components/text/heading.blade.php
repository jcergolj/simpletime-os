<div {{ $attributes->merge(['class' => 'font-medium [:where(&)]:text-base-800 ' . $sizeClasses()]) }}>{{ $slot }}</div>
