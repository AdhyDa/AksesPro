import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.jsx',
        './resources/js/**/*.tsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    DEFAULT: '#0A2540',
                    50: '#f4f7fa',
                    100: '#e9eff5',
                    200: '#c8d7e6',
                    300: '#9cb5cf',
                    400: '#6a8db3',
                    500: '#476d97',
                    600: '#355479',
                    700: '#273f5c',
                    800: '#1b2a3f',
                    900: '#06192b',
                },
                'cyan-accent': '#00E5FF',
                'cyan-glow': 'rgba(0, 229, 255, 0.07)',
            },
            animation: {
                float: 'float 8s ease-in-out infinite',
                marquee: 'marquee 28s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                marquee: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
        },
    },

    plugins: [forms],
};

