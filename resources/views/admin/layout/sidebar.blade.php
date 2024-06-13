      <!-- Desktop sidebar -->
      <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
          <div class="py-4 text-gray-500 dark:text-gray-400">
              <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                  Sistem penjadwalan
              </a>
              <ul class="mt-6">
                  <li class="relative px-6 py-3">
                      @if ($title === 'Dashboard')
                          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                              aria-hidden="true"></span>
                      @endif
                      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          href="{{ route('dashboard') }}">
                          <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                              <path
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                              </path>
                          </svg>
                          <span class="ml-4 {{ $title === 'Dashboard' ? 'dark:text-white' : '' }}">Dashboard</span>
                      </a>
                  </li>
                  <li class="relative px-6 py-3">
                      @if ($title === 'Master dosen')
                          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                              aria-hidden="true"></span>
                      @endif
                      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          href="{{ route('dosen') }}">
                          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                              <path
                                  d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                              </path>
                          </svg>
                          <span class="ml-4 {{ $title === 'Master dosen' ? 'dark:text-white' : '' }}">Master
                              Dosen</span>
                      </a>
                  </li>
                  <li class="relative px-6 py-3">
                      @if ($title === 'Master Jurusan')
                          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                              aria-hidden="true"></span>
                      @endif
                      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          href="{{ route('jurusan') }}">
                          <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                              <path
                                  d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                              </path>
                          </svg>
                          <span class="ml-4  {{ $title === 'Master jurusan' ? 'dark:text-white' : '' }}">Master
                              jurusan</span>
                      </a>
                  </li>
                  <li class="relative px-6 py-3">
                      @if ($title === 'Master Ruangan')
                          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                              aria-hidden="true"></span>
                      @endif
                      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          href="{{ route('ruangan') }}">
                          <svg class="w-5 h-5" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                  <title>door</title>
                                  <path
                                      d="M30 29.25h-3.279v-27.25c-0-0.414-0.336-0.75-0.75-0.75h-19.971c-0.414 0-0.75 0.336-0.75 0.75v0 27.25h-3.25c-0.414 0-0.75 0.336-0.75 0.75s0.336 0.75 0.75 0.75v0h28c0.414 0 0.75-0.336 0.75-0.75s-0.336-0.75-0.75-0.75v0zM6.75 29.25v-26.5h18.471v26.5zM20.48 15.46c-0.146 0.135-0.238 0.326-0.24 0.54v0c0 0.001-0 0.003-0 0.005 0 0.212 0.093 0.403 0.24 0.535l0.001 0.001c0.126 0.135 0.306 0.22 0.505 0.22 0.005 0 0.010-0 0.015-0h-0.001c0.204-0.001 0.388-0.085 0.519-0.22l0-0c0.142-0.138 0.232-0.328 0.24-0.539l0-0.001c-0.012-0.212-0.102-0.4-0.24-0.54l0 0c-0.136-0.126-0.319-0.203-0.52-0.203s-0.383 0.077-0.52 0.203l0-0z">
                                  </path>
                              </g>
                          </svg>
                          <span class="ml-4  {{ $title === 'Master jurusan' ? 'dark:text-white' : '' }}">Master
                              Ruangan</span>
                      </a>
                  </li>
                  <li class="relative px-6 py-3">
                      @if ($title === 'Master Mata Kuliah')
                          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                              aria-hidden="true"></span>
                      @endif
                      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          href="{{ route('matkul') }}">
                          <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"
                              xmlns="http://www.w3.org/2000/svg">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                  <path
                                      d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21"
                                      stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                  </path>
                              </g>
                          </svg>
                          <span class="ml-4  {{ $title === 'Master mapel' ? 'dark:text-white' : '' }}">Master Mata
                              Kuliah</span>
                      </a>
                  </li>
                  <li class="relative px-6 py-3">
                      @if ($title === 'Master Kelas')
                          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                              aria-hidden="true"></span>
                      @endif
                      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          href="{{ route('kelas') }}">
                          <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"
                              xmlns="http://www.w3.org/2000/svg">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                  <path
                                      d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21"
                                      stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                  </path>
                              </g>
                          </svg>
                          <span class="ml-4  {{ $title === 'Master Kelas' ? 'dark:text-white' : '' }}">Master Kelas
                            </span>
                      </a>
                  </li>
                  <li class="relative px-6 py-3">
                      <button
                          class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          @click="togglePagesMenu" aria-haspopup="true">
                          <span class="inline-flex items-center">
                              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                  <path
                                      d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                  </path>
                              </svg>
                              <span class="ml-4">Generate data</span>
                          </span>
                          <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                          </svg>
                      </button>
                      <template x-if="isPagesMenuOpen">
                          <ul x-transition:enter="transition-all ease-in-out duration-300"
                              x-transition:enter-start="opacity-25 max-h-0"
                              x-transition:enter-end="opacity-100 max-h-xl"
                              x-transition:leave="transition-all ease-in-out duration-300"
                              x-transition:leave-start="opacity-100 max-h-xl"
                              x-transition:leave-end="opacity-0 max-h-0"
                              class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                              aria-label="submenu">
                               <li
                                  class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                  <a class="w-full" href="{{ route('population') }}">
                                      Populations
                                  </a>
                              </li>
                              <li
                                  class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                  <a class="w-full" href="">Ketersediaan Ruangan</a>
                              </li>
                              <li
                                  class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                  <a class="w-full" href="{{ route('k_dosen') }}">
                                      Ketersediaan Dosen
                                  </a>
                              </li>

                             
                              <li
                                  class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                  <a class="w-full" href="pages/create-account.html">
                                      Generate jadwal
                                  </a>
                              </li>

                          </ul>
                      </template>
                  </li>

                  <li class="relative px-6 py-3">
                      @if ($title === 'Master user')
                          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                              aria-hidden="true"></span>
                      @endif
                      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                          href="{{ route('user') }}">

                          <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                              </g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                  <path
                                      d="M19 15C21.2091 15 23 16.7909 23 19V21H21M16 10.874C17.7252 10.4299 19 8.86383 19 6.99999C19 5.13615 17.7252 3.57005 16 3.12601M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7ZM5 15H13C15.2091 15 17 16.7909 17 19V21H1V19C1 16.7909 2.79086 15 5 15Z"
                                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                          </svg>

                          <span class="ml-4  {{ $title === 'Kelola user' ? 'dark:text-white' : '' }}">Kelola
                              user</span>
                      </a>
                  </li>
              </ul>
              <div class="px-6 my-6">
                  <form action="{{ route('logout') }}" class="" method="post">
                      @csrf
                      <button
                          class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                          Log out
                          <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                              <path
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                              </path>
                          </svg>
                      </button>
                  </form>
              </div>
          </div>
      </aside>
