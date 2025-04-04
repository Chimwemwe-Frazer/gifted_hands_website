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
                mustBlue: "#10274A",
                mustRed: "#E62E2D",
                mustGreen: "#55B166",
            },
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
            },
        },
    },

    plugins: [forms],
};
