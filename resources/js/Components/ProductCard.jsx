/**
 * ProductCard.jsx — Komponen pricing card yang mereplikasi x-product-card Blade
 *
 * Props:
 *   - isFeatured:  boolean — card tengah (Spotify) yang di-highlight
 *   - bgStyle:     string — inline style untuk background gradient
 *   - bgClasses:   string — tailwind bg classes
 *   - iconSrc:     string — path gambar logo produk
 *   - title:       string — nama produk (e.g. "Canva Pro")
 *   - subtitle:    string — kategori (e.g. "Design & Kreativitas")
 *   - badgeText:   string — label badge (e.g. "PRO", "PREMIUM")
 *   - badgeClasses: string — tailwind classes badge
 *   - features:    string[] — list fitur
 *   - featureIconBg:    string — bg class icon checklist
 *   - featureIconColor: string — color class icon checklist
 *   - priceOriginal:    string — harga asli (e.g. "Rp 120.000")
 *   - priceDiscounted:  string — harga AksesPro (e.g. "Rp 19.000")
 *   - priceDiscountedClasses: string — class tambahan untuk harga diskon
 *   - discountPercent:  string — persentase hemat
 *   - discountClasses:  string — classes badge diskon
 *   - buyUrl:      string — URL tombol beli
 *   - buyBtnClasses: string — classes tombol beli
 *   - bgGlow:      React node — optional glow overlay element
 *   - delay:       string — reveal delay class
 */
export default function ProductCard({
    isFeatured = false,
    bgStyle = 'background: linear-gradient(135deg, #0d2e59 0%, #0A2540 100%);',
    bgClasses = '',
    iconSrc = '',
    title = '',
    subtitle = '',
    badgeText = '',
    badgeClasses = '',
    features = [],
    featureIconBg = '',
    featureIconColor = '',
    priceOriginal = '',
    priceDiscounted = '',
    priceDiscountedClasses = 'text-white',
    discountPercent = '',
    discountClasses = '',
    buyUrl = '#',
    buyBtnClasses = 'btn-primary',
    bgGlow = null,
    delay = '1',
}) {
    return (
        <div
            className={`pricing-card ${isFeatured ? 'featured' : ''} reveal reveal-delay-${delay} ${bgClasses} rounded-3xl p-8 border border-white/10 relative overflow-hidden`}
            style={{ ...parseStyle(bgStyle) }}
        >
            {isFeatured ? (
                <>
                    {/* Bg glow for featured */}
                    <div
                        className="absolute inset-0 pointer-events-none"
                        style={{ background: 'radial-gradient(ellipse at top right, rgba(0, 229, 255, 0.12) 0%, transparent 60%)' }}
                    />
                    {/* Popular badge */}
                    <div className="absolute -top-0.5 left-1/2 -translate-x-1/2">
                        <div className="badge-popular flex items-center gap-1.5 shadow-lg">
                            ⭐ Paling Populer
                        </div>
                    </div>
                </>
            ) : (
                bgGlow
            )}

            {/* App header */}
            <div className={`flex items-center justify-between mb-8 ${isFeatured ? 'mt-4' : ''}`}>
                <div className="flex items-center gap-4">
                    <div className="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg overflow-hidden">
                        <img src={iconSrc} alt={title} className="w-full h-full object-cover rounded-2xl" />
                    </div>
                    <div>
                        <h3 className="font-bold text-white text-lg">{title}</h3>
                        <p className="text-white/40 text-xs">{subtitle}</p>
                    </div>
                </div>
                <div className={`text-[10px] ${badgeClasses} rounded-full px-2.5 py-1 font-semibold`}>
                    {badgeText}
                </div>
            </div>

            {/* Features */}
            <ul className="space-y-3 mb-8">
                {features.map((feature, idx) => (
                    <li key={idx} className="flex items-center gap-3 text-sm text-white/70">
                        <div className={`w-5 h-5 rounded-full ${featureIconBg} flex items-center justify-center flex-shrink-0`}>
                            <svg className={`w-3 h-3 ${featureIconColor}`} fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        {feature}
                    </li>
                ))}
            </ul>

            {/* Pricing */}
            <div className="border-t border-white/10 pt-6">
                <div className="flex items-end justify-between mb-4">
                    <div>
                        <div className="text-white/30 text-xs line-through mb-1">{priceOriginal} (resmi)</div>
                        <div className={`font-bold text-3xl ${priceDiscountedClasses}`}>
                            {priceDiscounted}<span className="text-white/40 text-sm font-normal">/bulan</span>
                        </div>
                    </div>
                    <div className={`text-xs ${discountClasses} rounded-xl px-3 py-2 font-semibold text-center`}>
                        Hemat<br />{discountPercent}
                    </div>
                </div>
                <a
                    href={buyUrl}
                    className={`w-full ${buyBtnClasses} py-3.5 rounded-xl text-sm font-bold text-center block transition-all duration-300`}
                >
                    Beli Sekarang →
                </a>
            </div>
        </div>
    );
}

/**
 * Helper: parse CSS inline style string into React style object
 * e.g. "background: red; color: blue;" → { background: 'red', color: 'blue' }
 */
function parseStyle(styleStr) {
    if (!styleStr) return {};
    const style = {};
    styleStr.split(';').forEach((s) => {
        const [key, ...valueParts] = s.split(':');
        if (key && valueParts.length) {
            const camelKey = key.trim().replace(/-([a-z])/g, (_, c) => c.toUpperCase());
            style[camelKey] = valueParts.join(':').trim();
        }
    });
    return style;
}
