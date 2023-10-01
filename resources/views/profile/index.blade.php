<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Lista użytkowników') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <table class="table-fixed w-full text-white">
            <thead>
                <tr>
                    <th class="px-4 py-2">{{ __('Nazwa') }}</th>
                    <th class="px-4 py-2">{{ __('Email') }}</th>
                    <th class="px-4 py-2">{{ __('Stworzony') }}</th>
                    <th class="px-4 py-2">{{ __('Akcje') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">{{ $user->created_at}}</td>
                        <td class="border px-4 py-2 text-re">
                            @if($user->status == 1)
                                <a href="{{ route('profile.status.update' , ['user_id' =>$user->id,'status'=>0])}}">
                                    <button>Zablokuj</button>
                                </a>
                            @else
                            <a href="{{route('profile.status.update' , ['user_id' =>$user->id,'status'=>1])}}">
                                <button>Odblokuj</button>
                            </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
</x-app-layout>

