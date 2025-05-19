{{-- Reusable Page Header --}}
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">{{ $pageTitle ?? 'Sample Page' }}</h1>
    <nav class="text-sm text-gray-500 mt-1">
        <ol class="list-reset flex">
            <li><a href="{{ route('participant.dashboard') }}" class="text-blue-600 hover:underline">Home</a></li>
            @if(!empty($breadcrumb))
                @foreach($breadcrumb as $label => $url)
                    <li><span class="mx-2">›</span></li>
                    @if($loop->last)
                        <li class="text-gray-700 font-medium">{{ $label }}</li>
                    @else
                        <li><a href="{{ $url }}" class="text-blue-600 hover:underline">{{ $label }}</a></li>
                    @endif
                @endforeach
            @endif
        </ol>
    </nav>
</div>
