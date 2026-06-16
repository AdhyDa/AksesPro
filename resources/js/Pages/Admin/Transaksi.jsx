import React, { useState } from 'react';
import { Head, usePage, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import axios from 'axios';

/**
 * Admin/Transaksi.jsx
 *
 * Props:
 *   - admin:        { name }
 *   - transactions: Array<{ id, date, user, product, total, method, status }>
 */
export default function Transaksi({ admin, transactions }) {
    const { flash } = usePage().props;

    const [search, setSearch] = useState('');
    const [filterStatus, setFilterStatus] = useState('Semua Status');
    const [filterDate, setFilterDate] = useState('');
    const [showToast, setShowToast] = useState(false);
    const [toastMessage, setToastMessage] = useState('');

    const handleVerify = (id) => {
        if (confirm(`Verifikasi transaksi ${id}?`)) {
            axios.post(`/admin/transaksi/${id}/verify`)
                .then(res => {
                    setToastMessage(`Transaksi ${id} berhasil diverifikasi`);
                    setShowToast(true);
                    setTimeout(() => {
                        setShowToast(false);
                        router.reload({ preserveScroll: true });
                    }, 1500);
                })
                .catch(err => {
                    console.error(err);
                });
        }
    };

    const handleReject = (id) => {
        if (confirm(`Tolak transaksi ${id}?`)) {
            axios.post(`/admin/transaksi/${id}/reject`)
                .then(res => {
                    setToastMessage(`Transaksi ${id} ditolak`);
                    setShowToast(true);
                    setTimeout(() => {
                        setShowToast(false);
                        router.reload({ preserveScroll: true });
                    }, 1500);
                })
                .catch(err => {
                    console.error(err);
                });
        }
    };

    const showDetail = (trx) => {
        alert(
            `ID Transaksi: ${trx.id}\n` +
            `User: ${trx.user}\n` +
            `Produk: ${trx.product}\n` +
            `Metode: ${trx.method}\n` +
            `Total: ${trx.total}\n` +
            `Status: ${trx.status}\n` +
            `Tanggal: ${trx.date}`
        );
    };

    // Filter transactions
    const filteredTransactions = transactions.filter(trx => {
        // Date matches when filterDate is empty or matches prefix of trx.date (yyyy-mm-dd)
        const dateMatch = filterDate === '' || trx.date.substring(0, 10) === filterDate;
        // Status matches
        const statusMatch = filterStatus === 'Semua Status' || trx.status === filterStatus;
        // Search matches user or ID
        const searchMatch = trx.user.toLowerCase().includes(search.toLowerCase()) || 
                            trx.id.toLowerCase().includes(search.toLowerCase());
        
        return dateMatch && statusMatch && searchMatch;
    });

    return (
        <DashboardLayout admin={admin} title="Data Transaksi">
            <Head title="Data Transaksi" />

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
                        <h1 className="text-2xl font-bold text-gray-900">Data Transaksi</h1>
                        <p className="text-sm text-gray-500 mt-1">Kelola dan verifikasi seluruh transaksi pembelian dari pengguna.</p>
                    </div>

                    <a
                        href="/admin/transaksi/export"
                        className="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2"
                    >
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export CSV
                    </a>
                </div>

                {/* Filter / Search */}
                <div className="flex flex-col md:flex-row gap-4">
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
                            placeholder="Cari ID Transaksi atau Nama User..."
                        />
                    </div>

                    <div className="flex gap-2">
                        <input
                            type="date"
                            value={filterDate}
                            onChange={(e) => setFilterDate(e.target.value)}
                            className="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3"
                        />

                        <select
                            value={filterStatus}
                            onChange={(e) => setFilterStatus(e.target.value)}
                            className="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3 pr-10"
                        >
                            <option>Semua Status</option>
                            <option>Menunggu</option>
                            <option>Sukses</option>
                            <option>Gagal</option>
                        </select>
                    </div>
                </div>

                {/* Transactions Table */}
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th scope="col" className="px-6 py-4">ID Transaksi & Waktu</th>
                                    <th scope="col" className="px-6 py-4">Pengguna</th>
                                    <th scope="col" className="px-6 py-4">Produk</th>
                                    <th scope="col" className="px-6 py-4">Metode Bayar</th>
                                    <th scope="col" className="px-6 py-4">Total</th>
                                    <th scope="col" className="px-6 py-4">Status</th>
                                    <th scope="col" className="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {filteredTransactions.map((trx) => (
                                    <tr key={trx.id} className="bg-white hover:bg-gray-50 transition-colors">
                                        <td className="px-6 py-4">
                                            <div className="font-mono text-xs font-bold text-[#0A2540]">{trx.id}</div>
                                            <div className="text-xs text-gray-400 mt-1">{trx.date}</div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="font-semibold text-gray-900">{trx.user}</div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="text-gray-700 line-clamp-1 max-w-[150px]" title={trx.product}>
                                                {trx.product}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md text-xs font-semibold">
                                                {trx.method}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 font-bold text-gray-900">
                                            {trx.total}
                                        </td>
                                        <td className="px-6 py-4">
                                            {trx.status === 'Sukses' && (
                                                <span className="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                                    <div className="w-1.5 h-1.5 rounded-full bg-green-500"></div> Sukses
                                                </span>
                                            )}
                                            {trx.status === 'Menunggu' && (
                                                <span className="px-2.5 py-1 bg-orange-50 text-orange-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                                    <div className="w-1.5 h-1.5 rounded-full bg-orange-500"></div> Menunggu
                                                </span>
                                            )}
                                            {trx.status !== 'Sukses' && trx.status !== 'Menunggu' && (
                                                <span className="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                                    <div className="w-1.5 h-1.5 rounded-full bg-red-500"></div> Gagal
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <div className="flex justify-center gap-2">
                                                {trx.status === 'Menunggu' && (
                                                    <>
                                                        <button
                                                            onClick={() => handleVerify(trx.id)}
                                                            className="p-2 bg-green-50 text-green-600 hover:bg-green-100 rounded-lg transition-colors"
                                                            title="Verifikasi Transaksi"
                                                        >
                                                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </button>
                                                        <button
                                                            onClick={() => handleReject(trx.id)}
                                                            className="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors"
                                                            title="Tolak Transaksi"
                                                        >
                                                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </>
                                                )}
                                                <button
                                                    onClick={() => showDetail(trx)}
                                                    className="p-2 bg-gray-50 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors"
                                                    title="Detail"
                                                >
                                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <span className="text-sm text-gray-500 font-medium">Menampilkan {filteredTransactions.length} dari {transactions.length} total transaksi</span>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
