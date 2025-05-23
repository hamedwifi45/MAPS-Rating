<x-app-layout>
    <x-slot name="header">
        @include('includes/header') 
    </x-slot>

    <div class="py-12">
        <div class="text-center mt-5 p-5">
            <h1 class="text-2xl mb-2">{{ $place->name }}</h1>
            <small>{{ $place->address }}</small>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-5 mt-5">
            <div class="col-span-2 bg-white shadow-lg rounded p-5">
                <div class="">
                    <h1 class="mb-4 text-2xl">نبذة عن الموقع</h1>
                    <p class="text-sm">{{ $place->overview }}</p>
                </div>
                <div class="mt-5 ">
                    <h3 class="mb-4 text-2xl">الموقع</h3>
                    <div id="mapid" style="height: 350px;"></div>
                    <input id="name" type="hidden" value="{{ $place->name }}">
                    <input id="latitude" type="hidden" value="{{ $place->latitude }}">
                    <input id="longitude" type="hidden" value="{{ $place->longitude }}">
                </div>
            </div>

            <div class="bg-white shadow-lg rounded p-4 h-52">
                <div class="p-5 bg-white shadow-sm">
                    <h3>{{ $place->user->name }}</h3>
                    <p></p>
                    <ul class="mt-3">
                        <li><i class="fa fa-envelope"></i>{{ $place->user->email }} </li>
                    </ul>
                </div>
                <hr/>
                <div class="p-3">
                @auth
                    <a href="{{ route('bookmark', $place->id) }}" class="border border-teal-500 text-xs text-teal-500 hover:bg-teal-500 hover:text-gray-100 rounded ml-3 p-1">
                        <span class=""><i class="bi {{ Auth::user()->alreadyBookmarked($place->id) ? 'bi-bookmark' : 'bi-bookmark-o' }} fa-lg"></i></span> علامة مرجعية 
                    </a>
                    <a href="{{ route('report.create') }}" class="border border-red-500 text-xs text-red-500 hover:bg-red-500 hover:text-gray-200 rounded p-1">
                        <span class=""><i class="fa fa-warning"></i></span>إبلاغ موقع مكرر 
                    </a>
                @else
                    <a href="{{ route('login') }}" class="border border-teal-500 text-xs text-teal-500 hover:bg-teal-500 hover:text-gray-100 rounded ml-3 p-1">
                        <span class=""><i class="fa fa-bookmark-o fa-lg"></i></span> علامة مرجعية 
                    </a>
                    <a href="{{ route('login') }}" class="border border-red-500 text-xs text-red-500 hover:bg-red-500 hover:text-gray-200 rounded p-1">
                        <span class=""><i class="fa fa-warning"></i></span>إبلاغ موقع مكرر 
                    </a>
                @endif
                </div>
            </div>

            <div class="bg-white col-span-2 shadow-lg rounded p-5 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Total Rating -->
                <div class="text-center space-y-3 relative z-10">
                    <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-rose-800">
                        {{ round($total,1) }}
                    </h1>
                    <div class="flex justify-center space-x-1 text-yellow-500 animate-pulse-slow">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $total ? 'bi-star-fill' : ($i == round($total) ? 'bi-star-half' : 'bi-star') }} text-2xl"></i>
                        @endfor
                    </div>
                    <div class="text-gray-600">{{ $place->reviews_count }} تقييم</div>
                </div>
            
                <!-- Detailed Ratings -->
                <div class="col-span-2 space-y-4">
                    @foreach([
                        'الخدمة' => $service_rating,
                        'الجودة' => $quality_rating,
                        'النظافة' => $cleanliness_rating,
                        'السعر' => $pricing_rating
                    ] as $label => $rating)
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between mb-2">
                                <span class="font-medium text-red-700">{{ $label }}</span>
                                <span class="text-sm text-gray-600">{{ round($rating,1) }}/5</span>
                            </div>
                            <div class="relative h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-rose-600 transition-all duration-300"
                                     style="width: {{ ($rating/5)*100 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            
                <!-- Divider Line -->
            </div>

            <div class="bg-white col-span-2 shadow-lg rounded p-5">
                @foreach($place->reviews as $review)
                <div class="row text-right bg-white p-4 shadow-sm">
                    <div class="review-block ">
                        <div class="grid grid-cols-3 p-5">
                            <div class="text-sm">
                                <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                                <div class="text-blue-400"><a href="#">{{$review->user->name}}</a></div>
                                <div class="review-block-date">{{$review->created_at->diffForHumans()}}</div>
                            </div>
                            <div class="col-span-2">
                                <div class="rating"> 
                                
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $review->avgRating())
                                    <span class="bi bi-star-fill" aria-hidden="true"></span>
                                    @elseif($i == round($review->avgRating())) 
                                    <span class="bi bi-star-half" style="transform: scaleX(-1); display: inline-block;" aria-hidden="true"></span>
                                    @else
                                    <span class="bi bi-star" aria-hidden="true"></span>
                                    @endif
                                @endfor 
                                </div>
                                <div class="review-block-description ">{{$review->review}}</div>

                                <div class="mt-3">
                                    @auth
                                    @can('like-review' , $review)
                                        
                                        <button id="like" type="button" data-id="{{$review->id}}" class="border rounded p-1 text-xs like {!!Auth::user()->alreadyliked($review->id) ? 'bg-blue-600' : 'bg-red-600' !!}">
                                                {!! Auth::user()->alreadyliked($review->id) ? '<i class="bi bi-hand-thumbs-down-fill" style="color: white"></i><small style="color: white"> إلغاء الإعجاب </small>' : '<i class="bi bi-hand-thumbs-up-fill" style="color: white"></i><small style="color: white"> أعجبني </small>' !!}
                                                <span style="color: white" class="font-bold">{{$review->likes_count}}</span>
                                        </button>
                                    @endcan
                                    @cannot('like-review', $review)
                                        <span class='bg-sky-600 px-2 py-1 border rounded-full text-xs text-white'>
                                            هذا التعليق تابع لك أساسًا
                                        </span>
                                    @endcannot
                                    @else
                                        <span class="border rounded text-xs p-1"><i class="fa fa-thumbs-up"></i> {{$review->likes_count}}</span>
                                    @endauth                                 
                                </div>                               
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
                @endforeach
            </div>

            <div  id="review-div" class="bg-white col-span-2 shadow-lg rounded p-5">
                @if(session('success'))
                    <x-alert color="blue" message="{{ session('success') }}"/>
                @elseif(session('fail'))
                    <x-alert color="red" message="{{ session('fail') }}"/>
                @endif 
                <h3 class="mb-4 mt-3">أضف مراجعة</h3>
                <hr/>
                <form class="form-contact" action="{{ route('review.store') }}" method="post">
                    @csrf
                    <div class="grid grid-cols-2 mt-5">
                        <div class="">
                            <div class="rating float-right" >
                                <h5>الخدمة</h5>
                                <input type="radio" id="rating_service1" name="service_rating" value="5" /><label for="rating_service1" title="ممتاز"></label>
                                <input type="radio" id="rating_service2" name="service_rating" value="4" /><label for="rating_service2" title="جيد جدًا"></label>
                                <input type="radio" id="rating_service3" name="service_rating" value="3" /><label for="rating_service3" title="متوسط"></label>
                                <input type="radio" id="rating_service4" name="service_rating" value="2" /><label for="rating_service4" title="سيء"></label>
                                <input type="radio" id="rating_service5" name="service_rating" value="1" /><label for="rating_service5" title="سيء للغاية"></label>
                            </div>
                        </div>
                        <div class="">
                            <div class="rating float-right">
                                <h5>الجودة</h5>
                                <input type="radio" id="rating_quality1" name="quality_rating" value="5" /><label for="rating_quality1" title="ممتاز"></label>
                                <input type="radio" id="rating_quality2" name="quality_rating" value="4" /><label for="rating_quality2" title="جيد جدًا"></label>
                                <input type="radio" id="rating_quality3" name="quality_rating" value="3" /><label for="rating_quality3" title="متوسط"></label>
                                <input type="radio" id="rating_quality4" name="quality_rating" value="2" /><label for="rating_quality4" title="سيء"></label>
                                <input type="radio" id="rating_quality5" name="quality_rating" value="1" /><label for="rating_quality5" title="سيء للغاية"></label>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="">
                            <div class="rating float-right">
                                <h5>النظافة</h5>
                                <input type="radio" id="rating_cleanliness1" name="cleanliness_rating" value="5" /><label for="rating_cleanliness1" title="ممتاز"></label>
                                <input type="radio" id="rating_cleanliness2" name="cleanliness_rating" value="4" /><label for="rating_cleanliness2" title="جيد جدًا"></label>
                                <input type="radio" id="rating_cleanliness3" name="cleanliness_rating" value="3" /><label for="rating_cleanliness3" title="متوسط"></label>
                                <input type="radio" id="rating_cleanliness4" name="cleanliness_rating" value="2" /><label for="rating_cleanliness4" title="سيء"></label>
                                <input type="radio" id="rating_cleanliness5" name="cleanliness_rating" value="1" /><label for="rating_cleanliness5" title="سيء للغاية"></label>
                            </div>
                        </div>
                        
                        <div class="">
                            <div class="rating float-right">
                                <h5>السعر</h5>
                                <input type="radio" id="rating_price1" name="pricing_rating" value="5" /><label for="rating_price1" title="ممتاز"></label>
                                <input type="radio" id="rating_price2" name="pricing_rating" value="4" /><label for="rating_price2" title="جيد جدًا"></label>
                                <input type="radio" id="rating_price3" name="pricing_rating" value="3" /><label for="rating_price3" title="متوسط"></label>
                                <input type="radio" id="rating_price4" name="pricing_rating" value="2" /><label for="rating_price4" title="سيء"></label>
                                <input type="radio" id="rating_price5" name="pricing_rating" value="1" /><label for="rating_price5" title="سيء للغاية"></label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="form-group">
                            <textarea class="border w-full" name="review" id="review" cols="30" rows="9"></textarea>
                        </div> 
                        @error('review')
                            <x-alert color="red" message="{{ $message }}" />
                        @enderror
                        <input class="form-control" name="place_id" id="place_id" type="hidden" value="{{ $place->id }}">
                        <button type="submit" class="mt-3 bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">إرسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    $(function(){
        $('button.like').on('click', function() {
            var review = $(this).data('id');
            var likebtn = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });  

            $.ajax({
                url:"{{ route('like.store') }}",
                type:'POST',
                data:{'review_id' : review}
            }).done(function(data){
                if(data) {
                    $.trim(likebtn.find('small').text()) == 'أعجبني' ? showUnLike(data) : showlike(data); 
                } else {
                    alert('لا يمكنك الإعجاب بهذه المراجعة');
                }
            });

            function showUnLike(count) {
                likebtn.html('<li class="fa fa-thumbs-down" style="list-style: none"></li> <small>' + ' إلغاء الإعجاب ' + '</small>' + count);
            }

            function showlike(count) {
                likebtn.html('<li class="fa fa-thumbs-up" style="list-style: none"></li> <small>' + ' أعجبني ' +'</small>'+ count );
            }

        })
    }); 
    
    var longitude = $('#longitude').val();
    var latitude = $('#latitude').val();
    
    var map = L.map('mapid', {
        center : [latitude , longitude],
        zoom : 16
    });
    
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
    L.marker([latitude, longitude]).bindPopup($('#name').val()).addTo(map).openPopup();
    
</script>

</x-app-layout>






