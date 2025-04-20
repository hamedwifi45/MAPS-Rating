<x-app-layout>
    <x-slot name="header">
        @include('includes.header')
    </x-slot>
    <div class="container my-3 mx-auto px-4">
        <div class="flex flex-wrap mx-1 lg:mx-4">
            @foreach ($places as $place)
                <div class="my-1 px-1 w-full md:1/12 lg:my-4 lg:px-4 lg:w-1/3 ">
                    <article class="overflow-hidden rounded-lg shadow-lg bg-white">
                        <a href="{{ route('place.show', [$place->id, $place->slug]) }}">
                            <img alt="Placeholder" class="block h-auto flex-row w-full" src="{{ $place->image  }}">
                        </a>
                        <header class="items-center justify-between leading-tight p-2 md:p-4">
                            <h1 class="mb-3 text-base">
                                <a href="" class="no-underline hover:underline text-black">
                                    {{$place->name}}                                </a>
                            </h1>
                            <h3 class="text-xs">{{$place->address}}</h3>
                        </header>
                    </article>
                
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
