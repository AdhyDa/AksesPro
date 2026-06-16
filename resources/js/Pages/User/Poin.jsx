import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link } from '@inertiajs/react';

/**
 * User/Poin.jsx
 *
 * Props:
 *  - user:     { name, points }
 *  - products: Array<{ id, name, slug, category, description, aksespro_price, duration_days, logo_path, stock }>
 */
export default function Poin({ user, products }) {
    const userPoints = user.points ?? 0;

    // Helper to get fallback logo mapping matching Blade PHP template logic
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

    return (
        <UserDashboardLayout user={user} title="Tukar Poin">
            <Head title="Tukar Poin — AksesPro" />

            <div className="space-y-8">
                
                {/* ── Header Section ─────────────────────────────────── */}
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Tukar Poin</h1>
                    <p className="text-sm text-gray-500 mt-1">
                        Gunakan poin Anda untuk mendapatkan akses premium secara gratis.
                    </p>
                </div>

                {/* ── Point Concept Banner ────────────────────────────── */}
                <div className="bg-gradient-to-br from-[#0A2540] to-[#1a3a6e] rounded-3xl p-8 sm:p-12 relative overflow-hidden shadow-xl border border-[#0A2540]/20 flex flex-col md:flex-row items-center justify-between gap-8 animate-fade-in">
                    {/* Decorative Elements */}
                    <div className="absolute top-0 right-0 w-64 h-64 bg-[#00E5FF]/10 rounded-full blur-3xl -mr-20 -mt-20" />
                    <div className="absolute bottom-0 left-0 w-40 h-40 bg-[#00E5FF]/20 rounded-full blur-2xl -ml-10 -mb-10" />

                    <div className="relative z-10 max-w-xl">
                        <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-[#00E5FF] text-xs font-bold uppercase tracking-wider mb-4">
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Sistem Poin Baru
                        </div>
                        <h2 className="text-3xl sm:text-4xl font-black text-white mb-4 leading-tight">
                            1 Poin <span className="text-[#00E5FF]">=</span> 1 Rupiah
                        </h2>
                        <p className="text-blue-100 text-base sm:text-lg">
                            Lebih simpel, lebih transparan. Kini Anda dapat langsung menukarkan poin Anda dengan paket berlangganan premium di bawah ini. Tidak perlu pusing menghitung konversi!
                        </p>
                    </div>

                    {/* Current Balance Card */}
                    <div className="relative z-10 bg-white rounded-2xl p-6 shadow-2xl w-full md:w-auto min-w-[280px] text-center transform hover:scale-105 transition-transform duration-300">
                        <p className="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">
                            Saldo Poin Anda
                        </p>
                        <div className="flex items-center justify-center gap-2 mb-1">
                            <svg className="w-8 h-8 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 className="text-4xl font-black text-[#0A2540]">
                                {userPoints.toLocaleString('id-ID')}
                            </h3>
                        </div>
                        <p className="text-[#00b8cc] font-medium text-sm">
                            Senilai Rp {userPoints.toLocaleString('id-ID')}
                        </p>
                    </div>
                </div>

                {/* ── Redeem Catalog Section ──────────────────────────── */}
                <div className="space-y-6">
                    <h3 className="text-xl font-bold text-gray-900">Tersedia untuk Ditukar</h3>

                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        {products.map((product) => {
                            const canRedeem = userPoints >= product.aksespro_price;
                            const shortfall = product.aksespro_price - userPoints;
                            const logoSrc = product.logo_path ? `/${product.logo_path.replace(/^\//, '')}` : getFallbackLogo(product.name);

                            return (
                                <div
                                    key={product.id}
                                    className={`bg-white rounded-2xl shadow-sm border ${
                                        canRedeem ? 'border-[#00E5FF]/30' : 'border-gray-100'
                                    } overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col h-full relative`}
                                >
                                    {canRedeem && (
                                        <div className="absolute top-0 right-0 bg-[#00E5FF] text-[#0A2540] text-xs font-bold px-3 py-1 rounded-bl-lg z-10 flex items-center gap-1">
                                            <svg className="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Bisa Ditukar
                                        </div>
                                    )}

                                    {/* Top / Banner Part */}
                                    <div className="h-24 bg-gradient-to-r from-gray-50 to-gray-100 relative flex justify-end p-4">
                                        <div className="absolute -bottom-8 left-6 w-16 h-16 bg-white rounded-xl shadow-md border border-gray-50 flex items-center justify-center overflow-hidden p-1 group-hover:-translate-y-1 transition-transform">
                                            <img
                                                src={logoSrc}
                                                alt={product.name}
                                                className="w-full h-full object-contain rounded-lg"
                                                onError={(e) => { e.target.src = getFallbackLogo(product.name); }}
                                            />
                                        </div>
                                    </div>

                                    {/* Body */}
                                    <div className="pt-12 p-6 flex-1 flex flex-col justify-between">
                                        <div className="mb-4">
                                            <div className="flex items-center gap-2 mb-2">
                                                <span className="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2.5 py-1 rounded-md">
                                                    {product.category}
                                                </span>
                                                <span className="text-xs font-medium text-gray-500 flex items-center gap-1">
                                                    <svg className="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {product.duration_days} Hari
                                                </span>
                                            </div>
                                            <h3 className="text-xl font-bold text-gray-900 mb-2 line-clamp-1">{product.name}</h3>
                                            <p className="text-sm text-gray-500 line-clamp-2">
                                                {product.description || 'Akses fitur premium tanpa batas, nikmati layanan terbaik dengan harga super hemat.'}
                                            </p>
                                        </div>

                                        {/* Pricing & Action */}
                                        <div className="pt-4 border-t border-gray-50 flex flex-col gap-4">
                                            <div>
                                                <p className="text-xs text-gray-500 mb-1">Harga Penukaran:</p>
                                                <div className="flex items-end gap-2">
                                                    <p className={`text-2xl font-black ${canRedeem ? 'text-[#0A2540]' : 'text-gray-400'}`}>
                                                        {product.aksespro_price.toLocaleString('id-ID')}
                                                    </p>
                                                    <p className={`text-sm font-semibold ${canRedeem ? 'text-[#00b8cc]' : 'text-gray-400'} mb-1`}>
                                                        Poin
                                                    </p>
                                                </div>
                                            </div>

                                            {canRedeem ? (
                                                <Link
                                                    href={route('user.poin.detail', product.slug)}
                                                    className="w-full bg-[#0A2540] hover:bg-[#0d2e59] text-white py-2.5 rounded-xl font-bold transition-all transform hover:scale-[1.02] shadow-sm flex justify-center items-center gap-2"
                                                >
                                                    Tukar Sekarang
                                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </Link>
                                            ) : (
                                                <button
                                                    disabled
                                                    className="w-full bg-gray-100 text-gray-400 py-2.5 rounded-xl font-bold cursor-not-allowed text-center text-sm"
                                                >
                                                    Kurang {shortfall.toLocaleString('id-ID')} Poin
                                                </button>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>

            </div>
        </UserDashboardLayout>
    );
}
