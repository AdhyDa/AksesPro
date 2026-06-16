import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link, useForm } from '@inertiajs/react';

/**
 * User/PoinDetail.jsx
 *
 * Props:
 *  - user:     { name, points }
 *  - product:  { id, name, slug, category, description, aksespro_price, duration_days, logo_path, stock }
 */
export default function PoinDetail({ user, product }) {
    const { post, processing } = useForm();

    const handleRedeem = (e) => {
        e.preventDefault();
        if (confirm(`Apakah Anda yakin ingin menukarkan ${product.aksespro_price} poin untuk ${product.name}?`)) {
            post(route('user.poin.redeem', product.id));
        }
    };

    const hasEnoughPoints = user.points >= product.aksespro_price;
    const isOutOfStock = product.stock <= 0;

    // Benefits mapping matching the controller category checks
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

    // Fallback logo mapping matching Poin.jsx
    const getFallbackLogo = (name) => {
        const pName = name.toLowerCase();
        if (pName.includes('netflix')) return '/image/netflix.jpg';
        if (pName.includes('spotify')) return '/image/spotify.jpg';
        if (pName.includes('canva')) return '/image/canva.jpg';
        if (pName.includes('youtube')) return '/image/youtube.webp';
        if (pName.includes('chatgpt')) return '/image/chatgpt.jpg';
        if (pName.includes('zoom')) return '/image/zoom.jpg';
        return '/image/zoom.jpg';
    };

    const logoSrc = product.logo_path ? `/${product.logo_path.replace(/^\//, '')}` : getFallbackLogo(product.name);

    return (
        <UserDashboardLayout user={user} title={product.name}>
            <Head title={`${product.name} — Tukar Poin`} />

            <div className="space-y-6">
                
                {/* ── Back Button ────────────────────────────────────── */}
                <div>
                    <Link
                        href={route('user.poin')}
                        className="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#0A2540] transition-colors bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm"
                    >
                        <svg className="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Tukar Poin
                    </Link>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {/* ── Left Column: Header Box & Details ─────────────── */}
                    <div className="lg:col-span-2 space-y-6">
                        
                        {/* Header Gradient Box */}
                        <div className="bg-gradient-to-br from-[#0A2540] to-[#163b63] rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-sm">
                            {/* Decorative Elements */}
                            <div className="absolute top-0 right-0 -mr-12 -mt-12 w-40 h-40 rounded-full bg-[#00E5FF] opacity-10 blur-2xl" />
                            <div className="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white opacity-5 blur-xl" />

                            <div className="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-6">
                                <div className="w-20 h-20 bg-white rounded-2xl shadow-lg flex-shrink-0 flex items-center justify-center overflow-hidden p-2 border border-gray-100">
                                    <img
                                        src={logoSrc}
                                        alt={product.name}
                                        className="w-full h-full object-contain rounded-xl"
                                        onError={(e) => { e.target.src = getFallbackLogo(product.name); }}
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
                            <p className="text-gray-600 mb-8 leading-relaxed text-sm sm:text-base">
                                {product.description || 'Akses fitur premium tanpa batas, nikmati layanan terbaik dengan harga super hemat.'}
                            </p>

                            <hr className="border-gray-100 mb-8" />

                            <h3 className="text-lg font-bold text-gray-900 mb-4">Keuntungan Layanan</h3>
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

                    {/* ── Right Column: Sticky Card ──────────────────────── */}
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
                                    {!isOutOfStock ? (
                                        <span className="font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-xs">
                                            Tersedia ({product.stock})
                                        </span>
                                    ) : (
                                        <span className="font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-md text-xs">Habis</span>
                                    )}
                                </div>
                            </div>

                            <div className="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-100">
                                <p className="text-sm text-gray-500 mb-1">Total Poin</p>
                                <div className="flex items-end justify-between gap-1">
                                    <div>
                                        <p className="text-3xl font-black text-[#0A2540]">
                                            {product.aksespro_price.toLocaleString('id-ID')}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <span className="text-xs font-bold text-[#00b8cc] block">Poin</span>
                                    </div>
                                </div>
                            </div>

                            {/* Warning notification for point insufficiency */}
                            {!hasEnoughPoints && (
                                <div className="mb-4 bg-red-50 text-red-700 p-3.5 rounded-xl text-xs flex items-start gap-2 border border-red-100">
                                    <svg className="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Poin Anda tidak mencukupi untuk melakukan penukaran produk premium ini.</span>
                                </div>
                            )}

                            {/* Warning notification for stock status */}
                            {isOutOfStock && (
                                <div className="mb-4 bg-red-50 text-red-700 p-3.5 rounded-xl text-xs flex items-start gap-2 border border-red-100">
                                    <svg className="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Stok akun produk ini sedang habis saat ini. Silakan hubungi admin atau cek kembali nanti.</span>
                                </div>
                            )}

                            <form onSubmit={handleRedeem}>
                                <button
                                    type="submit"
                                    disabled={processing || !hasEnoughPoints || isOutOfStock}
                                    className={`w-full py-3.5 rounded-xl font-bold text-lg transition-all transform hover:scale-[1.02] shadow-md flex items-center justify-center gap-2 ${
                                        hasEnoughPoints && !isOutOfStock && !processing
                                            ? 'bg-[#0A2540] hover:bg-[#0d2e59] text-white'
                                            : 'bg-gray-100 text-gray-400 cursor-not-allowed hover:scale-100'
                                    }`}
                                >
                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    Tukar Sekarang
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
