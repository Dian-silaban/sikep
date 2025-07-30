<div class="w-64 bg-white shadow-md h-screen sticky top-0 border-r border-gray-200">
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Pegawai</h3>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('reports.usulan-berkala.index') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-indigo-50 hover:text-indigo-600
                        {{ Request::routeIs('reports.usulan-berkala.index') ? 'bg-indigo-100 text-indigo-700 font-medium' : '' }}">
                        Buku Jaga Usulan KGB
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('reports.usulan-kenaikan-pangkat.index') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-indigo-50 hover:text-indigo-600
                        {{ Request::routeIs('reports.usulan-kenaikan-pangkat.index') ? 'bg-indigo-100 text-indigo-700 font-medium' : '' }}">
                        Daftar Jaga Usulan KP
                    </a>
                </li>
                <!-- Tambahkan link laporan lain di sini jika ada -->
            </ul>
        </nav>
    </div>
</div>