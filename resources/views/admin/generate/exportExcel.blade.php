  <table class="w-full whitespace-no-wrap">
      <thead>
          <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">Id</th>
              <th class="px-4 py-3">Waktu mulai</th>
              <th class="px-4 py-3">Waktu selesai</th>
              <th class="px-4 py-3">Hari</th>
              <th class="px-4 py-3">Ruangan</th>
              <th class="px-4 py-3">Jumlah Mahasiswa</th>
              <th class="px-4 py-3">Jurusan</th>
              <th class="px-4 py-3">Mata Kuliah</th>
              <th class="px-4 py-3">Kode</th>
              <th class="px-4 py-3">Semester</th>
              <th class="px-4 py-3">Sks</th>
              <th class="px-4 py-3">Dosen</th>
          </tr>
      </thead>
      <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          @foreach ($populations as $population)
              <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3 text-sm">
                      {{ $population->id }}
                  </td>

                  <td>
                      @if (isset($population->waktu_mulai) && $population->waktu_mulai)
                          {{ $population->waktu_mulai }}
                      @else
                          <span
                              class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                              Null
                          </span>
                      @endif
                  </td>

                  <td>
                      @if (isset($population->waktu_selesai) && $population->waktu_selesai)
                          {{ $population->waktu_selesai }}
                      @else
                          <span
                              class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                              Null
                          </span>
                      @endif
                  </td>

                  <td>
                    @if (isset($population->hari) && $population->hari)
                        {{ $population->hari }}
                    @else
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                            Null
                        </span>
                    @endif
                </td>

                  <td>
                      @if (isset($population->ruangan->nama) && $population->ruangan->nama)
                          {{ $population->ruangan->nama }}
                      @else
                          <span
                              class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                              Null
                          </span>
                      @endif
                  </td>

                  <td class="px-4 py-3">
                      <div>
                          <p class="font-semibold">{{ $population->kelas->jumlah }}</p>
                      </div>
                  </td>

                  <td class="px-4 py-3">
                      <div>
                          <p class="font-semibold">{{ $population->jurusan->nama }}</p>
                      </div>
                  </td>
                  
                  <td class="px-4 py-3 text-sm">
                      {{ $population->nama }}
                  </td>

                  <td class="px-4 py-3 text-sm">
                    {{ $population->kelas->mataKuliah->kode }}
                </td>
                  <td class="px-4 py-3 text-sm">
                    {{ $population->kelas->mataKuliah->semester }}
                </td>
                  <td class="px-4 py-3 text-sm">
                    {{ $population->kelas->mataKuliah->sks }}
                </td>

                  <td class="px-4 py-3 text-sm">
                      {{ implode(
                          ', ',
                          $population->dosen->map(function ($dos) {
                                  return $dos->dosen->nama;
                              })->toArray(),
                      ) }}

                  </td>

              </tr>
          @endforeach
      </tbody>
  </table>
