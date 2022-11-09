/** @type {import('tailwindcss').Config} */
const headings = {};
['h1', 'h2', 'h3', 'h4', 'h5']
    .forEach((heading) => {
        headings[heading] = {
            paddingBottom: '0.25em',
            borderBottom: '1px solid #eee',
        };
    });

module.exports = {
    content: [
        "./resources/**/*.blade.php",
    ],
    theme: {
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        ...headings,
                    },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
