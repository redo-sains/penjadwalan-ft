@extends('admin.layout.layout')
@section('main')
    <div class="flex flex-col flex-1">
        @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Edit ruangan {{ $ruangan->nama }}
                </h2>
                <form class="grid grid-cols-2" action="{{ route('update_ruangan', $ruangan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Nama</span>
                            <!-- focus-within sets the color for the icon when input is focused -->
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $ruangan->nama }}" name="nama"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="Masukan nama ruangan" required />
                            </div>
                        </label>
                    </div>
                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kode ruangan</span>
                            <!-- focus-within sets the color for the icon when input is focused -->
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input value="{{ $ruangan->kode }}" name="kode"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="Masukan kode ruangan baru" required />
                            </div>
                        </label>
                    </div>
                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kapasitas</span>
                            <!-- focus-within sets the color for the icon when input is focused -->
                            <div
                                class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <input type="number" value="{{ $ruangan->kapasitas }}" name="kapasitas"
                                    class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="Masukan kapasitas ruangan baru" required />
                            </div>
                        </label>
                    </div>
                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Tipe Ruangan</span>
                            <select name="tipe_ruangan"
                                class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                required>
                                <option value="umum" {{ $ruangan->tipe_ruangan == 'umum' ? 'selected' : '' }}>Umum
                                </option>
                                <option value="online" {{ $ruangan->tipe_ruangan == 'online' ? 'selected' : '' }}>Online
                                </option>
                                <option value="khusus" {{ $ruangan->tipe_ruangan == 'khusus' ? 'selected' : '' }}>Khusus
                                </option>
                            </select>
                        </label>
                    </div>
                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800" id="jurusan-field"
                        style="{{ $ruangan->tipe_ruangan == 'khusus' ? 'display:block;' : 'display:none;' }}">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Jurusan</span>
                            <select name="jurusan_id"
                                class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                                <!-- Loop through your jurusan options here -->
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}"
                                        {{ $ruangan->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <button type="submit"
                        class="flex items-center justify-center p-3 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">Simpan</button>
                </form>





            </div>
        </main>
    </div>
    <script>
        document.querySelector('[name="tipe_ruangan"]').addEventListener('change', function() {
            var jurusanField = document.getElementById('jurusan-field');
            if (this.value === 'khusus') {
                jurusanField.style.display = 'block';
            } else {
                jurusanField.style.display = 'none';
            }
        });
    </script>
@endsection
