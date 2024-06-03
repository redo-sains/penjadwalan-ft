@extends('admin.layout.layout')
@section('main')
    <div class="flex flex-col flex-1">
        @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Edit kelas </h2>
                <form class="grid grid-cols-2" action="{{ route('update_kelas', ['id' => $kelas->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Jurusan</span>
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <select name="jurusan_id"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                    <option value="#" selected disabled>Pilih jurusan</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option {{ $jurusan->id == $kelas->jurusan_id ? 'selected' : '' }}
                                            value="{{ $jurusan->id }}" class="">
                                            {{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>

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
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Mata kuliah</span>
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <select name="matkul_id"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                    <option value="#" selected disabled>Pilih Matkul</option>
                                    @foreach ($matkuls as $matkul)
                                        <option {{ $matkul->id == $kelas->matkul_id ? 'selected' : '' }}
                                            value="{{ $matkul->id }}" class="">
                                            {{ $matkul->nama }}</option>
                                    @endforeach
                                </select>
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
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Dosen</span>
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <select name="dosen_id"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                    <option value="#" selected disabled>Pilih dosen</option>
                                    @foreach ($dosens as $dosen)
                                        <option {{ $dosen->id == $kelas->dosen_id ? 'selected' : '' }}
                                            value="{{ $dosen->id }}" class="">
                                            {{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
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
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kelas</span>
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $kelas->kelas }}" name="kelas"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="masukan  kelas" />
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
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kapasitas</span>
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $kelas->kapasitas }}" type="number" name="kapasitas"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="masukan  kapasitas" />
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
                        class="flex items-center justify-center mt-2  py-3 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">Simpan</button>
                </form>


            </div>
        </main>
    </div>
@endsection
