<x-dashboard>
    <x-slot name="userName">{{ $admin['name'] }}</x-slot>
    <x-slot name="userRole">Administrator</x-slot>

    <!-- Sidebar Menu for Admin -->
    <x-slot name="sidebarMenu">
        <x-admin-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div x-data="{ 
        search: '{{ request('search') }}', 
        filterStatus: 'Semua Status', 
        showToast: false, 
        toastMessage: '', 
        openAddModal: false, 
        openEditModal: false,
        editProduct: {
            id: '',
            name: '',
            category: 'Streaming',
            original_price: 0,
            aksespro_price: 0,
            duration_days: 30,
            stock: 0,
            max_stock: 0,
            description: ''
        }
    }" class="space-y-6">

        <!-- Toast Notification -->
        <div x-show="showToast" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed bottom-4 right-4 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3"
            style="display: none;">
            <svg class="w-5 h-5 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="toastMessage" class="text-sm font-medium"></span>
        </div>

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar layanan akun premium dan ketersediaan stok.</p>
            </div>

            <button
                @click="openAddModal = true"
                class="px-5 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Produk Baru
            </button>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Filter / Search -->
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" x-model="search"
                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full pl-10 p-3"
                    placeholder="Cari produk...">
            </div>
            <select x-model="filterStatus"
                class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3 min-w-[150px]">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Nonaktif</option>
                <option>Habis</option>
            </select>
        </div>

        <!-- Product Horizontal Cards List -->
        <div class="space-y-4">
            @foreach ($products as $product)
                @php
                    $status = !$product->is_active ? 'Nonaktif' : ($product->stock == 0 ? 'Habis' : 'Aktif');
                @endphp
                <div x-show="(filterStatus === 'Semua Status' || filterStatus === '{{ $status }}') && '{{ strtolower($product->name) }}'.includes(search.toLowerCase())"
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row group hover:shadow-md transition-shadow">

                    <!-- Left: Image Area -->
                    <div class="w-full md:w-48 lg:w-56 h-48 md:h-auto bg-gray-50 flex-shrink-0 relative border-r border-gray-100">
                        <div class="absolute inset-0 flex items-center justify-center p-6">
                            @php
                                $pName = strtolower($product->name);
                                $imagePath = 'image/zoom.jpg'; // default
                                if (str_contains($pName, 'netflix')) {
                                    $imagePath = 'image/netflix.jpg';
                                } elseif (str_contains($pName, 'spotify')) {
                                    $imagePath = 'image/spotify.jpg';
                                } elseif (str_contains($pName, 'canva')) {
                                    $imagePath = 'image/canva.jpg';
                                } elseif (str_contains($pName, 'youtube')) {
                                    $imagePath = 'image/youtube.webp';
                                } elseif (str_contains($pName, 'chatgpt')) {
                                    $imagePath = 'image/chatgpt.jpg';
                                } elseif (str_contains($pName, 'zoom')) {
                                    $imagePath = 'image/zoom.jpg';
                                } else {
                                    $imagePath = 'image/zoom.jpg';
                                }
                            @endphp
                            <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-contain drop-shadow-md rounded-2xl transition-transform group-hover:scale-105">
                        </div>
                    </div>

                    <!-- Right: Content Area -->
                    <div class="p-6 flex-1 flex flex-col justify-between">

                        <!-- Top: Title & Toggle -->
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2 py-0.5 rounded-md">{{ $product->category }}</span>
                                    @if ($status == 'Aktif')
                                        <span class="text-xs font-semibold text-green-600">Aktif</span>
                                    @elseif($status == 'Habis')
                                        <span class="text-xs font-semibold text-red-500">Stok Habis</span>
                                    @else
                                        <span class="text-xs font-semibold text-gray-500">Nonaktif</span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-[#0A2540]">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2 max-w-xl">{{ $product->description }}</p>
                            </div>

                            <!-- Manual Toggle Switch -->
                            <div class="flex items-center flex-shrink-0" title="Aktifkan/Nonaktifkan Manual">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                        @change="
                                            fetch('{{ route('admin.produk.toggle-active', $product->id) }}', {
                                                method: 'POST',
                                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                toastMessage = 'Status ' + '{{ $product->name }}' + ' berhasil diubah';
                                                showToast = true;
                                                setTimeout(() => { showToast = false; window.location.reload(); }, 1500);
                                            });
                                        "
                                        class="sr-only peer"
                                        {{ $product->is_active ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0A2540]"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Bottom: Progress & Actions -->
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mt-4">

                            <!-- Stock Progress Bar -->
                            <div class="flex-1 max-w-md">
                                @php
                                    $stockPercent = $product->max_stock > 0 ? round(($product->stock / $product->max_stock) * 100) : 0;
                                    $progressColor = $stockPercent > 50 ? 'bg-[#00E5FF]' : ($stockPercent > 20 ? 'bg-orange-400' : 'bg-red-500');
                                @endphp
                                <div class="flex justify-between text-sm font-semibold mb-2">
                                    <span class="text-gray-900">Rp {{ number_format($product->aksespro_price, 0, ',', '.') }}
                                        <span class="text-xs text-gray-500 font-normal">/ slot</span></span>
                                    <span class="text-gray-600">{{ $product->stock }} / {{ $product->max_stock }} Tersisa</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden border border-gray-200/50">
                                    <div class="h-2.5 rounded-full {{ $progressColor }}" style="width: {{ $stockPercent }}%"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1.5">*Stok berkurang otomatis saat user transaksi. (Modal: Rp {{ number_format($product->original_price, 0, ',', '.') }} &bull; Durasi: {{ $product->duration_days }} hari)</p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button
                                    @click="
                                        editProduct = {
                                            id: '{{ $product->id }}',
                                            name: '{{ addslashes($product->name) }}',
                                            category: '{{ addslashes($product->category) }}',
                                            original_price: '{{ $product->original_price }}',
                                            aksespro_price: '{{ $product->aksespro_price }}',
                                            duration_days: '{{ $product->duration_days }}',
                                            stock: '{{ $product->stock }}',
                                            max_stock: '{{ $product->max_stock }}',
                                            description: '{{ addslashes($product->description) }}'
                                        };
                                        openEditModal = true;
                                    "
                                    class="px-4 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-sm font-medium transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>
                                <button
                                    @click="
                                        if (confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?')) {
                                            const form = document.getElementById('delete-form');
                                            form.action = '/admin/produk/' + '{{ $product->id }}';
                                            form.submit();
                                        }
                                    "
                                    class="p-2 bg-white border border-red-100 text-red-500 hover:bg-red-50 rounded-xl transition-colors"
                                    title="Hapus Produk">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Hidden Delete Form -->
        <form id="delete-form" action="" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <!-- Modal: Buat Produk Baru -->
        <div x-show="openAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="openAddModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('admin.produk.store') }}" method="POST">
                        @csrf
                        <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Buat Produk Baru</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                    <input type="text" name="name" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                        <select name="category" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                            <option value="Streaming">Streaming</option>
                                            <option value="Musik">Musik</option>
                                            <option value="Desain">Desain</option>
                                            <option value="Produktivitas">Produktivitas</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Durasi (Hari)</label>
                                        <input type="number" name="duration_days" value="30" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Harga Modal (Rp)</label>
                                        <input type="number" name="original_price" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                                        <input type="number" name="aksespro_price" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stok Saat Ini</label>
                                        <input type="number" name="stock" value="0" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stok Maksimum</label>
                                        <input type="number" name="max_stock" value="100" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="description" rows="3" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-base font-bold text-white sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                            <button type="button" @click="openAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Edit Produk -->
        <div x-show="openEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="openEditModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form :action="'/admin/produk/' + editProduct.id" method="POST">
                        @csrf
                        <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Produk</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                    <input type="text" name="name" x-model="editProduct.name" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                        <select name="category" x-model="editProduct.category" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                            <option value="Streaming">Streaming</option>
                                            <option value="Musik">Musik</option>
                                            <option value="Desain">Desain</option>
                                            <option value="Produktivitas">Produktivitas</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Durasi (Hari)</label>
                                        <input type="number" name="duration_days" x-model="editProduct.duration_days" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Harga Modal (Rp)</label>
                                        <input type="number" name="original_price" x-model="editProduct.original_price" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                                        <input type="number" name="aksespro_price" x-model="editProduct.aksespro_price" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stok Saat Ini</label>
                                        <input type="number" name="stock" x-model="editProduct.stock" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stok Maksimum</label>
                                        <input type="number" name="max_stock" x-model="editProduct.max_stock" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="description" x-model="editProduct.description" rows="3" class="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-base font-bold text-white sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                            <button type="button" @click="openEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-dashboard>