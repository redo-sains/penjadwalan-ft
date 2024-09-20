@extends('admin.layout.layout')
@section('main')
    <div class="flex flex-col flex-1 w-full">
        @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container grid px-6 mx-auto">
                <div class="flex items-center justify-between">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        Master Mata Kuliah
                    </h2>


                    <div>

                        <button id="test"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Tambah Mata Kuliah
                        </button>

                        <button id="test2"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Import Mata Kuliah
                        </button>
                        <button id="triggerOpenModal" @click="openModal" class="hidden">
                            open Modal
                        </button>
                    </div>
                </div>
                <!-- With actions -->

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Id</th>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">Kode MK</th>
                                    <th class="px-4 py-3">Jurusan</th>
                                    <th class="px-4 py-3">Semester</th>
                                    <th class="px-4 py-3">SKS</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($matakuls as $mk)
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm">
                                            {{ $mk->id }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">{{ $mk->nama }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ $mk->kode }}
                                        </td>

                                        <td class="px-4 py-3 text-xs">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 dark:bg-green-700  rounded-full dark:text-green-100">
                                                @php
                                                    $jurusanNama =
                                                        $jurusans->firstWhere('id', $mk->jurusan_id)->nama ??
                                                        'Tidak ada';
                                                @endphp
                                                {{ $jurusanNama }}
                                            </span>
                                        </td>


                                        <td class="px-4 py-3 text-sm">
                                            {{ $mk->semester }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ $mk->sks }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center space-x-4 text-sm">
                                                <a href="{{ route('edit_matkul', ['id' => $mk->id]) }}"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                    aria-label="Edit">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('hapus_matkul', ['id' => $mk->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="confirm('Apakah anda yakin ingin menghapus?')"
                                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                        aria-label="Delete">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div
                        class="flex px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <span class="flex items-center  col-span-3">
                            Showing {{ $matakuls->firstItem() }}-{{ $matakuls->lastItem() }} of {{ $matakuls->total() }}
                        </span>
                        <div
                            class="flex px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                                {{ $matakuls->links() }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </main>
        <!-- Modal tambah hari-->
        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
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
                <!-- Modal tambah hari -->
                <div id="modal_tambah_dosen" class="mt-4 mb-6">
                    <!-- Modal title -->
                    <p class="mb-2 px-3 text-lg font-semibold text-gray-700 dark:text-gray-300  ">
                        Tambah mata kuliah Baru
                    </p>
                    <!-- Modal description -->
                    <form class="grid grid-cols-2" action="{{ route('store_matkul') }}" method="POST">
                        @csrf
                        <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Mata Kuliah</span>
                                <div
                                    class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <input name="nama"
                                        class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                        placeholder="masukan  mata kuliah" />
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
                                <span class="text-gray-700 dark:text-gray-400">kode mata kuliah</span>
                                <!-- focus-within sets the color for the icon when input is focused -->
                                <div
                                    class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <input name="kode"
                                        class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                        placeholder="masukan kode mata kuliah" />
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
                                <span class="text-gray-700 dark:text-gray-400">SKS</span>
                                <!-- focus-within sets the color for the icon when input is focused -->
                                <div
                                    class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <input name="sks"
                                        class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                        placeholder="Masukan SKS" />
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
                                <span class="text-gray-700 dark:text-gray-400">Semester</span>
                                <!-- focus-within sets the color for the icon when input is focused -->
                                <div
                                    class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <input name="semester"
                                        class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                        placeholder="masukan kode semester" />
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

    <div id="modal_import" class="mt-4 mb-6 hidden">
        <!-- Modal title -->
        <p class="mb-2 px-3 text-lg font-semibold text-gray-700 dark:text-gray-300  ">
            Import Data
        </p>
        <!-- Modal description -->
        <form class="grid grid-cols-2" action="{{ route('import-matkuls') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Input Excel</span>
                    <!-- focus-within sets the color for the icon when input is focused -->
                    <div
                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                        <input type="file" name="file" accept=".xlsx, .xls, .csv"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            />
                        
                    </div>
                </label>
            </div>
            
            <button type="submit"
                class="flex items-center justify-center mt-2  py-3 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">Import</button>
        </form>
    </div>

    <script>
        function SwapNode(N1, N2) {
            var P1 = N1.parentNode;
            var T1 = document.createElement("span");
            P1.insertBefore(T1, N1);

            var P2 = N2.parentNode;
            var T2 = document.createElement("span");
            P2.insertBefore(T2, N2);

            P1.insertBefore(N2, T1);
            P2.insertBefore(N1, T2);

            P1.removeChild(T1);
            P2.removeChild(T2);
        }

        function clickImport(){
            modalAddDosen = document.getElementById("modal_tambah_dosen");
            modalImportData = document.getElementById("modal_import");

            SwapNode(
                    modalAddDosen,
                    modalImportData
                );
            
            modalAddDosen.classList.add("hidden");
            modalImportData.classList.remove("hidden");
        }

        function clickAddDosen(){
            modalAddDosen = document.getElementById("modal_tambah_dosen");
            modalImportData = document.getElementById("modal_import");

            SwapNode(
                    modalAddDosen,
                    modalImportData
                );
            
            modalImportData.classList.add("hidden");
            modalAddDosen.classList.remove("hidden");
        }

        document.addEventListener("DOMContentLoaded", function() {
            button1 = document.getElementById("test");
            button2 = document.getElementById("test2");

            addDosen=true;
            
            modal = document.getElementById("triggerOpenModal");
            button1.addEventListener("click", () => {
                if(!addDosen){
                    clickAddDosen();
                }                                
                modal.click();
                addDosen = true;
            })            

            button2.addEventListener("click", () => {
                // clickAddDosen(addDosen);
                if(addDosen){
                    clickImport()                    
                }
                
                modal.click();
                addDosen = false;
                
            })            

        });
    </script>
@endsection
