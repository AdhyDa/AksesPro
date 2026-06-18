import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

export default function Katalog({ user, products, search }) {
    const [category, setCategory] = useState('Semua');

    const filteredProducts = products.filter(
        (product) => category === 'Semua' || product.category === category
    );

    return (
        <UserDashboardLayout user={user} title="Katalog Produk">
            <Head title="Katalog Produk " />

            <div className="space-y-6">
                {/* Header Section */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Katalog Produk</h1>
                        <p className="text-sm text-gray-500 mt-1">Pilih layanan premium favorit Anda dengan harga pelajar.</p>
                    </div>

                    {/* Category Filter */}
                    <div className="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 hide-scrollbar">
                        {['Semua', 'Streaming', 'Musik', 'Desain', 'Produktivitas'].map((cat) => (
                            <button
                                key={cat}
                                onClick={() => setCategory(cat)}
                                className={`px-4 py-2 border rounded-full text-sm font-medium whitespace-nowrap transition-colors ${
                                    category === cat
                                        ? 'bg-[#0A2540] text-white border-[#0A2540]'
                                        : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50'
                                }`}
                            >
                                {cat}
                            </button>
                        ))}
                    </div>
                </div>

                {/* Product Grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {filteredProducts.map((product) => {
                        const originalPriceVal = parseFloat(product.original_price);
                        const discountPriceVal = parseFloat(product.aksespro_price);
                        const hasDiscount = originalPriceVal && originalPriceVal > discountPriceVal;
                        const savingsPercentage = hasDiscount
                            ? Math.round(((originalPriceVal - discountPriceVal) / originalPriceVal) * 100)
                            : 0;

                        return (
                            <div
                                key={product.id}
                                className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col h-full"
                            >
                                {/* Top / Banner Part */}
                                <div className="h-24 bg-gray-200 relative flex justify-end p-4">
                                    {/* Discount Badge */}
                                    {hasDiscount && savingsPercentage > 0 && (
                                        <div className="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-lg">
                                            Hemat {savingsPercentage}%
                                        </div>
                                    )}
                                    {/* Icon / Initial */}
                                    <div className="absolute -bottom-8 left-6 w-16 h-16 bg-white rounded-xl flex items-center justify-center overflow-hidden group-hover:-translate-y-1 transition-transform border border-gray-100 shadow-sm">
                                        <img
                                            src={product.logo_path ? `/${product.logo_path.replace(/^\//, '')}` : '/image/canva.jpg'}
                                            alt={product.name}
                                            className="w-full h-full object-contain rounded-lg"
                                            onError={(e) => { e.target.src = '/image/canva.jpg'; }}
                                        />
                                    </div>
                                </div>

                                {/* Body */}
                                <div className="pt-12 p-6 flex-1 flex flex-col">
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
                                    <h3 className="text-xl font-bold text-gray-900 mb-1 line-clamp-1">{product.name}</h3>
                                    <p className="text-sm text-gray-500 mb-4 line-clamp-2">{product.description || 'Akses fitur premium tanpa batas, nikmati layanan terbaik dengan harga super hemat.'}</p>

                                    {/* Pricing & Action */}
                                    <div className="mt-auto pt-4 border-t border-gray-50 flex items-end justify-between">
                                        <div>
                                            {hasDiscount && (
                                                <p className="line-through text-gray-400 text-sm">
                                                    Rp {originalPriceVal.toLocaleString('id-ID')}
                                                </p>
                                            )}
                                            <p className="text-xl font-bold text-slate-900">
                                                Rp {discountPriceVal.toLocaleString('id-ID')}
                                            </p>
                                        </div>
                                        <Link
                                            href={route('user.katalog.detail', product.slug)}
                                            className="bg-[#0A2540] hover:bg-[#0d2e59] text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors shadow-sm group-hover:shadow-md text-center"
                                        >
                                            Beli
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </UserDashboardLayout>
    );
}
