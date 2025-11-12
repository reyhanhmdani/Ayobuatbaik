import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue"],
    theme: {
        extend: {
            colors: {
                primary: "#242124",
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
