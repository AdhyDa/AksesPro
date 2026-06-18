import React, { useState, useEffect, useRef } from 'react';
import { Head, Link, router, usePage } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import Chart from 'chart.js/auto';

/**
 * Admin/Dashboard.jsx
 *
 * Props:
 *   - admin:              { name }
 *   - stats:              { monthly_revenue, revenue_trend, total_users, users_trend,
 *                           successful_orders, orders_trend, complaint_tickets, tickets_trend }
 *   - recentTransactions: Array<{ user, product, total, payment, status }>
 *   - chartLabels:        string[]
 *   - chartData:          number[]
 *   - categoryLabels:     string[]
 *   - categoryData:       number[]
 *   - recentUsers:        Array<{ name, email, points, date, status }>
 *   - periode:            'bulan-ini' | 'bulan-lalu' | 'tahun-ini'
 */
export default function Dashboard({
    admin,
    stats,
    recentTransactions,
    chartLabels,
    chartData,
    categoryLabels,
    categoryData,
    recentUsers,
    periode,
}) {
    const { auth } = usePage().props;
    const [isLoading, setIsLoading] = useState(false);
    const [showToast, setShowToast] = useState(false);
    const [toastMessage, setToastMessage] = useState('');

    const revenueChartRef = useRef(null);
    const categoryChartRef = useRef(null);
    const revenueChartInst = useRef(null);
    const categoryChartInst = useRef(null);

    /* ── Period Selector Change ─────────────────────────────────────── */
    const handlePeriodeChange = (newPeriode) => {
        if (isLoading) return;
        setIsLoading(true);
        setToastMessage(`Memuat data untuk periode: ${getPeriodeLabel(newPeriode)}`);
        setShowToast(true);

        router.get(
            route('admin.dashboard'),
            { periode: newPeriode },
            {
                preserveState: false,
                onFinish: () => {
                    setTimeout(() => {
                        setIsLoading(false);
                        setShowToast(false);
                    }, 500);
                },
            }
        );
    };

    const getPeriodeLabel = (val) => {
        if (val === 'bulan-lalu') return 'Bulan Lalu';
        if (val === 'tahun-ini') return 'Tahun Ini';
        return 'Bulan Ini';
    };

    /* ── Chart.js Lifecycle ─────────────────────────────────────────── */
    useEffect(() => {
        if (revenueChartRef.current) {
            if (revenueChartInst.current) {
                revenueChartInst.current.destroy();
            }

            const ctx = revenueChartRef.current.getContext('2d');
            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(0, 229, 255, 0.4)');
            gradient.addColorStop(1, 'rgba(0, 229, 255, 0.0)');

            revenueChartInst.current = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [
                        {
                            label: periode === 'tahun-ini' ? 'Pendapatan (Rp)' : 'Pendapatan Harian (Rp)',
                            data: chartData,
                            borderColor: '#0A2540',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#00E5FF',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    return (
                                        'Rp ' +
                                        context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
                                    );
                                },
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f8fafc', drawBorder: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { weight: '600', size: 10 },
                                callback: function (value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000).toFixed(0) + ' k';
                                    }
                                    return 'Rp ' + value;
                                },
                            },
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { weight: '600', size: 10 },
                            },
                        },
                    },
                },
            });
        }

        if (categoryChartRef.current) {
            if (categoryChartInst.current) {
                categoryChartInst.current.destroy();
            }

            const catCtx = categoryChartRef.current.getContext('2d');
            categoryChartInst.current = new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [
                        {
                            data: categoryData,
                            backgroundColor: ['#0A2540', '#00E5FF', '#4F46E5', '#10B981'],
                            borderWidth: 3,
                            borderColor: '#fff',
                            hoverOffset: 6,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                            displayColors: true,
                            callbacks: {
                                label: function (context) {
                                    return ' ' + context.label + ': ' + context.parsed + ' pesanan';
                                },
                            },
                        },
                    },
                    cutout: '72%',
                },
            });
        }

        return () => {
            if (revenueChartInst.current) revenueChartInst.current.destroy();
            if (categoryChartInst.current) categoryChartInst.current.destroy();
        };
    }, [chartData, chartLabels, categoryData, categoryLabels, periode]);

    /* ── Color Map & Badges ─────────────────────────────────────────── */
    const colorMap = {
        blue: { bg: 'bg-blue-50', text: 'text-blue-600' },
        indigo: { bg: 'bg-indigo-50', text: 'text-indigo-600' },
        emerald: { bg: 'bg-emerald-50', text: 'text-emerald-600' },
        orange: { bg: 'bg-orange-50', text: 'text-orange-600' },
    };

    const statusBadge = (status) => {
        const map = {
            Sukses: 'bg-green-50 text-green-700 border border-green-100',
            Menunggu: 'bg-yellow-50 text-yellow-700 border border-yellow-100',
            Gagal: 'bg-red-50 text-red-700 border border-red-100',
        };
        return map[status] ?? 'bg-gray-50 text-gray-700';
    };

    const statCards = [
        {
            label: periode === 'tahun-ini' ? 'Pendapatan Tahun Ini' : periode === 'bulan-lalu' ? 'Pendapatan Bulan Lalu' : 'Pendapatan Bulan Ini',
            value: stats.monthly_revenue,
            trend: stats.revenue_trend,
            color: 'emerald',
            isPositive: !stats.revenue_trend?.startsWith('-'),
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                />
            ),
        },
        {
            label: 'Total Pengguna',
            value: stats.total_users,
            trend: stats.users_trend,
            color: 'blue',
            isPositive: true,
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                />
            ),
        },
        {
            label: 'Pesanan Sukses',
            value: stats.successful_orders,
            trend: stats.orders_trend,
            color: 'indigo',
            isPositive: !stats.orders_trend?.startsWith('-'),
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                />
            ),
        },
        {
            label: 'Tiket Komplain',
            value: stats.complaint_tickets,
            trend: stats.tickets_trend,
            color: 'orange',
            isPositive: stats.tickets_trend?.startsWith('-'),
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
            ),
        },
    ];

    return (
        <DashboardLayout title="Dashboard Overview">
            <Head title="Dashboard Admin " />

            {/* Toast Notification */}
            {showToast && (
                <div className="fixed bottom-4 right-4 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in">
                    <svg className="w-5 h-5 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span className="text-sm font-medium">{toastMessage}</span>
                </div>
            )}

            <div className="space-y-6">
                
                {/* Header Section */}
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-[#0A2540]">Dashboard Overview</h1>
                    <div className="flex items-center gap-2">
                        <span className="text-sm text-gray-500">Periode:</span>
                        <select
                            value={periode}
                            onChange={(e) => handlePeriodeChange(e.target.value)}
                            className="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-[#00E5FF] focus:border-[#00E5FF] block px-3 py-2 pr-10 font-medium cursor-pointer shadow-sm hover:border-gray-300 transition-colors"
                        >
                            <option value="bulan-ini">Bulan Ini</option>
                            <option value="bulan-lalu">Bulan Lalu</option>
                            <option value="tahun-ini">Tahun Ini</option>
                        </select>
                    </div>
                </div>

                {/* 4 Stat Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {statCards.map((card) => {
                        const c = colorMap[card.color];
                        return (
                            <div
                                key={card.label}
                                className="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden transition-all duration-300 hover:shadow-md group"
                            >
                                {isLoading && (
                                    <div className="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10">
                                        <div className="w-6 h-6 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin" />
                                    </div>
                                )}
                                <div className="flex items-start justify-between">
                                    <div>
                                        <p className="text-gray-500 text-sm font-medium mb-1">{card.label}</p>
                                        <h3 className="text-2xl font-bold text-gray-900 transition-all duration-300">
                                            {card.value}
                                        </h3>
                                    </div>
                                    <div className={`w-12 h-12 rounded-lg ${c.bg} ${c.text} flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300`}>
                                        <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {card.icon}
                                        </svg>
                                    </div>
                                </div>
                                <div className="mt-4 flex items-center text-sm">
                                    <span className={`font-semibold flex items-center gap-1 transition-colors duration-300 ${card.isPositive ? 'text-emerald-500' : 'text-red-500'}`}>
                                        <svg
                                            className={`w-4 h-4 ${!card.isPositive ? 'transform rotate-180' : ''}`}
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                        <span>{card.trend}</span>
                                    </span>
                                    <span className="text-gray-400 ml-2">
                                        {periode === 'tahun-ini' ? 'vs tahun lalu' : 'vs bulan lalu'}
                                    </span>
                                </div>
                            </div>
                        );
                    })}
                </div>

                {/* Charts Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Statistik Pendapatan (Line Chart) */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-md">
                        {isLoading && (
                            <div className="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10">
                                <div className="w-8 h-8 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin" />
                            </div>
                        )}
                        <div className="flex items-center justify-between mb-4">
                            <h2 className="text-lg font-bold text-[#0A2540]">Statistik Pendapatan</h2>
                            <span className="text-xs font-semibold text-gray-400 bg-gray-50 px-2.5 py-1 rounded-lg transition-all duration-300">
                                {periode === 'tahun-ini' ? 'Tahun Ini (Bulanan)' : periode === 'bulan-lalu' ? 'Bulan Lalu (Harian)' : 'Bulan Ini (Harian)'}
                            </span>
                        </div>
                        <div className="relative h-72 w-full">
                            <canvas ref={revenueChartRef} />
                        </div>
                    </div>

                    {/* Kategori Produk Terlaris (Doughnut Chart) */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-md">
                        {isLoading && (
                            <div className="absolute inset-0 bg-white/40 backdrop-blur-[1px] flex items-center justify-center z-10">
                                <div className="w-8 h-8 border-2 border-[#00E5FF] border-t-transparent rounded-full animate-spin" />
                            </div>
                        )}
                        <div className="flex items-center justify-between mb-4 border-b border-gray-55 pb-3">
                            <h2 className="text-lg font-bold text-[#0A2540]">Kategori Terlaris</h2>
                            <span className="text-xs font-semibold text-[#00b8cc] bg-[#00E5FF]/10 px-2.5 py-1 rounded-lg">
                                Volume
                            </span>
                        </div>
                        <div className="relative h-44 w-full flex items-center justify-center my-2">
                            <canvas ref={categoryChartRef} />
                        </div>
                        {/* Legends */}
                        <div className="flex flex-wrap justify-center gap-3 text-xs font-bold text-gray-500 mt-2">
                            {categoryLabels.map((label, index) => {
                                const hasData = categoryData[index] > 0;
                                if (!hasData) return null;
                                return (
                                    <div
                                        key={index}
                                        className="flex items-center gap-1.5 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100/50"
                                    >
                                        <span
                                            className="w-2.5 h-2.5 rounded-full"
                                            style={{
                                                backgroundColor: ['#0A2540', '#00E5FF', '#4F46E5', '#10B981'][index % 4],
                                            }}
                                        />
                                        <span>{label}</span>
                                    </div>
                                );
                            })}
                            {categoryData.reduce((a, b) => a + b, 0) === 0 && (
                                <div className="text-gray-400 text-xs py-1">Tidak ada penjualan di periode ini</div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Tables & Lists Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Left Column: Transaksi Masuk Terbaru (2/3 width) */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden lg:col-span-2 flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                        <div>
                            <div className="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <h2 className="text-lg font-bold text-[#0A2540]">Transaksi Masuk Terbaru</h2>
                                <Link
                                    href={route('admin.transaksi')}
                                    className="px-4 py-2 bg-[#00E5FF]/10 text-[#00b8cc] hover:bg-[#00E5FF]/20 font-semibold rounded-lg text-sm transition-colors"
                                >
                                    Lihat Semua
                                </Link>
                            </div>
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm text-left text-gray-500">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" className="px-5 py-3">Nama User</th>
                                            <th scope="col" className="px-5 py-3">Produk</th>
                                            <th scope="col" className="px-5 py-3">Total</th>
                                            <th scope="col" className="px-5 py-3">Metode</th>
                                            <th scope="col" className="px-5 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {recentTransactions.length === 0 ? (
                                            <tr>
                                                <td colSpan={5} className="px-5 py-8 text-center text-gray-400">
                                                    Belum ada transaksi.
                                                </td>
                                            </tr>
                                        ) : (
                                            recentTransactions.map((trx, idx) => (
                                                <tr key={idx} className="border-b hover:bg-gray-50 transition-colors">
                                                    <td className="px-5 py-3 font-semibold text-gray-900 flex items-center gap-3">
                                                        <div className="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                                                            <img
                                                                src={`https://ui-avatars.com/api/?name=${encodeURIComponent(
                                                                    trx.user
                                                                )}&background=fff&color=0A2540`}
                                                                alt={trx.user}
                                                                className="w-full h-full object-cover"
                                                            />
                                                        </div>
                                                        {trx.user}
                                                    </td>
                                                    <td className="px-5 py-3 text-gray-600">{trx.product}</td>
                                                    <td className="px-5 py-3 font-bold text-gray-900">{trx.total}</td>
                                                    <td className="px-5 py-3">
                                                        <span className="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md text-xs font-semibold">
                                                            {trx.payment}
                                                        </span>
                                                    </td>
                                                    <td className="px-5 py-3">
                                                        <span className={`rounded-md px-2 py-1 text-xs font-semibold ${statusBadge(trx.status)}`}>
                                                            {trx.status}
                                                        </span>
                                                    </td>
                                                </tr>
                                            ))
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {/* Right Column: Pengguna Baru Terdaftar (1/3 width) */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                        <div>
                            <div className="border-b border-gray-50 pb-4 mb-4 flex items-center justify-between">
                                <h2 className="text-lg font-bold text-[#0A2540]">Pengguna Baru</h2>
                                <Link
                                    href={route('admin.pengguna')}
                                    className="text-xs font-bold text-[#00b8cc] hover:underline bg-[#00E5FF]/10 px-2 py-1 rounded-md"
                                >
                                    Lihat Semua
                                </Link>
                            </div>
                            <div className="space-y-4">
                                {recentUsers.length === 0 ? (
                                    <p className="text-xs text-gray-500 text-center py-6">Belum ada pengguna baru.</p>
                                ) : (
                                    recentUsers.map((usr, idx) => (
                                        <div
                                            key={idx}
                                            className="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50/70 transition-colors border border-transparent hover:border-gray-100"
                                        >
                                            <div className="flex items-center gap-3">
                                                <div className="w-9 h-9 rounded-full bg-gray-100 text-[#0a2540] flex items-center justify-center font-bold border border-gray-200 overflow-hidden">
                                                    <img
                                                        src={`https://ui-avatars.com/api/?name=${encodeURIComponent(
                                                            usr.name
                                                        )}&background=0A2540&color=fff`}
                                                        alt={usr.name}
                                                        className="w-full h-full object-cover"
                                                    />
                                                </div>
                                                <div>
                                                    <h4 className="text-sm font-bold text-gray-900 leading-tight">
                                                        {usr.name}
                                                    </h4>
                                                    <p className="text-xs text-gray-400 font-mono mt-0.5 leading-none">
                                                        {usr.email.length > 20 ? `${usr.email.substring(0, 18)}...` : usr.email}
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="text-right">
                                                <p className="text-[10px] text-gray-400 font-semibold">{usr.date}</p>
                                                <span className="inline-flex text-[9px] font-bold text-[#00b8cc] bg-[#00E5FF]/10 px-2 py-0.5 rounded-md mt-1">
                                                    {usr.points.toLocaleString('id-ID')} Pts
                                                </span>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
