const colors = require('tailwindcss/colors');

// Arizona Cardinals theme — cardinal red + dark charcoal grays
const gray = {
    50: 'hsl(0, 5%, 97%)',
    100: 'hsl(0, 5%, 91%)',
    200: 'hsl(0, 5%, 82%)',
    300: 'hsl(0, 5%, 65%)',
    400: 'hsl(0, 5%, 53%)',
    500: 'hsl(0, 5%, 43%)',
    600: 'hsl(0, 6%, 30%)',
    700: 'hsl(0, 6%, 22%)',
    800: 'hsl(0, 7%, 16%)',
    900: 'hsl(0, 8%, 10%)',
};

// Cardinals red palette
const cardinal = {
    50:  '#fdf2f3',
    100: '#fce4e6',
    200: '#f8bfc3',
    300: '#f28b92',
    400: '#e9505b',
    500: '#d42535',
    600: '#b81c2b',
    700: '#97233f', // official Cardinals red
    800: '#7a1b30',
    900: '#5e1424',
};

module.exports = {
    content: [
        './resources/scripts/**/*.{js,ts,tsx}',
    ],
    theme: {
        extend: {
            fontFamily: {
                header: ['"IBM Plex Sans"', '"Roboto"', 'system-ui', 'sans-serif'],
            },
            colors: {
                black: '#0d0d0d',
                primary: cardinal,
                gray: gray,
                neutral: gray,
                cyan: cardinal,
                cardinal: cardinal,
            },
            fontSize: {
                '2xs': '0.625rem',
            },
            transitionDuration: {
                250: '250ms',
            },
            borderColor: theme => ({
                default: theme('colors.neutral.400', 'currentColor'),
            }),
        },
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/forms')({
            strategy: 'class',
        }),
    ]
};
