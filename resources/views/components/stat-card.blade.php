@php
    $colors = [
        'emerald' => [
            'bg' => 'bg-emerald-100',
            'text' => 'text-emerald-600',
            'dark' => 'text-emerald-900',
            'border' => 'border-emerald-100',
        ],
        'orange' => [
            'bg' => 'bg-orange-100',
            'text' => 'text-orange-600',
            'dark' => 'text-orange-900',
            'border' => 'border-orange-100',
        ],
        'blue' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-600',
            'dark' => 'text-blue-900',
            'border' => 'border-blue-100',
        ],
        'green' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-600',
            'dark' => 'text-green-900',
            'border' => 'border-green-100',
        ],
        'purple' => [
            'bg' => 'bg-purple-100',
            'text' => 'text-purple-600',
            'dark' => 'text-purple-900',
            'border' => 'border-purple-100',
        ],
    ];

    $c = $colors[$color] ?? $colors['emerald'];

    // SVG Icons
    $icons = [
        'document' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
        
        'clock' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        
        'refresh' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>',
        
        'check' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    ];
@endphp

<div class="bg-white rounded-xl shadow p-6 border {{ $c['border'] }}">
    <div class="flex items-center justify-between">
        <div>
            <p class="{{ $c['text'] }} text-sm font-medium">{{ $title }}</p>
            <p class="text-3xl font-bold {{ $c['dark'] }} mt-2">{{ $value }}</p>
        </div>

        <div class="w-12 h-12 {{ $c['bg'] }} rounded-lg flex items-center justify-center {{ $c['text'] }}">
            {!! $icons[$icon] ?? $icons['document'] !!}
        </div>
    </div>

    @if($subtitle)
        <p class="mt-3 text-sm {{ $c['text'] }}">{{ $subtitle }}</p>
    @endif
</div>
