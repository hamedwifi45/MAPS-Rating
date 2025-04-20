<x-app-layout>

    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50">
        <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-lg text-center">
            <h1 class="text-4xl font-bold text-red-600 mb-4">403</h1>
            <p class="text-gray-800 text-lg mb-6">
                {{$exception->getMessage()}}
            </p>
            <a href="{{ url('/') }}" class="px-4 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition">
                العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </div>

</x-app-layout>