<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="background: linear-gradient(to bottom, #2a1b30, #310080);" class="p-4 rounded-lg shadow-lg">
            <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">

                @csrf
                <label for="genre" class="block mb-2 text-sm font-medium text-white">Wybierz tematyke:</label>
                <select class=" mb-4 block p-0 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "name="genre" id="genre">
                    @foreach (\App\Enums\Genre::TYPES as $genre)
                        @if($genre == 'none')
                        <option value="none" {{ old('genre') == "none" ? 'selected' : '' }}>{{ 'None' }}</option>
                        @else
                        <option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : '' }}>{{ ucfirst($genre) }}</option>
                        @endif
                    @endforeach
                </select>
                <textarea
                name="message"
                placeholder="{{ __('Co tam, jak tam zycie?') }}"
                class=" block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                required
                >{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-white" for="file_input">Dodaj zdjecie (opcjonalnie)</label>
                    <input class="block w-2 text-sm  border  rounded-lg cursor-pointer  text-gray-400 focus:outline-none bg-gray-700 border-gray-600 placeholder-gray-400" aria-describedby="file_input_help" 
                        type="file"
                        name="image"
                        id="blog_image">
                    <p class="mt-1 text-sm text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                </div>
                <x-primary-button class="mt-4">{{ __('Dodaj') }}</x-primary-button>
            </form>
        </div>
        <form action="{{ route('blog.index') }}" method="get">
            <select class="mt-6  border  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  bg-gray-700 border-gray-600 placeholder-gray-400 text-black " name="genre">
                @foreach (\App\Enums\Genre::TYPES as $type)
                    @if( $type == "none")
                        <option value="">All</option>
                    @else
                        <option value="{{ $type }}" {{ ($genre == $type) ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endif
                @endforeach
            </select>
            <x-secondary-button>Filtruj</x-secondary-button>
        </form>
        @foreach ($blog as $bloge)
        @if ($bloge->user->is(auth()->user()))
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
                            @if ($bloge->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('blog.edit', $bloge)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('blog.destroy', $bloge) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('blog.destroy', $bloge)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <div style="border: black solid 0.5px" class="mt-4 text-lg text-gray-900">
                            <p class="p-2">{{ $bloge->message }}</p>
                        </div>
                    </div>
                </div>
                
            
            
        </div>
        @endif
        @endforeach
        {{ $blog->links() }}
    </div>
</x-app-layout>