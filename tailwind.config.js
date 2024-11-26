import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Satoshi', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: {
                    default: '#1A1A1A',           // Deep charcoal base
                    background: '#252525',         // Soft dark background
                    text: '#FFA07A',               // Soft light salmon
                    muted: '#FF8C69',              // Soft coral
                    border: '#FF7F50',             // Coral for borders
                    accent: '#FF6347',             // Tomato for accents
                    secondary: '#2E2E2E',          // Slightly lighter dark gray
                    hover: '#FF5722',              // Deep orange for hover states
                },
            },
            backgroundColor: {
                dark: {
                    default: '#1A1A1A',
                    background: '#252525',
                    secondary: '#2E2E2E',
                    accent: '#FF6347',
                    hover: '#FF5722',
                },
            },
            textColor: {
                dark: {
                    default: '#FFA07A',            // Soft light salmon
                    muted: '#FF8C69',              // Soft coral
                    accent: '#FF6347',             // Tomato for accents
                    hover: '#FFAA79',              // Slightly lighter salmon
                },
            },
            borderColor: {
                dark: {
                    default: '#FF7F50',            // Coral for primary borders
                    light: '#FF8C69',              // Soft coral for lighter borders
                    accent: '#FF6347',             // Tomato for accent borders
                },
            }
        },
    },
    plugins: [forms],
};