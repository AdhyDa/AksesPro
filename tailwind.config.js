import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    DEFAULT: '#0A2540',
                    800: '#0d2e59',
                    700: '#1a3a6e',
                    600: '#1e4080',
                    50: '#f0f4ff',
                },
                cyan: {
                    accent: '#00E5FF',
                    light: '#4DF0FF',
                    glow: 'rgba(0,229,255,0.15)',
                },
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'float-delayed': 'float 6s ease-in-out 2s infinite',
                'pulse-slow': 'pulse 4s ease-in-out infinite',
                'slide-up': 'slideUp 0.6s ease-out forwards',
                'fade-in': 'fadeIn 0.8s ease-out forwards',
                'marquee': 'marquee 20s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-16px)' },
                },
                slideUp: {
                    'from': { opacity: '0', transform: 'translateY(30px)' },
                    'to': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    'from': { opacity: '0' },
                    'to': { opacity: '1' },
                },
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(135deg, #0A2540 0%, #0d2e59 50%, #1a3a6e 100%)',
                'card-gradient': 'linear-gradient(135deg, #0d2e59 0%, #0A2540 100%)',
                'cyan-glow': 'radial-gradient(ellipse at center, rgba(0,229,255,0.2) 0%, transparent 70%)',
            },
        },
    },

    plugins: [forms],
};
