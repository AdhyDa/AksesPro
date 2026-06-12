import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link, useForm } from '@inertiajs/react';

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

    return (
        <UserDashboardLayout user={user} title={`Detail Poin — ${product.name}`}>
            <Head title={`Tukar Poin ${product.name} — AksesPro`} />

            <div className="max-w-4xl mx-auto space-y-6">
                <div className="flex items-center gap-2 text-sm text-gray-500">
                    <Link href={route('user.poin')} className="hover:text-gray-900 transition-colors">
                        Tukar Poin
                    </Link>
                    <svg className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                    </svg>
                    <span className="text-gray-900 font-medium">{product.name}</span>
                </div>

                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                    {/* Left: Product Info */}
                    <div className="p-8 md:w-3/5 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-100">
                        <div>
                            <div className="flex items-center gap-3 mb-6">
                                <div className="w-16 h-16 bg-white rounded-xl flex items-center justify-center overflow-hidden border border-gray-100 shadow-sm p-1">
                                    <img
                                        src={product.logo_path ? `/${product.logo_path.replace(/^\//, '')}` : '/image/canva.jpg'}
                                        alt={product.name}
                                        className="w-full h-full object-contain rounded-lg"
                                        onError={(e) => { e.target.src = '/image/canva.jpg'; }}
                                    />
                                </div>
                                <div>
                                    <span className="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2.5 py-1 rounded-md">
                                        {product.category}
                                    </span>
                                    <h1 className="text-2xl font-extrabold text-gray-900 mt-1">{product.name}</h1>
                                </div>
                            </div>

                            <div className="space-y-4">
                                <div>
                                    <h3 className="text-sm font-semibold text-gray-900 uppercase tracking-wider">Deskripsi Produk</h3>
                                    <p className="text-gray-600 mt-2 text-sm leading-relaxed whitespace-pre-wrap">{product.description}</p>
                                </div>

                                <div className="grid grid-cols-2 gap-4 pt-4 border-t border-gray-50">
                                    <div>
                                        <p className="text-xs text-gray-400">Durasi Akses</p>
                                        <p className="text-sm font-semibold text-gray-900 mt-1">{product.duration_days} Hari</p>
                                    </div>
                                    <div>
                                        <p className="text-xs text-gray-400">Status Stok</p>
                                        <p className={`text-sm font-semibold mt-1 ${isOutOfStock ? 'text-red-500' : 'text-green-500'}`}>
                                            {isOutOfStock ? 'Habis' : `${product.stock} Akun Tersedia`}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Right: Exchange Action Card */}
                    <div className="p-8 md:w-2/5 bg-gray-50/50 flex flex-col justify-between">
                        <div className="space-y-6">
                            <div>
                                <h3 className="text-xs font-semibold text-gray-500 uppercase tracking-wider">Poin Anda Saat Ini</h3>
                                <div className="flex items-center gap-2 mt-1">
                                    <svg className="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-10-2a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002-2v-3a2 2 0 00-2-2H8z" clipRule="evenodd" />
                                    </svg>
                                    <p className="text-lg font-bold text-gray-900">{user.points?.toLocaleString('id-ID')} Pts</p>
                                </div>
                            </div>

                            <div className="p-4 bg-white rounded-xl border border-gray-100 shadow-sm space-y-3">
                                <div className="flex justify-between items-center text-sm">
                                    <span className="text-gray-500">Biaya Penukaran</span>
                                    <span className="font-semibold text-gray-900">{product.aksespro_price} Pts</span>
                                </div>
                                <div className="border-t border-gray-100 pt-3 flex justify-between items-center text-sm font-bold text-gray-900">
                                    <span>Sisa Poin</span>
                                    <span className={hasEnoughPoints ? 'text-[#00b8cc]' : 'text-red-500'}>
                                        {hasEnoughPoints ? `${(user.points - product.aksespro_price).toLocaleString('id-ID')} Pts` : 'Tidak Cukup'}
                                    </span>
                                </div>
                            </div>

                            {!hasEnoughPoints && (
                                <div className="bg-red-50 text-red-700 p-3.5 rounded-xl text-xs flex items-start gap-2 border border-red-100">
                                    <svg className="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Poin Anda tidak mencukupi untuk melakukan penukaran produk premium ini.</span>
                                </div>
                            )}

                            {isOutOfStock && !isOutOfStock && (
                                <div className="bg-red-50 text-red-700 p-3.5 rounded-xl text-xs flex items-start gap-2 border border-red-100">
                                    <svg className="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Stok akun produk ini sedang habis saat ini. Silakan hubungi admin atau cek kembali nanti.</span>
                                </div>
                            )}
                        </div>

                        <form onSubmit={handleRedeem} className="mt-8">
                            <button
                                type="submit"
                                disabled={processing || !hasEnoughPoints || isOutOfStock}
                                className={`w-full py-3 px-4 rounded-xl font-bold text-center transition-all duration-150 ${
                                    hasEnoughPoints && !isOutOfStock
                                        ? 'bg-[#0A2540] hover:bg-[#0d2e59] text-white shadow-md'
                                        : 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                }`}
                            >
                                {processing ? 'Memproses...' : 'Tukarkan Poin'}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </UserDashboardLayout>
    );
}
