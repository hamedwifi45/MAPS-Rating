<form action="{{route('serch.show')}}" method="get"> 
@csrf
@method("get")
<div class="flex flex-row p-5">
    <div class="w-6/12">
        <input id="address" name="address" type="text" autocomplete="on" class="p-2 w-full bg-gray-200 rounded-md" value="{{old('address')}}" placeholder="حدد العنوان">
        <div id="address-list"></div>
    </div>
    <div class="w-6/12">
        <select class="p-2 text-center mr-5 bg-gray-200 w-full rounded-md"  name="category">
            <option value="">حدد التصنيف </option>
            @include('includes\category_list')
        </select>
    </div>
    <div class="mr-5">
        <button type="submit" class="py-2 px-5 bg-indigo-500 hover:bg-gray-400 text-white mr-5 rounded-md">بحث</button>
    </div>
</div>
</form>
<section class="m-auto text-center">
    <div class="category mt-5 flex-row">
        <ul class=" ">
        @foreach($categories as $category)
        <li>
            <a href="{{ route('category.show', $category->slug) }}" class="bg-blue-900  text-white p-2 m-1 hover:bg-indigo-400"> {{ $category->title }}</a>    
        </li>
        @endforeach 
        </ul>
    </div>
</section>