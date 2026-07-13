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
            colors: {
                mustBlue: "#005A92",
                mustRed: "#E62E2D",
                mustOrange: "#F1842F",
                mustGreen: "#F1842F",
                mustOrangeDark: "#D86F22",
            },
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
            },
        },
    },

    plugins: [forms],
};
