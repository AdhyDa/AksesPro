import React, { useState, useEffect, useRef } from 'react';
import { Head, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import Chart from 'chart.js/auto';

/**
 * Admin/Laporan.jsx
 *
 * Props:
 *   - admin:              { name }
 *   - grossRevenue:       number
 *   - netProfit:          number
 *   - failedTransactions: number
 *   - categoryLabels:     string[]
 *   - categoryValues:     number[]
 *   - paymentLabels:      string[]
 *   - paymentValues:      number[]
 *   - periode:            'bulan-ini' | 'bulan-lalu' | 'tahun-ini'
 */
export default function Laporan({
    admin,
    grossRevenue,
    netProfit,
    failedTransactions,
    categoryLabels,
    categoryValues,
    paymentLabels,
    paymentValues,
    periode,
}) {
    const [currentPeriode, setCurrentPeriode] = useState(periode || 'bulan-ini');
    
    const categoryChartRef = useRef(null);
    const paymentChartRef = useRef(null);
    const categoryChartInst = useRef(null);
    const paymentChartInst = useRef(null);

    const handlePeriodeChange = (newPeriode) => {
        setCurrentPeriode(newPeriode);
        router.get(
            '/admin/laporan',
            { periode: newPeriode },
            { preserveState: false }
        );
    };

    /* ── Chart.js Lifecycle ── */
    useEffect(() => {
        if (categoryChartRef.current) {
            if (categoryChartInst.current) {
                categoryChartInst.current.destroy();
            }

            const ctxCategory = categoryChartRef.current.getContext('2d');
            categoryChartInst.current = new Chart(ctxCategory, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [
                        {
                            label: 'Penjualan (Rupiah)',
                            data: categoryValues,
                            backgroundColor: '#00E5FF',
                            borderRadius: 6,
                            barPercentage: 0.6,
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
                            grid: {
                                color: '#f3f4f6',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9ca3af',
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
                            ticks: { color: '#6b7280', font: { weight: '600' } },
                        },
                    },
                },
            });
        }

        if (paymentChartRef.current) {
            if (paymentChartInst.current) {
                paymentChartInst.current.destroy();
            }

            const ctxPayment = paymentChartRef.current.getContext('2d');
            paymentChartInst.current = new Chart(ctxPayment, {
                type: 'doughnut',
                data: {
                    labels: paymentLabels,
                    datasets: [
                        {
                            data: paymentValues,
                            backgroundColor: [
                                '#00E5FF', // Electric Cyan
                                '#0A2540', // Tech Navy Blue
                                '#60a5fa', // Light Blue
                                '#e5e7eb', // Gray
                            ],
                            borderWidth: 0,
                            hoverOffset: 4,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: '#4b5563',
                                font: { weight: '600', size: 12 },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            },
                        },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            padding: 12,
                            callbacks: {
                                label: function (context) {
                                    return ' ' + context.label + ': ' + context.parsed + ' transaksi';
                                },
                            },
                        },
                    },
                    cutout: '70%',
                },
            });
        }

        return () => {
            if (categoryChartInst.current) categoryChartInst.current.destroy();
            if (paymentChartInst.current) paymentChartInst.current.destroy();
        };
    }, [categoryLabels, categoryValues, paymentLabels, paymentValues, periode]);

    const formatRupiah = (val) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(val);
    };

    return (
        <DashboardLayout admin={admin} title="Laporan Pendapatan">
            <Head title="Laporan Pendapatan" />

            <div className="space-y-6">
                {/* Header Section */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Laporan Pendapatan</h1>
                        <p className="text-sm text-gray-500 mt-1">Analisis performa penjualan dan tren pendapatan.</p>
                    </div>

                    <div className="flex gap-2">
                        <select
                            value={currentPeriode}
                            onChange={(e) => handlePeriodeChange(e.target.value)}
                            className="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block px-3 py-2 pr-10"
                        >
                            <option value="bulan-ini">Bulan Ini</option>
                            <option value="bulan-lalu">Bulan Lalu</option>
                            <option value="tahun-ini">Tahun Ini</option>
                        </select>

                        <a
                            href={`/admin/laporan/pdf?periode=${currentPeriode}`}
                            className="px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2 text-sm"
                        >
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak PDF
                        </a>
                    </div>
                </div>

                {/* 3 Metrik Cards */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {/* Gross Revenue */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                        <div className="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                        <p className="text-sm font-semibold text-gray-500 mb-1 relative z-10">Gross Revenue</p>
                        <h3 className="text-3xl font-black text-[#0A2540] relative z-10">{formatRupiah(grossRevenue)}</h3>
                        <div className="mt-4 flex items-center text-sm relative z-10">
                            <span className="text-green-500 font-bold flex items-center gap-1">
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                Aktif
                            </span>
                            <span className="text-gray-400 ml-2">periode terpilih</span>
                        </div>
                    </div>

                    {/* Net Profit */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                        <div className="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                        <p className="text-sm font-semibold text-gray-500 mb-1 relative z-10">Keuntungan Bersih (AksesPro)</p>
                        <h3 className="text-3xl font-black text-[#00b8cc] relative z-10">{formatRupiah(netProfit)}</h3>
                        <div className="mt-4 flex items-center text-sm relative z-10">
                            <span className="text-green-500 font-bold flex items-center gap-1">
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                Aktif
                            </span>
                            <span className="text-gray-400 ml-2">selisih harga jual & modal</span>
                        </div>
                    </div>

                    {/* Refund / Gagal */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                        <div className="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                        <p className="text-sm font-semibold text-gray-500 mb-1 relative z-10">Transaksi Gagal</p>
                        <h3 className="text-3xl font-black text-gray-900 relative z-10">{failedTransactions} Transaksi</h3>
                        <div className="mt-4 flex items-center text-sm relative z-10">
                            <span className="text-red-500 font-bold flex items-center gap-1">
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                                Gagal
                            </span>
                            <span className="text-gray-400 ml-2">perlu diperhatikan</span>
                        </div>
                    </div>
                </div>

                {/* Charts Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Bar Chart: Penjualan per Kategori */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 className="text-lg font-bold text-gray-900 mb-4">Penjualan per Kategori</h2>
                        <div className="relative h-64 w-full">
                            <canvas ref={categoryChartRef}></canvas>
                        </div>
                    </div>

                    {/* Doughnut Chart: Metode Pembayaran */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 className="text-lg font-bold text-gray-900 mb-4">Metode Pembayaran Terpopuler</h2>
                        <div className="relative h-64 w-full flex justify-center">
                            <canvas ref={paymentChartRef}></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
