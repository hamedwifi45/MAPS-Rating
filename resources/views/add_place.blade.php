<x-app-layout>
    <x-slot name="header">
        @include('includes/header') 
    </x-slot>

    <div class="container my-12 mx-auto md:px-12 p-5">
        <h1 class="text-2xl p-5 mb-2">أضف موقعًا </h1>
        <hr class="mb-5"/>
        <form class="form-contact" action="{{ route('place.store') }}" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="">
                        <label for="name"> اسم الموقع</label>
                        <input type="text" class="w-full mt-2 border-emerald-100 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" name="name"/>
                    </div>
                    <div class="">
                        <label for="catg"> اختر التصنيف</label>
                        <select class="w-full mt-2 mb-6 px-4 py-2 text-center border border-emerald-100 rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" name="category_id" >
                            @include('includes\category_list')
                        </select>
                    </div>
                </div>
                <div class="">
                        <label for="overview"> نبذة عن الموقع</label>
                        <textarea type="text" class="w-full mt-2 border-emerald-100 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" name="overview" id="overview" rows="5"></textarea>
                </div>
                <div class="">
                        <label for="details"> اختر صورة </label>
                        <input type="file" name="image"  class=" border-emerald-100 form-control">
                </div>
                <div class="mt-2">
                    <div id="mapid" style="height: 350px;"></div>
                </div>
                <div class="mt-4">
                        <label for="address1"> العنوان</label>
                        <input type="text" class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" name="address" id="address1"/>
                </div>
                <div class="form-group col-lg-6">
                        <label for="long">خط الطول</label>
                        <input type="text" class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" name="longitude" id="longitude" value=""/>
                </div>
                <div class="form-group col-lg-6">
                    <label for="lat">خط العرض</label>            
                    <input type="text" class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" name="latitude" id="latitude" value=""/>
                </div>
                <button type="submit" class="mt-3 bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">إرسال</button>
            </form> 
        </div>
    </x-app-layout>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script type="text/javascript">
        var map = L.map('mapid');
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    
        // متغير لتخزين العلامة الحالية [[3]]
        var currentMarker = null;
    
        map.locate({setView: true, maxZoom: 13});
    
        map.on('locationfound', function(e) {
            L.marker(e.latlng).addTo(map)
                .bindPopup('موقعك الحالي')
                .openPopup();
        });
    
        map.on('locationerror', function() {
            var homsCoords = [34.7282, 36.7139];
            map.setView(homsCoords, 16);
            L.marker(homsCoords).addTo(map)
                .bindPopup('الافتراضي: حمص، سوريا')
                .openPopup();
        });
    
        map.on('mouseup', function(e) {
            // إزالة العلامة السابقة إذا وجدت [[3]]
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }
            
            $("#latitude").val(e.latlng.lat);
            $("#longitude").val(e.latlng.lng);
            
            // إنشاء علامة جديدة وتخزينها في المتغير [[3]]
            currentMarker = L.marker(e.latlng).addTo(map);
        });
    </script>
