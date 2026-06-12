import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link } from '@inertiajs/react';

export default function Poin({ user, products }) {
    return (
        <UserDashboardLayout user={user} title="Tukar Poin">
            <Head title="Tukar Poin — AksesPro" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Tukar Poin</h1>
                        <p className="text-sm text-gray-500 mt-1">Gunakan poin Anda untuk menukar produk premium gratis.</p>
                    </div>

                    <div className="bg-[#0A2540] text-white px-5 py-3 rounded-2xl flex items-center gap-3">
                        <svg className="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p className="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Poin Anda</p>
                            <p className="text-lg font-black">{user.points?.toLocaleString('id-ID')} Pts</p>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {products.map((product) => (
                        <div key={product.id} className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col h-full">
                            <div className="h-24 bg-gray-100 relative flex justify-end p-4">
                                <div className="absolute -bottom-8 left-6 w-16 h-16 bg-white rounded-xl flex items-center justify-center overflow-hidden border border-gray-100 shadow-sm">
                                    <img
                                        src={product.logo_path ? `/${product.logo_path.replace(/^\//, '')}` : '/image/canva.jpg'}
                                        alt={product.name}
                                        className="w-full h-full object-contain rounded-lg"
                                        onError={(e) => { e.target.src = '/image/canva.jpg'; }}
                                    />
                                </div>
                            </div>

                            <div className="pt-12 p-6 flex-1 flex flex-col">
                                <div className="flex items-center gap-2 mb-2">
                                    <span className="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2.5 py-1 rounded-md">
                                        {product.category}
                                    </span>
                                    <span className="text-xs font-medium text-gray-500">
                                        {product.duration_days} Hari
                                    </span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-1 line-clamp-1">{product.name}</h3>
                                <p className="text-sm text-gray-500 mb-4 line-clamp-2">{product.description}</p>

                                <div className="mt-auto pt-4 border-t border-gray-50 flex items-end justify-between">
                                    <div>
                                        <p className="text-xs text-gray-400">Harga Poin</p>
                                        <p className="text-xl font-bold text-slate-900">{product.aksespro_price} Pts</p>
                                    </div>
                                    <Link
                                        href={route('user.poin.detail', product.slug)}
                                        className="bg-[#0A2540] hover:bg-[#0d2e59] text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors shadow-sm text-center"
                                    >
                                        Detail
                                    </Link>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </UserDashboardLayout>
    );
}
