@extends('admin.layout.layout')
@section('main')
    <div class="flex flex-col flex-1">
    @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                          Edit Jurusan {{ $jurusan->nama }}
                </h2>
                <form class="grid grid-cols-2" action="{{ route('update_jurusan', $jurusan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                      <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Nama</span>
                            <!-- focus-within sets the color for the icon when input is focused -->
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $jurusan->nama }}" name="nama"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="masukan nama jurusan" />
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </label>
                    </div>
                      <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kode jurusan</span>
                            <!-- focus-within sets the color for the icon when input is focused -->
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $jurusan->kode }}" name="kode"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="Masukan kode jurusan baru" />
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
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
