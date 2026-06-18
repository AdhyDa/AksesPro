import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link, router } from '@inertiajs/react';

export default function KatalogDetail({ user, product }) {
    const benefits = [
        'Akses premium penuh tanpa batasan fitur',
        'Akun legal 100% bergaransi selama masa aktif',
        'Dukungan bantuan (Support) 24/7 jika terjadi kendala',
        'Sistem cost-sharing yang sangat menghemat biaya',
    ];

    if (product.category === 'Streaming') {
        benefits.unshift(
            'Streaming kualitas Ultra HD / 4K',
            'Akses semua film & series terbaru tanpa iklan',
            'Download konten untuk ditonton offline'
        );
    } else if (product.category === 'Musik') {
        benefits.unshift(
            'Kualitas audio tertinggi HD (320 kbps)',
            'Jutaan lagu & podcast eksklusif tanpa jeda iklan',
            'Download lagu & putar secara offline'
        );
    } else if (product.category === 'Desain') {
        benefits.unshift(
            'Akses ratusan ribu template premium & aset grafis',
            'Fitur eksklusif: Background Remover & Magic Resize',
            'Penyimpanan cloud ekstra besar'
        );
    }

    const originalPriceVal = parseFloat(product.original_price);
    const discountPriceVal = parseFloat(product.aksespro_price);
    const hasDiscount = originalPriceVal && originalPriceVal > discountPriceVal;
    const discountPercentage = hasDiscount
        ? Math.round(((originalPriceVal - discountPriceVal) / originalPriceVal) * 100)
        : 0;

    const submit = (e) => {
        e.preventDefault();
        router.post(route('user.checkout', product.slug));
    };

    return (
        <UserDashboardLayout user={user} title={product.name}>
            <Head title={`${product.name} `} />

            <div className="space-y-6">
                {/* Back Button */}
                <div>
                    <Link
                        href={route('user.katalog')}
                        className="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#0A2540] transition-colors bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm"
                    >
                        <svg className="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Katalog
                    </Link>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Left Column: Header Box & Details */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Header Gradient Box */}
                        <div className="bg-gradient-to-br from-[#0A2540] to-[#163b63] rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-sm">
                            <div className="absolute top-0 right-0 -mr-12 -mt-12 w-40 h-40 rounded-full bg-[#00E5FF] opacity-10 blur-2xl"></div>
                            <div className="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white opacity-5 blur-xl"></div>

                            <div className="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-6">
                                <div className="w-20 h-20 bg-white rounded-2xl shadow-lg flex-shrink-0 flex items-center justify-center overflow-hidden p-2">
                                    <img
                                        src={product.logo_path ? `/${product.logo_path.replace(/^\//, '')}` : '/image/canva.jpg'}
                                        alt={product.name}
                                        className="w-full h-full object-contain rounded-xl"
                                        onError={(e) => { e.target.src = '/image/canva.jpg'; }}
                                    />
                                </div>

                                <div>
                                    <h1 className="text-3xl sm:text-4xl font-black mb-2 text-white">{product.name}</h1>
                                    <div className="flex flex-wrap items-center gap-3">
                                        <span className="bg-[#00E5FF]/20 text-[#00E5FF] font-semibold px-3 py-1 rounded-md text-sm">
                                            {product.category}
                                        </span>
                                        <span className="text-gray-300 text-sm flex items-center gap-1.5">
                                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Masa aktif {product.duration_days} Hari
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Content Details */}
                        <div className="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100">
                            <h3 className="text-lg font-bold text-gray-900 mb-4">Tentang Produk</h3>
                            <p className="text-gray-600 mb-8 leading-relaxed text-sm sm:text-base">{product.description}</p>

                            <hr className="border-gray-100 mb-8" />

                            <h3 class="text-lg font-bold text-gray-900 mb-4">Keuntungan Layanan</h3>
                            <ul className="space-y-4">
                                {benefits.map((benefit, index) => (
                                    <li key={index} className="flex items-start gap-3">
                                        <div className="mt-0.5 bg-emerald-100 text-emerald-600 rounded-full p-1 flex-shrink-0">
                                            <svg className="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span className="text-gray-700 text-sm sm:text-base">{benefit}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>

                    {/* Right Column: Sticky Card */}
                    <div className="lg:col-span-1">
                        <div className="bg-white rounded-2xl shadow-xl shadow-[#0A2540]/5 border border-gray-100 p-6 sticky top-6">
                            <h3 className="text-lg font-bold text-gray-900 mb-5 pb-4 border-b border-gray-100">Rincian Paket</h3>

                            <div className="space-y-4 mb-6">
                                <div className="flex justify-between items-center text-sm">
                                    <span className="text-gray-500">Produk</span>
                                    <span className="font-medium text-gray-900 truncate max-w-[150px]">{product.name}</span>
                                </div>
                                <div className="flex justify-between items-center text-sm">
                                    <span className="text-gray-500">Masa Aktif</span>
                                    <span className="font-medium text-gray-900">{product.duration_days} Hari</span>
                                </div>
                                <div className="flex justify-between items-center text-sm">
                                    <span className="text-gray-500">Status Stok</span>
                                    {product.stock > 0 ? (
                                        <span className="font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-xs">
                                            Tersedia ({product.stock})
                                        </span>
                                    ) : (
                                        <span className="font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-md text-xs">Habis</span>
                                    )}
                                </div>
                            </div>

                            <div className="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-100">
                                <p className="text-sm text-gray-500 mb-1">Total Harga</p>
                                <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-1">
                                    <div>
                                        <p className="text-3xl font-black text-[#0A2540]">
                                            Rp {discountPriceVal.toLocaleString('id-ID')}
                                        </p>
                                    </div>
                                    {hasDiscount && (
                                        <div className="text-right">
                                            <p className="text-xs text-gray-400 line-through">
                                                Rp {originalPriceVal.toLocaleString('id-ID')}
                                            </p>
                                            <span className="text-xs font-bold text-red-500 block">Hemat {discountPercentage}%</span>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* ⚠️ Dusk test suite looks for form[action*="checkout"] button[type="submit"] */}
                            <form onSubmit={submit} action={route('user.checkout', product.slug)} method="POST">
                                <button
                                    type="submit"
                                    disabled={product.stock <= 0}
                                    className={`w-full bg-[#0A2540] hover:bg-[#0d2e59] text-white py-3.5 rounded-xl font-bold text-lg transition-all transform hover:scale-[1.02] shadow-md flex items-center justify-center gap-2 ${
                                        product.stock <= 0 ? 'opacity-50 cursor-not-allowed hover:scale-100' : ''
                                    }`}
                                >
                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Beli Sekarang
                                </button>
                            </form>
                            <p className="text-center text-xs text-gray-400 mt-4 flex items-center justify-center gap-1">
                                <svg className="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Transaksi dijamin 100% aman
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </UserDashboardLayout>
    );
}
