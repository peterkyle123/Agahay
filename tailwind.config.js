import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'staatliches': ['Staatliches', 'sans-serif'],
                'agbalumo': ['Agbalumo', 'sans-serif'],
                'dancing-script': ['Dancing Script', 'cursive', 'sans-serif'],
                'anton': ['Anton', 'sans-serif'],
                'allan': ['Allan', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
