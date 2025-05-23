<x-app-layout>
    <x-slot name="header">
        @include('includes/header')
    </x-slot>

    <div class="py-12">
        @if(!$places->count())
            <div class="text-blue-900 px-6 py-4 rounded relative bg-gray-200 max-w-7xl mx-auto">
                <span class="inline-block align-middle mr-8">
                    لا يوجد مواقع ضمن هذا التصنيف.
                </span>
            </div>
        @else
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div>
                    @foreach($places as $place)
                        <div class="flex mb-5 bg-white">
                            <div class="flex-none w-48 relative">
                                <a href="{{ route('place.show', [$place->id, $place->slug]) }}">
                                    <img src="{{ $place->image  }}" alt="" class="absolute inset-0 w-full h-full object-cover" />
                                </a>
                            </div>
                            <div class="flex-auto p-6">
                                <div class="flex flex-wrap">
                                    <h1 class="flex-auto text-xl font-semibold">
                                        {{ $place->name }}
                                    </h1>
                                </div>
                                <div class="flex space-x-3 mb-4 text-sm font-medium mt-5">
                                    <div class="flex-auto flex space-x-3">
                                        {{ $place->address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="ml-3">
                    <div id="mapid" style="height: 500px"></div>
                </div>
            </div> {{-- ✅ أغلق الـ grid container --}}
        @endif {{-- ✅ ضع @endif هنا --}}
    </div> {{-- ✅ أغلق الـ py-12 container --}}
</x-app-layout> {{-- ✅ أغلق المكون الرئيسي مرة واحدة --}}

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  
    var longitude = {!! json_encode($places->pluck('longitude')->toArray(), JSON_UNESCAPED_UNICODE) !!};
    var latitude = {!! json_encode($places->pluck('latitude')->toArray(), JSON_UNESCAPED_UNICODE) !!};
    var name = {!! json_encode($places->pluck('name')->toArray(), JSON_UNESCAPED_UNICODE) !!};

    var map = L.map('mapid');
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

    var markers = [];
    for (var i = 0; i < longitude.length; i++) {
        if (latitude[i] !== undefined && longitude[i] !== undefined && name[i] !== undefined) {
             markers.push(L.marker([latitude[i], longitude[i]])
            .addTo(map)
            .bindPopup(name[i])
            );
        }
    }

    if (markers.length > 0) {
        var group = L.featureGroup(markers);
        map.fitBounds(group.getBounds());
    } else {
        map.setView([30.0444, 31.2357], 6);
    }
</script>
