<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        {{-- <link rel="stylesheet" href="resources/css/style.css"> --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        @livewireStyles
        <style>

    /* تحسينات مخصصة للخريطة */
    #mapid {
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        border-radius: 20px;
        overflow: hidden;
    }
    
    /* تأثيرات التحريك */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

            body{
    font-family: customFont;
}

@font-face {
    font-family: "customFont";
    src: url('JF-Flat-regular.ttf');
}

.bg ,footer{
  background:#0F203C;
}

.image{
  height:200px;
}

.category ul li {
    display: inline-block;
    margin-bottom:5px;
}

.category ul li a {
  border: none;
  border-radius: 5px;
  font-size: 14px;
  color: #fff;
  font-weight: #000;
  padding: 5px 19px;
  display: inline-block;
  margin: 0 3px;
  -webkit-transition: 0.3s;
  -moz-transition: 0.3s;
  -o-transition: 0.3s;
  transition: 0.3s;
  cursor: pointer;
}


.v_line {
  border-left: 1px solid rgb(240, 240, 235);
  height: 190;
}

/******************************************* */
.rating  {
  color:gold;
}

.rating > h5 {
  color:rgb(87, 83, 83);
}

.rating:not(:checked) > input {
  display:none;
  cursor: pointer;
}

.rating:not(:checked) > label:before {
  content: '★';
}

.rating:not(:checked) > label {
  float:left;
  cursor:pointer;
  font-size:160%;
  color:#ddd;
}

.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
    color: gold;
}

.rating > input:checked ~ label {
    color: gold;
}

#place_url {
  text-align: left;
  unicode-bidi: plaintext;
}    

#addressList {
  cursor:pointer;
}


        </style>
    </head>
    <body dir="rtl" class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header  class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script>
          $(function () {
            // console.log(21);
            $('#address').on('keyup' , function(){
              console.log(21);
              var address = $(this).val();
              $('#address-list').fadeIn(); 
              $.ajax({
                url : "{{ route('auto')}}",
                type : "Get" , 
                data: {"address" : address }
              }).done(function(data){
                $('#address-list').html(data)
              })
            })
            $('#address-list').on('click', 'li', function(){  
                    $('#address').val($(this).text());  
                    $('#address-list').fadeOut();  
                }); 
          });
        </script>
    </body>
</html>
