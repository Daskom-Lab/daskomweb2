import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ['"poppins"'],
            },
            colors: {
                darkGreen: "#163020",
                forestGreen: "#304d30",
                sageGreen: "#b6c4b6",
                ivory: "#eef0e5",
                softIvory: "#F4F6EE",
            },
        },
    },

    plugins: [forms],
};
