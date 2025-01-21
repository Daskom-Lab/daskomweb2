const flowbite = require("flowbite-react/tailwind");
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
        flowbite.content(),
    ],

    theme: {
        extend: {
            fontFamily: {
                poppins: ['"poppins"'],
            },
            colors: {
                darkGreen: "#163020",
                darkOliveGreen: "#243622",
                forestGreen: "#304d30",
                deepForestGreen: "#304D30",
                sageGreen: "#b6c4b6",
                ivory: "#eef0e5",
                softIvory: "#F4F6EE",
                gainsboro: "#d9d9d9",
                lightGainsboro: "#EBEBEB",
                rustyRed: "#A44C4C",
                dustyBlue: "#868B95",
                darkBrown: "#393D46",
                softGray: "#F7F7F7",
                softRed: "#7F3E3B",
                darkRed: "#542725",
                lightGray: "#868B95",
                redredDark: "#A02724",
                fireRed: "#C81A01",
                deepForestGreenDark: "#1C2E1C",
                lightGray: "#CDCDCD",
                dustyBlue: "#868A95",
                softPearl: "#F2F3ED",
                sageIvory: "#DADCD0",
                goldenAmber: "#D4AF37",
                darkGray: "#3F4145"
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'), // Plugin forms
        flowbite,                      // Plugin flowbite
    ],
};
