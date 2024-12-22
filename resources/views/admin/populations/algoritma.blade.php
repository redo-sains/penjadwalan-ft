@extends('admin.layout.layout')
@section('main')
    <div class="flex flex-col flex-1">
        @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Edit Pengaturan Algoritma
                </h2>
                <form class="grid grid-cols-2" action="{{ route('update_pengaturan_algoritma') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Batas Umur Lantai 1</span>
                            <!-- focus-within sets the color for the icon when input is focused -->
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $pengaturan->umur }}" name="umur"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="Masukan Batas Umur" required />
                            </div>
                        </label>
                    </div>
                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Waktu Mulai Dosen Perempuan</span>
                            <!-- focus-within sets the color for the icon when input is focused -->
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $pengaturan->waktu }}" name="waktu" type="time"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                     required />
                            </div>
                        </label>
                    </div>
                   
                    <button type="submit"
                        class="flex items-center justify-center p-3 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">Simpan</button>
                </form>





            </div>
        </main>
    </div>
    
@endsection
