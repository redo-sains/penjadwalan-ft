@extends('admin.layout.layout')
@section('main')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <div class="flex flex-col flex-1">
        @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Edit Gen </h2>
                <form class="grid " action="{{ route('update_population', ['id' => $population->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Jurusan</span>
                                <div
                                    class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <select name="jurusan_id"
                                        class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                        <option value="#" selected disabled>Pilih jurusan</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option {{ $jurusan->id == $population->jurusan_id ? 'selected' : '' }}
                                                value="{{ $jurusan->id }}" class="">
                                                {{ $jurusan->nama }}</option>
                                        @endforeach
                                    </select>

                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                            stroke="currentColor">
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
                                            <option {{ $matkul->id == $population->matkul_id ? 'selected' : '' }}
                                                value="{{ $matkul->id }}" class="">
                                                {{ $matkul->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                            stroke="currentColor">
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
                                    <select name="dosen_id[]"  multiple="true" 
                                        class="js-choice block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray "
                                        placeholder="tambah dosen"
                                        >
                                        {{-- <option value="#" selected disabled>Pilih dosen</option> --}}
                                        @foreach ($dosens as $dosens)
                                            <option value="{{ $dosens->id }}" class="">
                                                {{ $dosens->nama }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div> --}}
                                </div>
                            </label>
                        </div>
                        {{-- <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Ruangan</span>
                                <div
                                    class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <select name="ruangan_id"
                                        class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                        <option value="#" selected disabled>Pilih Ruangan</option>
                                        @foreach ($ruangans as $ruangan)
                                            <option {{ $ruangan->id == $population->ruangan_id ? 'selected' : '' }}
                                                value="{{ $ruangan->id }}" class="">
                                                {{ $ruangan->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div> --}}
                    </div>
                    <button type="submit"
                        class="flex items-center justify-center mt-2  py-3 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">Simpan</button>
                </form>


            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>        
        
            const choices = new Choices('.js-choice', {
                removeItems: true,
                removeItemButton: true,      
                placeholder: true,
                placeholderValue: "Tambah Dosen",
                loadingText: 'Loading...',
                noResultsText: 'No results found',
                noChoicesText: 'No choices to choose from',
                itemSelectText: 'Press to select',
                uniqueItemText: 'Only unique values can be added',
                customAddItemText: 'Only values matching specific conditions can be added',
                // addItems: false,
            });
        
    </script>
@endsection
