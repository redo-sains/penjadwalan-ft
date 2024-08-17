   @php
       $kurikulum_id = request('kurikulum_id');
       $selectedKurikulumId = session('kurikulum_id');
   @endphp

   {{-- @if (Auth::user()->role === 'admin')  --}}

   @extends('admin.layout.layout')

   {{-- @endif --}}
   {{-- @if (Auth::user()->role === 'pengunjung') 

@extends('mahasiswa.layout.layout')
    
@endif --}}

   @section('main')
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
       <div class="flex flex-col flex-1 w-full">
           @include('admin.layout.header')
           <main class="h-full pb-16 overflow-y-auto">
               <div class="container grid px-6 mx-auto">
                   <div class="flex items-center justify-between">
                       <div class="w-full">
                           <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                               Population
                           </h2>
                           <div class="flex justify-between w-full  items-center ">
                               <form action="{{ route('population') }}" method="get" id="kurikulumForm">
                                   {{-- @csrf --}}
                                   <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                       <label class="block text-sm">
                                           <span class="text-gray-700 dark:text-gray-400">Kurikulum</span>
                                           <div
                                               class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                               <select name="kurikulum_id" id="kurikulumSelect"
                                                   class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                                   <option value="#" selected disabled>Pilih kurikulum</option>

                                                   @foreach ($kurikulums as $kurikulum)
                                                       <option
                                                           @isset($id)
                                                    {{ $kurikulum->id == $id || $selectedKurikulumId ? 'selected' : '' }}
                                                @endisset
                                                           value="{{ $kurikulum->id }}">
                                                           {{ $kurikulum->tahun_mulai . ' - ' . $kurikulum->tahun_selesai . ' / ' . $kurikulum->semester }}
                                                       </option>
                                                   @endforeach
                                               </select>
                                               <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                                   <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                                       stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                       viewBox="0 0 24 24" stroke="currentColor">
                                                       <path
                                                           d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                       </path>
                                                   </svg>
                                               </div>
                                           </div>
                                       </label>
                                   </div>
                               </form>
                               <div class="flex ">
                                   @if (isset($kurikulum_id))
                                       <form class="mr-2" method="POST" action="{{ route('generate-jadwal') }}">
                                           @csrf
                                           @method('POST')
                                           <input type="hidden" name="kurikulum_id" value="{{ $kurikulum_id }}">
                                           <button
                                               class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                               Generate Jadwal
                                           </button>
                                       </form>
                                       <button @click="openModal"
                                           class="px-4 mr-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                           Tambah Pengampu
                                       </button>

                                       <form method="POST" action="{{ route('export-populations') }}">
                                           @csrf
                                           @method('POST')
                                           <button
                                               class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                               Download Excel
                                           </button>
                                       </form>
                                       {{-- <form method="POST" action="{{ route('generate-population') }}">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="kurikulum_id" value="{{ $kurikulum_id }}">
                                            <button
                                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                Generate Populasi
                                            </button>
                                        </form> --}}
                                   @endif

                               </div>
                           </div>
                       </div>


                   </div>
                   <!-- With actions -->
                   <div class="w-full overflow-hidden rounded-lg shadow-xs">
                       <div class="w-full overflow-x-auto">
                           {{-- table here --}}
                           @include('admin.generate.exportExcel')
                       </div>
                       <!-- Pagination -->
                       <div
                           class="flex px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                           <span class="flex items-center  col-span-3">
                               Showing {{ $populations->firstItem() }}-{{ $populations->lastItem() }} of
                               {{ $populations->total() }}
                           </span>
                           <div
                               class="flex px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                               <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                                   {{ $populations->links() }}
                               </span>
                           </div>

                       </div>
                   </div>
               </div>
           </main>
           <!-- Modal tambah pipuulation-->
           <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
               x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
               x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
               x-transition:leave-end="opacity-0"
               class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
               <!-- Modal -->
               <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
                   x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                   x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                   x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
                   @keydown.escape="closeModal"
                   class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                   role="dialog" id="modal">
                   <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                   <header class="flex justify-end">
                       <button
                           class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                           aria-label="close" @click="closeModal">
                           <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                               <path
                                   d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                   clip-rule="evenodd" fill-rule="evenodd"></path>
                           </svg>
                       </button>
                   </header>
                   <!-- Modal tambah population -->
                   <div class="mt-4 mb-6">
                       <!-- Modal title -->
                       <p class="mb-2 px-3 text-lg font-semibold text-gray-700 dark:text-gray-300  ">
                           Tambah GEN Baru
                       </p>
                       <!-- Modal description -->
                       <form class="grid grid-cols-2" action="{{ route('store_population') }}" method="POST">
                           @csrf

                           <input type="hidden" name="kurikulum_id" value="{{ $kurikulum_id }}">
                           <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                               <label class="block text-sm">
                                   <span class="text-gray-700 dark:text-gray-400">Dosen</span>
                                   <div
                                       class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                       <select name="dosen_id" multiple 
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
                           <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                               <label class="block text-sm">
                                   <span class="text-gray-700 dark:text-gray-400">Mata kuliah</span>
                                   <div
                                       class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                       <select name="matkul_id"
                                           class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                           <option value="#" selected disabled>Pilih Matkul</option>
                                           @foreach ($matkuls as $matkul)
                                               <option value="{{ $matkul->id }}" class="">
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
                                   <span class="text-gray-700 dark:text-gray-400">Jurusan</span>
                                   <div
                                       class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                       <select name="jurusan_id"
                                           class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                           <option value="#" selected disabled>Pilih jurusan</option>
                                           @foreach ($jurusans as $jurusan)
                                               <option value="{{ $jurusan->id }}" class="">
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

                           <button type="submit"
                               class="flex items-center justify-center mt-2  py-3 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">Simpan</button>
                       </form>
                   </div>

               </div>
           </div>
           <!-- End of modal update hari  -->
       </div>
       <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
       <script>
           document.getElementById('kurikulumSelect').addEventListener('change', function() {
               // Jika elemen select berubah, kirimkan form
               document.getElementById('kurikulumForm').submit();
           });
           document.addEventListener("DOMContentLoaded", function() {
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
           });
       </script>
   @endsection
