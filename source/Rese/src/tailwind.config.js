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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'rb-md': '4px 4px 4px 0 rgba(0, 0, 0, 0.4)',
            },
            borderWidth: {
                '1': '1px',
            },
            screens: {
                'cm': '375px',
            },
        },
    },

    plugins: [forms],
};
