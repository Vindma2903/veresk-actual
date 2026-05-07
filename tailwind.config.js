const defaultTheme = require('tailwindcss/defaultTheme')

// 'sm': '640px',
// 'md': '768px',
// 'lg': '1024px',
// 'xl': '1280px',
// '2xl': '1536px',

const customScreens = defaultTheme.screens;
delete customScreens['2xl'];

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.svelte",
    ],
    safelist: [
        'columns-2',
    ],
    theme: {
        screens: customScreens,
        container: {
            center: true,
            padding: '1rem',
            screens: customScreens
        },
        extend: {
            colors: {
                black: '#111111',
                green: '#4A7A25',
            },
            fontFamily: {
                'sans': ['Articulat CF', ...defaultTheme.fontFamily.sans],
                'helvetica': ['Helvetica', ...defaultTheme.fontFamily.mono]
            },
            // typography: (theme) => ({
            //     DEFAULT: {
            //         css: {
            //             // '--tw-prose-body': theme('colors.white'),
            //             // '--tw-prose-headings': theme('colors.white'),
            //             // '--tw-prose-bold': theme('colors.white'),
            //             // '--tw-prose-links': theme('colors.white'),
            //         },
            //     },
            // }),
        },
    },
    plugins: [
        // require('@tailwindcss/typography'),
    ],
}
