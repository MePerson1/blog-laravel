<x-app-layout>
    <div class ="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Wszystko') }}
        </h2>
    </x-slot>
    <form action="{{ route('dashboard') }}" method="get">
        <select class="mt-6 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  bg-gray-700 border-gray-600 placeholder-gray-400 text-dark " name="genre">
            @foreach (\App\Enums\Genre::TYPES as $type)
                @if( $type == "none")
                    <option value="">All</option>
                @else
                    <option value="{{ $type }}" >{{ ucfirst($type) }}</option>
                @endif
            @endforeach
        </select>
        <x-secondary-button>Filtruj</x-secondary-button>
    </form>
    @forelse ($blog as $bloge)
    <div style = "border: 4px ridge rgb(163, 163, 163)"class="mt-6 bg-white shadow-sm rounded-lg divide-y border-x-4 border-y-4 border-black">
        <div  class="gap-2 p-6 flex space-x-2">
            
            <div class="flex-1">
                @if($bloge->genre!='none')
                    <p style = "text-decoration-line: underline ">{{ucfirst($bloge->genre)}}</p>
                @endif
                @if($bloge->image!='')
                <img class="" src="{{ asset('blog_images/'.$bloge->image) }}" alt="Blog Image">
                @endif
                <div class="flex justify-between items-center">
               
                    <div style="border: black dotted 0.5px" class="rounded">
                        <span class="text-gray-800">{{ $bloge->user->name }}</span>
                        <small class="ml-2 text-sm text-gray-600">{{ $bloge->created_at->format('j M Y, g:i a') }}</small>
                        @unless ($bloge->created_at->eq($bloge->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                        @endunless
                    </div>
                </div>
                <div style="border: black solid 0.5px" class="mt-4 text-lg text-gray-900">
                    <p class="p-2">{{ $bloge->message }}</p>
                </div>
            </div>
        </div>
        
    
    
</div>
    @empty
            {{ 'So empty :(' }}
    @endforelse 
    {{ $blog->links() }}
</div>
</x-app-layout>
