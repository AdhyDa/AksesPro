import React, { useState } from 'react';
import { Head, usePage, useForm, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import axios from 'axios';

/**
 * Admin/Produk.jsx
 *
 * Props:
 *   - admin:    { name }
 *   - products: Array<{ id, name, slug, category, original_price, aksespro_price, duration_days, stock, max_stock, description, is_active, logo_path }>
 */
export default function Produk({ admin, products }) {
    const { flash } = usePage().props;

    const [search, setSearch] = useState('');
    const [filterStatus, setFilterStatus] = useState('Semua Status');
    const [showToast, setShowToast] = useState(false);
    const [toastMessage, setToastMessage] = useState('');
    
    const [openAddModal, setOpenAddModal] = useState(false);
    const [openEditModal, setOpenEditModal] = useState(false);
    const [editProduct, setEditProduct] = useState({
        id: '',
        name: '',
        category: 'Streaming',
        original_price: 0,
        aksespro_price: 0,
        duration_days: 30,
        stock: 0,
        max_stock: 0,
        description: ''
    });

    // Inertia form for adding new product
    const { data: addData, setData: setAddData, post: postAdd, reset: resetAdd, errors: addErrors, processing: addProcessing } = useForm({
        name: '',
        category: 'Streaming',
        original_price: '',
        aksespro_price: '',
        duration_days: 30,
        stock: 0,
        max_stock: 100,
        description: ''
    });

    // Inertia form for editing product
    const { data: editData, setData: setEditData, post: postEdit, errors: editErrors, processing: editProcessing } = useForm({
        name: '',
        category: 'Streaming',
        original_price: '',
        aksespro_price: '',
        duration_days: 30,
        stock: 0,
        max_stock: 100,
        description: ''
    });

    const getProductImage = (name) => {
        const pName = name.toLowerCase();
        if (pName.includes('netflix')) return '/image/netflix.jpg';
        if (pName.includes('spotify')) return '/image/spotify.jpg';
        if (pName.includes('canva')) return '/image/canva.jpg';
        if (pName.includes('youtube')) return '/image/youtube.webp';
        if (pName.includes('chatgpt')) return '/image/chatgpt.jpg';
        if (pName.includes('zoom')) return '/image/zoom.jpg';
        return '/image/zoom.jpg';
    };

    const handleToggleActive = (id, name, currentStatus) => {
        axios.post(`/admin/produk/${id}/toggle-active`)
            .then(res => {
                if (res.data.success) {
                    setToastMessage(`Status ${name} berhasil diubah`);
                    setShowToast(true);
                    setTimeout(() => {
                        setShowToast(false);
                        router.reload({ preserveScroll: true });
                    }, 1500);
                }
            })
            .catch(err => {
                console.error(err);
            });
    };

    const handleDelete = (id, name) => {
        if (confirm(`Apakah Anda yakin ingin menghapus produk ${name}?`)) {
            router.delete(`/admin/produk/${id}`, {
                onSuccess: () => {
                    setToastMessage(`Produk ${name} berhasil dihapus`);
                    setShowToast(true);
                    setTimeout(() => setShowToast(false), 2000);
                }
            });
        }
    };

    const handleOpenEdit = (product) => {
        setEditProduct(product);
        setEditData({
            name: product.name,
            category: product.category,
            original_price: product.original_price,
            aksespro_price: product.aksespro_price,
            duration_days: product.duration_days,
            stock: product.stock,
            max_stock: product.max_stock,
            description: product.description || ''
        });
        setOpenEditModal(true);
    };

    const submitAdd = (e) => {
        e.preventDefault();
        postAdd('/admin/produk', {
            onSuccess: () => {
                setOpenAddModal(false);
                resetAdd();
                setToastMessage('Produk berhasil ditambahkan.');
                setShowToast(true);
                setTimeout(() => setShowToast(false), 2000);
            }
        });
    };

    const submitEdit = (e) => {
        e.preventDefault();
        // The endpoint is /admin/produk/{id} which supports PUT and POST. We'll use POST since file updates sometimes require POST in laravel
        postEdit(`/admin/produk/${editProduct.id}`, {
            onSuccess: () => {
                setOpenEditModal(false);
                setToastMessage('Produk berhasil diperbarui.');
                setShowToast(true);
                setTimeout(() => setShowToast(false), 2000);
            }
        });
    };

    // Filter products
    const filteredProducts = products.filter(product => {
        const status = !product.is_active ? 'Nonaktif' : (product.stock === 0 ? 'Habis' : 'Aktif');
        const matchesSearch = product.name.toLowerCase().includes(search.toLowerCase());
        const matchesStatus = filterStatus === 'Semua Status' || filterStatus === status;
        return matchesSearch && matchesStatus;
    });

    const formatRupiah = (val) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(val);
    };

    return (
        <DashboardLayout admin={admin} title="Kelola Produk">
            <Head title="Kelola Produk" />

            <div className="space-y-6">
                {/* Toast Notification */}
                {showToast && (
                    <div className="fixed bottom-4 right-4 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-all duration-300">
                        <svg className="w-5 h-5 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span className="text-sm font-medium">{toastMessage}</span>
                    </div>
                )}

                {/* Header Section */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Kelola Produk</h1>
                        <p className="text-sm text-gray-500 mt-1">Daftar layanan akun premium dan ketersediaan stok.</p>
                    </div>

                    <button
                        onClick={() => setOpenAddModal(true)}
                        className="px-5 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2"
                    >
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Produk Baru
                    </button>
                </div>

                {/* Flash Success Message */}
                {flash?.success && (
                    <div className="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                        <div className="flex">
                            <div className="flex-shrink-0">
                                <svg className="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                </svg>
                            </div>
                            <div className="ml-3">
                                <p className="text-sm font-semibold text-emerald-800">{flash.success}</p>
                            </div>
                        </div>
                    </div>
                )}

                {/* Filter / Search */}
                <div className="flex flex-col sm:flex-row gap-4 mb-6">
                    <div className="relative flex-1">
                        <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full pl-10 p-3"
                            placeholder="Cari produk..."
                        />
                    </div>
                    <select
                        value={filterStatus}
                        onChange={(e) => setFilterStatus(e.target.value)}
                        className="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3 min-w-[150px]"
                    >
                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Nonaktif</option>
                        <option>Habis</option>
                    </select>
                </div>

                {/* Product Horizontal Cards List */}
                <div className="space-y-4">
                    {filteredProducts.map((product) => {
                        const status = !product.is_active ? 'Nonaktif' : (product.stock === 0 ? 'Habis' : 'Aktif');
                        const stockPercent = product.max_stock > 0 ? Math.round((product.stock / product.max_stock) * 100) : 0;
                        const progressColor = stockPercent > 50 ? 'bg-[#00E5FF]' : (stockPercent > 20 ? 'bg-orange-400' : 'bg-red-500');

                        return (
                            <div
                                key={product.id}
                                className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row group hover:shadow-md transition-shadow"
                            >
                                {/* Left: Image Area */}
                                <div className="w-full md:w-48 lg:w-56 h-48 md:h-auto bg-gray-50 flex-shrink-0 relative border-r border-gray-100">
                                    <div className="absolute inset-0 flex items-center justify-center p-6">
                                        <img
                                            src={getProductImage(product.name)}
                                            alt={product.name}
                                            className="w-full h-full object-contain drop-shadow-md rounded-2xl transition-transform group-hover:scale-105"
                                        />
                                    </div>
                                </div>

                                {/* Right: Content Area */}
                                <div className="p-6 flex-1 flex flex-col justify-between">
                                    {/* Top: Title & Toggle */}
                                    <div className="flex items-start justify-between gap-4 mb-4">
                                        <div>
                                            <div className="flex items-center gap-2 mb-1">
                                                <span className="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2 py-0.5 rounded-md">
                                                    {product.category}
                                                </span>
                                                {status === 'Aktif' && (
                                                    <span className="text-xs font-semibold text-green-600">Aktif</span>
                                                )}
                                                {status === 'Habis' && (
                                                    <span className="text-xs font-semibold text-red-500">Stok Habis</span>
                                                )}
                                                {status === 'Nonaktif' && (
                                                    <span className="text-xs font-semibold text-gray-500">Nonaktif</span>
                                                )}
                                            </div>
                                            <h3 className="text-xl font-bold text-[#0A2540]">{product.name}</h3>
                                            <p className="text-sm text-gray-500 mt-1 line-clamp-2 max-w-xl">{product.description}</p>
                                        </div>

                                        {/* Manual Toggle Switch */}
                                        <div className="flex items-center flex-shrink-0" title="Aktifkan/Nonaktifkan Manual">
                                            <label className="relative inline-flex items-center cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    onChange={() => handleToggleActive(product.id, product.name, product.is_active)}
                                                    className="sr-only peer"
                                                    checked={!!product.is_active}
                                                />
                                                <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0A2540]"></div>
                                            </label>
                                        </div>
                                    </div>

                                    {/* Bottom: Progress & Actions */}
                                    <div className="flex flex-col md:flex-row md:items-end justify-between gap-6 mt-4">
                                        {/* Stock Progress Bar */}
                                        <div className="flex-1 max-w-md">
                                            <div className="flex justify-between text-sm font-semibold mb-2">
                                                <span className="text-gray-900">
                                                    {formatRupiah(product.aksespro_price)}
                                                    <span className="text-xs text-gray-500 font-normal"> / slot</span>
                                                </span>
                                                <span className="text-gray-600">{product.stock} / {product.max_stock} Tersisa</span>
                                            </div>
                                            <div className="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden border border-gray-200/50">
                                                <div className={`h-2.5 rounded-full ${progressColor}`} style={{ width: `${stockPercent}%` }}></div>
                                            </div>
                                            <p className="text-xs text-gray-400 mt-1.5">
                                                *Stok berkurang otomatis saat user transaksi. (Modal: {formatRupiah(product.original_price)} &bull; Durasi: {product.duration_days} hari)
                                            </p>
                                        </div>

                                        {/* Actions */}
                                        <div className="flex items-center gap-2 flex-shrink-0">
                                            <button
                                                onClick={() => handleOpenEdit(product)}
                                                className="px-4 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-sm font-medium transition-colors flex items-center gap-2"
                                            >
                                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </button>
                                            <button
                                                onClick={() => handleDelete(product.id, product.name)}
                                                className="p-2 bg-white border border-red-100 text-red-500 hover:bg-red-50 rounded-xl transition-colors"
                                                title="Hapus Produk"
                                            >
                                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>

            {/* Modal: Buat Produk Baru */}
            {openAddModal && (
                <div className="fixed inset-0 z-50 overflow-y-auto">
                    <div className="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div className="fixed inset-0 transition-opacity" onClick={() => setOpenAddModal(false)}>
                            <div className="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div className="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form onSubmit={submitAdd}>
                                <div className="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4">Buat Produk Baru</h3>
                                    <div className="space-y-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Nama Produk</label>
                                            <input
                                                type="text"
                                                value={addData.name}
                                                onChange={(e) => setAddData('name', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                required
                                            />
                                            {addErrors.name && <div className="text-red-500 text-xs mt-1">{addErrors.name}</div>}
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Kategori</label>
                                                <select
                                                    value={addData.category}
                                                    onChange={(e) => setAddData('category', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                >
                                                    <option value="Streaming">Streaming</option>
                                                    <option value="Musik">Musik</option>
                                                    <option value="Desain">Desain</option>
                                                    <option value="Produktivitas">Produktivitas</option>
                                                </select>
                                                {addErrors.category && <div className="text-red-500 text-xs mt-1">{addErrors.category}</div>}
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Durasi (Hari)</label>
                                                <input
                                                    type="number"
                                                    value={addData.duration_days}
                                                    onChange={(e) => setAddData('duration_days', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {addErrors.duration_days && <div className="text-red-500 text-xs mt-1">{addErrors.duration_days}</div>}
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Harga Modal (Rp)</label>
                                                <input
                                                    type="number"
                                                    value={addData.original_price}
                                                    onChange={(e) => setAddData('original_price', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {addErrors.original_price && <div className="text-red-500 text-xs mt-1">{addErrors.original_price}</div>}
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                                                <input
                                                    type="number"
                                                    value={addData.aksespro_price}
                                                    onChange={(e) => setAddData('aksespro_price', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {addErrors.aksespro_price && <div className="text-red-500 text-xs mt-1">{addErrors.aksespro_price}</div>}
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Stok Saat Ini</label>
                                                <input
                                                    type="number"
                                                    value={addData.stock}
                                                    onChange={(e) => setAddData('stock', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {addErrors.stock && <div className="text-red-500 text-xs mt-1">{addErrors.stock}</div>}
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Stok Maksimum</label>
                                                <input
                                                    type="number"
                                                    value={addData.max_stock}
                                                    onChange={(e) => setAddData('max_stock', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {addErrors.max_stock && <div className="text-red-500 text-xs mt-1">{addErrors.max_stock}</div>}
                                            </div>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Deskripsi</label>
                                            <textarea
                                                value={addData.description}
                                                onChange={(e) => setAddData('description', e.target.value)}
                                                rows="3"
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                            ></textarea>
                                            {addErrors.description && <div className="text-red-500 text-xs mt-1">{addErrors.description}</div>}
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-2">
                                    <button
                                        type="submit"
                                        disabled={addProcessing}
                                        className="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-base font-bold text-white sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                                    >
                                        Simpan
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => setOpenAddModal(false)}
                                        className="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                                    >
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}

            {/* Modal: Edit Produk */}
            {openEditModal && (
                <div className="fixed inset-0 z-50 overflow-y-auto">
                    <div className="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div className="fixed inset-0 transition-opacity" onClick={() => setOpenEditModal(false)}>
                            <div className="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div className="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form onSubmit={submitEdit}>
                                <div className="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                                    <h3 className="text-lg font-bold text-gray-900 mb-4">Edit Produk</h3>
                                    <div className="space-y-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Nama Produk</label>
                                            <input
                                                type="text"
                                                value={editData.name}
                                                onChange={(e) => setEditData('name', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                required
                                            />
                                            {editErrors.name && <div className="text-red-500 text-xs mt-1">{editErrors.name}</div>}
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Kategori</label>
                                                <select
                                                    value={editData.category}
                                                    onChange={(e) => setEditData('category', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                >
                                                    <option value="Streaming">Streaming</option>
                                                    <option value="Musik">Musik</option>
                                                    <option value="Desain">Desain</option>
                                                    <option value="Produktivitas">Produktivitas</option>
                                                </select>
                                                {editErrors.category && <div className="text-red-500 text-xs mt-1">{editErrors.category}</div>}
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Durasi (Hari)</label>
                                                <input
                                                    type="number"
                                                    value={editData.duration_days}
                                                    onChange={(e) => setEditData('duration_days', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {editErrors.duration_days && <div className="text-red-500 text-xs mt-1">{editErrors.duration_days}</div>}
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Harga Modal (Rp)</label>
                                                <input
                                                    type="number"
                                                    value={editData.original_price}
                                                    onChange={(e) => setEditData('original_price', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {editErrors.original_price && <div className="text-red-500 text-xs mt-1">{editErrors.original_price}</div>}
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                                                <input
                                                    type="number"
                                                    value={editData.aksespro_price}
                                                    onChange={(e) => setEditData('aksespro_price', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {editErrors.aksespro_price && <div className="text-red-500 text-xs mt-1">{editErrors.aksespro_price}</div>}
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Stok Saat Ini</label>
                                                <input
                                                    type="number"
                                                    value={editData.stock}
                                                    onChange={(e) => setEditData('stock', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {editErrors.stock && <div className="text-red-500 text-xs mt-1">{editErrors.stock}</div>}
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700">Stok Maksimum</label>
                                                <input
                                                    type="number"
                                                    value={editData.max_stock}
                                                    onChange={(e) => setEditData('max_stock', e.target.value)}
                                                    className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                    required
                                                />
                                                {editErrors.max_stock && <div className="text-red-500 text-xs mt-1">{editErrors.max_stock}</div>}
                                            </div>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Deskripsi</label>
                                            <textarea
                                                value={editData.description}
                                                onChange={(e) => setEditData('description', e.target.value)}
                                                rows="3"
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                            ></textarea>
                                            {editErrors.description && <div className="text-red-500 text-xs mt-1">{editErrors.description}</div>}
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-2">
                                    <button
                                        type="submit"
                                        disabled={editProcessing}
                                        className="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-base font-bold text-white sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                                    >
                                        Simpan
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => setOpenEditModal(false)}
                                        className="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                                    >
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
        </DashboardLayout>
    );
}
