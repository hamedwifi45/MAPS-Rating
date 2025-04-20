<x-app-layout>
    <x-slot name="header">
        @include('includes/header') 
    </x-slot>

    <div  class="container my-12 mx-auto md:px-12 bg-white p-5 border">
        <div id="cont" class="bg-blue-200 relative text-blue-600 py-3 px-3 rounded-lg" >
            
        </div>
        @if(session('success'))
            <x-alert color="blue" message="{{ session('success') }}" />
        @endif
        {{-- <form action="{{ route('report.store') }}" method="post" > --}}
            {{-- @csrf --}}
            <h4 class="mb-4 mt-4">بلغ عن موقع</h4>            
            <hr/>
            <div class="mt-4">
                <input type='text' class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" value="{{ rawurldecode(url()->previous()) }}" id="place_url" name="place_url" readonly/>
            </div> 
            <div class="">
                <input type='text' class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" placeholder="اسمك" id="name" name="name"/>
            </div>
            <div class="">
                <input type='text' class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400" placeholder="البريد الإلكتروني" id="email" name="email"/>
            </div>
            <br>
            <input type="submit" id="button" class="mt-3 bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none" value="إبلاغ">                          
        {{-- </form> --}}
    </div>
</x-app-layout>
<script>
    $(function(){
        console.log(1);

        $('#button').on('click' , function(){
            var place_url = $('#place_url').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var cont = $('#cont');
            console.log(cont);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : "{{route('report.store')}}",
                type : 'Post',
                data : {'place_url' : place_url , 'name' : name ,'email' : email}
            }).done(function(data){
                // console.log(data);
                cont.html(data);
            })
        })
    })
</script>