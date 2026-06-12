import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function Bantuan({ user }) {
    const [faqOpen, setFaqOpen] = useState({});

    const toggleFaq = (index) => {
        setFaqOpen(prev => ({
            ...prev,
            [index]: !prev[index]
        }));
    };

    const faqs = [
        {
            q: "Bagaimana cara melakukan pembelian produk di AksesPro?",
            a: "Anda dapat menelusuri katalog produk kami, memilih durasi akses yang diinginkan, lalu menekan tombol 'Beli Sekarang'. Sistem kami terintegrasi secara instan dengan Midtrans untuk memfasilitasi berbagai metode pembayaran seperti QRIS, Virtual Account, dan E-Wallet."
        },
        {
            q: "Apakah akun yang diberikan bersifat privat?",
            a: "Tergantung pada tipe paket yang Anda beli (Shared/Semi-Private/Private). Detail kualifikasi akun tercantum dengan jelas pada halaman rincian produk."
        },
        {
            q: "Bagaimana cara klaim garansi jika akun bermasalah?",
            a: "Kami menyediakan garansi penuh selama durasi langganan aktif. Jika akun Anda mengalami kendala atau perlu disinkronkan ulang, silakan klik tombol hubungi tim Support kami di WhatsApp dengan menyertakan Nomor Invoice Anda."
        },
        {
            q: "Apakah saldo poin bisa hangus?",
            a: "Tidak, poin yang Anda kumpulkan dari transaksi pembelian atau bonus rujukan tidak memiliki batas kedaluwarsa dan dapat digunakan kapan saja."
        }
    ];

    return (
        <UserDashboardLayout user={user} title="Pusat Bantuan">
            <Head title="Pusat Bantuan & Dukungan — AksesPro" />

            <div className="max-w-4xl mx-auto space-y-8">
                {/* Header Banner */}
                <div className="bg-[#0A2540] text-white rounded-2xl p-8 relative overflow-hidden shadow-md">
                    <div className="relative z-10 space-y-2 max-w-lg">
                        <span className="text-xs font-semibold text-[#00b8cc] tracking-wider uppercase">Dukungan AksesPro</span>
                        <h1 className="text-3xl font-extrabold">Ada yang bisa kami bantu?</h1>
                        <p className="text-gray-300 text-sm">Tim kami selalu siap membantu Anda menyelesaikan masalah akses akun atau transaksi 24/7.</p>
                    </div>
                    {/* Background decorations */}
                    <div className="absolute top-0 right-0 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div className="absolute -bottom-8 right-16 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                </div>

                {/* Grid Content */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {/* Left: Contact Channels */}
                    <div className="md:col-span-1 space-y-6">
                        <div className="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
                            <h3 className="text-lg font-bold text-gray-900">Hubungi Kami</h3>
                            <p className="text-xs text-gray-500">Respon cepat via saluran komunikasi resmi.</p>

                            <a
                                href="https://wa.me/6281234567890"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="flex items-center gap-3 p-3.5 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition-colors font-semibold text-sm"
                            >
                                <svg className="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.62.962 3.208 1.488 4.867 1.489 5.485 0 9.948-4.463 9.951-9.95.002-2.658-1.03-5.157-2.909-7.037-1.88-1.879-4.383-2.912-7.042-2.913-5.486 0-9.952 4.462-9.954 9.951-.001 1.83.5 3.606 1.448 5.176L1.11 20.89l4.577-1.2c1.3.708 2.825 1.064 4.96 1.064z"/>
                                </svg>
                                <span>WhatsApp Support</span>
                            </a>

                            <a
                                href="mailto:support@aksespro.com"
                                className="flex items-center gap-3 p-3.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors font-semibold text-sm"
                            >
                                <svg className="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Email Support</span>
                            </a>
                        </div>
                    </div>

                    {/* Right: FAQs */}
                    <div className="md:col-span-2 space-y-4">
                        <h2 className="text-xl font-bold text-gray-900 mb-2">Pertanyaan Populer (FAQ)</h2>
                        <div className="space-y-3">
                            {faqs.map((faq, index) => {
                                const isOpen = !!faqOpen[index];
                                return (
                                    <div key={index} className="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300">
                                        <button
                                            onClick={() => toggleFaq(index)}
                                            className="w-full flex items-center justify-between p-5 text-left font-bold text-gray-900 hover:bg-gray-50/50 transition-colors"
                                        >
                                            <span className="text-sm pr-4">{faq.q}</span>
                                            <svg
                                                className={`w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`}
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        
                                        <div className={`transition-all duration-300 overflow-hidden ${isOpen ? 'max-h-96 border-t border-gray-50' : 'max-h-0'}`}>
                                            <p className="p-5 text-sm text-gray-600 leading-relaxed bg-gray-50/20">{faq.a}</p>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </div>
            </div>
        </UserDashboardLayout>
    );
}
