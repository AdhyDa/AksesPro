import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

/**
 * User/Transaksi.jsx
 *
 * Props:
 *  - user:         { name, points }
 *  - transactions: Array<{ id, date, product, amount, method, status }>
 */
export default function Transaksi({ user, transactions }) {
    const [search, setSearch] = useState('');
    const [filterStatus, setFilterStatus] = useState('Semua');
    const [showFilterDropdown, setShowFilterDropdown] = useState(false);

    // Client-side filtering logic matching the x-show criteria
    const filteredTransactions = transactions.filter((trx) => {
        const matchesStatus = filterStatus === 'Semua' || trx.status === filterStatus;
        const matchesSearch =
            trx.product.toLowerCase().includes(search.toLowerCase()) ||
            trx.id.toLowerCase().includes(search.toLowerCase());
        return matchesStatus && matchesSearch;
    });

    return (
        <UserDashboardLayout user={user} title="Riwayat Transaksi">
            <Head title="Riwayat Transaksi " />

            <div className="space-y-6">
                
                {/* ── Header Section ─────────────────────────────────── */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Riwayat Transaksi</h1>
                        <p className="text-sm text-gray-500 mt-1">
                            Pantau seluruh aktivitas pembayaran dan unduh invoice Anda.
                        </p>
                    </div>

                    <div className="flex items-center gap-2 relative">
                        {/* Search Bar */}
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                className="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full pl-10 p-2.5 min-w-[200px]"
                                placeholder="Cari invoice/produk..."
                            />
                        </div>

                        {/* Status Filter */}
                        <div className="relative">
                            <button
                                onClick={() => setShowFilterDropdown(!showFilterDropdown)}
                                className="px-4 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors flex items-center gap-2"
                            >
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                <span>{filterStatus === 'Semua' ? 'Filter' : filterStatus}</span>
                            </button>

                            {showFilterDropdown && (
                                <>
                                    <div className="fixed inset-0 z-15" onClick={() => setShowFilterDropdown(false)} />
                                    <div className="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-20">
                                        {['Semua', 'Berhasil', 'Menunggu', 'Gagal'].map((status) => (
                                            <button
                                                key={status}
                                                onClick={() => {
                                                    setFilterStatus(status);
                                                    setShowFilterDropdown(false);
                                                }}
                                                className="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#0A2540] transition-colors"
                                            >
                                                {status}
                                            </button>
                                        ))}
                                    </div>
                                </>
                            )}
                        </div>
                    </div>
                </div>

                {/* ── Transactions Table ────────────────────────────── */}
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" className="px-6 py-4">ID Transaksi</th>
                                    <th scope="col" class="px-6 py-4">Tanggal</th>
                                    <th scope="col" class="px-6 py-4">Produk</th>
                                    <th scope="col" class="px-6 py-4">Metode</th>
                                    <th scope="col" class="px-6 py-4">Total</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filteredTransactions.length === 0 ? (
                                    <tr>
                                        <td colSpan={7} className="px-6 py-12 text-center text-gray-500">
                                            Belum ada riwayat transaksi.
                                        </td>
                                    </tr>
                                ) : (
                                    filteredTransactions.map((trx) => {
                                        // Formatted Date
                                        const trxDate = new Date(trx.date).toLocaleDateString('id-ID', {
                                            day: 'numeric',
                                            month: 'short',
                                            year: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit',
                                        });

                                        return (
                                            <tr key={trx.id} className="bg-white border-b hover:bg-gray-50 transition-colors">
                                                <td className="px-6 py-4 font-mono text-xs font-bold text-gray-900">
                                                    {trx.id}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    {trxDate} WIB
                                                </td>
                                                <td className="px-6 py-4 font-medium text-gray-900">
                                                    {trx.product}
                                                </td>
                                                <td className="px-6 py-4">
                                                    <span className="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md text-xs font-semibold">
                                                        {trx.method}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 font-bold text-[#0A2540]">
                                                    Rp {parseFloat(trx.amount).toLocaleString('id-ID')}
                                                </td>
                                                <td className="px-6 py-4">
                                                    {trx.status === 'Berhasil' || trx.status === 'success' ? (
                                                        <span className="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max border border-green-100">
                                                            <svg className="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Berhasil
                                                        </span>
                                                    ) : trx.status === 'Menunggu' || trx.status === 'pending' ? (
                                                        <span className="px-2.5 py-1 bg-orange-50 text-orange-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max border border-orange-100">
                                                            <svg className="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Menunggu
                                                        </span>
                                                    ) : (
                                                        <span className="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max border border-red-100">
                                                            <svg className="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Gagal
                                                        </span>
                                                    )}
                                                </td>
                                                <td className="px-6 py-4 text-center">
                                                    {/* In React + Inertia, since download is a raw view response, we use regular <a> */}
                                                    <a
                                                        href={route('user.invoice', trx.id)}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="p-2 text-gray-400 hover:text-[#0A2540] hover:bg-gray-100 rounded-lg transition-colors inline-flex items-center gap-2"
                                                        title="Unduh Invoice"
                                                    >
                                                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        );
                                    })
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* Pagination Placement */}
                    <div className="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <span className="text-sm text-gray-500">
                            Menampilkan 1 hingga {filteredTransactions.length} dari {filteredTransactions.length} data
                        </span>
                        <div className="flex gap-1">
                            <button className="p-2 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed" disabled>
                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button className="p-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 font-medium">1</button>
                            <button className="p-2 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed" disabled>
                                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </UserDashboardLayout>
    );
}
