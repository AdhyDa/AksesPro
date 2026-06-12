/**
 * StatCard.jsx — Komponen statistik reusable untuk dashboard
 *
 * Props:
 *   - label:      string — nama metrik (e.g. "Pendapatan Bulan Ini")
 *   - value:      string|number — nilai utama
 *   - trend:      string — perubahan (e.g. "+12%" atau "-5%")
 *   - isPositive: boolean — apakah trend positif (hijau) atau negatif (merah)
 *   - icon:       React node — SVG path element
 *   - color:      'blue' | 'indigo' | 'emerald' | 'orange' | 'purple' | 'cyan'
 */
export default function StatCard({
    label = '',
    value = '',
    trend = '',
    isPositive = true,
    icon = null,
    color = 'blue',
}) {
    const colorMap = {
        blue:    { bg: 'bg-blue-50',    text: 'text-blue-600' },
        indigo:  { bg: 'bg-indigo-50',  text: 'text-indigo-600' },
        emerald: { bg: 'bg-emerald-50', text: 'text-emerald-600' },
        orange:  { bg: 'bg-orange-50',  text: 'text-orange-600' },
        purple:  { bg: 'bg-purple-50',  text: 'text-purple-600' },
        cyan:    { bg: 'bg-cyan-50',    text: 'text-cyan-600' },
    };

    const c = colorMap[color] || colorMap.blue;

    return (
        <div className="flex items-start gap-4 rounded-xl border border-gray-100 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
            <div className={`flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg ${c.bg} ${c.text}`}>
                {icon ? (
                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {icon}
                    </svg>
                ) : (
                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                )}
            </div>
            <div>
                <p className="text-sm font-medium text-gray-500">{label}</p>
                <h3 className="text-2xl font-bold text-gray-900">{value}</h3>
                {trend && (
                    <p className={`mt-1 text-xs font-medium ${isPositive ? 'text-green-500' : 'text-red-500'}`}>
                        {trend} vs. periode lalu
                    </p>
                )}
            </div>
        </div>
    );
}
