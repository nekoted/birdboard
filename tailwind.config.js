const { colors } = require("tailwindcss/defaultTheme");
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    darkMode: "class",
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php"
    ],

    theme: {
        container: {
            padding: {
                default: "1rem"
            }
        },
        backgroundColor: theme => ({
            ...theme("colors"),
            page: "var(--page-background-color)",
            card: "var(--card-background-color)",
            button: "var(--button-background-color)",
            header: "var(--header-background-color)"
        }),
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans]
            },
            colors: {
                default: "var(--text-default-color)",
                accent: "var(--text-default-color)",
                button: {
                    DEFAULT: "var(--button-text-color)"
                },
                muted: {
                    DEFAULT: "var(--text-muted-color)",
                    light: "var(--text-muted-light-color)"
                },
                accent: {
                    DEFAULT: "var(--text-accent-color)",
                    light: "var(--text-accent-light-color)"
                }
            },
            textColor: {
                button: "var(--button-text-color)"
            },
            borderRadius: ["hover"]
        }
    },

    variants: {
        extend: {
            opacity: ["disabled"]
        }
    },

    plugins: [require("@tailwindcss/forms")]
};
