<x-dashboard>
    <x-slot name="userName">{{ $user['name'] }}</x-slot>
    <x-slot name="userRole">Member</x-slot>

    <!-- Sidebar Menu for User -->
    <x-slot name="sidebarMenu">
        <x-user-sidebar />
    </x-slot>

    <!-- Page Content -->
    <div class="space-y-8">

        <!-- Header Section -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Bantuan & Support</h1>
            <p class="text-sm text-gray-500 mt-1">Temukan jawaban dari pertanyaan Anda atau hubungi tim dukungan kami.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- FAQ Section -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Pertanyaan yang Sering Diajukan (FAQ)</h2>

                    <div class="space-y-4" x-data="{ activeAccordion: 0 }">
                        <!-- FAQ Item 1 -->
                        <div class="border border-gray-100 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                                class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors text-left focus:outline-none">
                                <span class="font-semibold text-gray-900">Bagaimana cara menukarkan poin?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-300"
                                    :class="activeAccordion === 1 ? 'transform rotate-180' : ''" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeAccordion === 1" x-collapse>
                                <div
                                    class="p-4 bg-white text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                                    Anda dapat menukarkan poin melalui menu "Tukar Poin". Pastikan saldo poin Anda
                                    mencukupi untuk paket yang dipilih (1 Poin = 1 Rupiah). Setelah menekan tombol
                                    tukar, paket akan langsung aktif di akun Anda.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="border border-gray-100 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                                class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors text-left focus:outline-none">
                                <span class="font-semibold text-gray-900">Apakah akun yang diberikan bergaransi?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-300"
                                    :class="activeAccordion === 2 ? 'transform rotate-180' : ''" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeAccordion === 2" x-collapse style="display: none;">
                                <div
                                    class="p-4 bg-white text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                                    Ya, seluruh akun yang dibeli melalui AksesPro memiliki garansi penuh sesuai masa
                                    aktif paket. Jika terjadi kendala login atau akun terkena limit, hubungi Customer
                                    Service kami untuk mendapatkan akun pengganti secara gratis.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="border border-gray-100 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                                class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors text-left focus:outline-none">
                                <span class="font-semibold text-gray-900">Berapa lama proses aktivasi langganan?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-300"
                                    :class="activeAccordion === 3 ? 'transform rotate-180' : ''" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeAccordion === 3" x-collapse style="display: none;">
                                <div
                                    class="p-4 bg-white text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                                    Proses aktivasi berlangsung otomatis dalam 1-5 menit setelah pembayaran berhasil
                                    diverifikasi oleh sistem kami. Kredensial akun (email & password) akan langsung
                                    muncul di menu "Langganan Aktif".
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support Section -->
            <div class="space-y-6">
                <!-- CS Card -->
                <div class="bg-[#0A2540] rounded-2xl shadow-sm p-6 relative overflow-hidden">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#00E5FF]/10 rounded-full blur-2xl -mr-10 -mt-10">
                    </div>

                    <div class="relative z-10 text-center mb-6">
                        <div
                            class="w-16 h-16 bg-[#00E5FF]/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-[#00E5FF]/50">
                            <svg class="w-8 h-8 text-[#00E5FF]" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">Butuh Bantuan Langsung?</h3>
                        <p class="text-sm text-blue-100">Tim kami siap membantu Anda setiap hari pkl 08.00 - 22.00 WIB.
                        </p>
                    </div>

                    <a href="https://wa.me/62895396048445" target="_blank"
                        class="w-full bg-[#00E5FF] hover:bg-[#00c9e0] text-[#0A2540] py-3 rounded-xl font-bold transition-colors shadow-sm flex justify-center items-center gap-2 mb-3">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        Chat via WhatsApp
                    </a>

                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=adhyaksa209@gmail.com" target="_blank"
                        class="w-full bg-white/10 hover:bg-white/20 text-white py-3 rounded-xl font-bold transition-colors flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email Support
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-dashboard>
