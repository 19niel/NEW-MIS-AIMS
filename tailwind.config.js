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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    500: '#3b82f6',
                    600: '#2563eb', // True blue
                    700: '#1d4ed8',
                    800: '#1e40af', // Deep blue
                    900: '#1e3a8a',
                },
                accent: {
                    50: '#fff1f2',
                    100: '#ffe4e6',
                    500: '#f43f5e',
                    600: '#e11d48', // Vibrant crimson red
                    700: '#be123c',
                    800: '#9f1239',
                    900: '#881337',
                },
                white: '#ffffff',
            }
        },
    },

    plugins: [forms],
};
