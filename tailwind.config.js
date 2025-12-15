import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue"],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#242124",
                    from: "#242124",
                    via: "#1f2937", // gray-800
                    to: "#111827", // gray-900
                },
                secondary: "#daaf65",
                // secondary: "#E5B121",
                hijau: "#16a34a",
                goldLight: "#F7EF8A",
                goldDark: "#B8860B",
                grayLight: "#F5F5F5",
                grayDark: "#333333",
            },
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
            },
        },
    },
    plugins: [require("@tailwindcss/typography")],
};
