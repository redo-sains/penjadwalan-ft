@extends('admin.layout.layout')
@section('main')
    <div class="flex flex-col flex-1 w-full">
        @include('admin.layout.header')
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container grid px-6 mx-auto">
                <div class="flex items-center justify-between">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        Population
                    </h2>
                    <div class="flex ">

                        <form method="POST" action="{{ route('saveSchedules') }}">
                            @csrf
                            @method('POST')
                            {{-- <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Kurikulum</span>
                                    <div
                                        class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <select name="kurikulum_id"
                                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                                            <option value="#" selected disabled>Pilih kurikulum</option>
                                            @foreach ($kurikulums as $kurikulum)
                                                <option value="{{ $kurikulum->id }}" class="">
                                                    {{ $kurikulum->tahun_mulai . ' - ' . $kurikulum->tahun_selesai }}
                                                </option>
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
                            <input type="hidden" name="sortedSchedules" value="{{ json_encode($generatedScheduleIds) }}">
                            <button
                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Simpan hasil
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Daftar Jadwal yang di-generate -->
                <div class="w-full overflow-hidden rounded-lg shadow-xs mt-8">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Dosen</th>
                                    <th class="px-4 py-3">Jurusan</th>
                                    <th class="px-4 py-3">Mata Kuliah</th>
                                    <th class="px-4 py-3">Ruangan</th>
                                    <th class="px-4 py-3">Hari</th>
                                    <th class="px-4 py-3">Waktu Mulai</th>
                                    <th class="px-4 py-3">Waktu Selesai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($sortedSchedules as $schedule)
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm">{{ $schedule['dosen_id'] }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $schedule['jurusan_id'] }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $schedule['matkul_id'] }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($schedule['ruangan_id'])
                                                {{ $schedule['ruangan_id'] }}
                                            @else
                                                <span
                                                    class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">Online</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">{{ $schedule['hari'] }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $schedule['waktu_mulai'] }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $schedule['waktu_selesai'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
