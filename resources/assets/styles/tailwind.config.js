//  Purge only applied on `yarn build:production`
const {PWD} = process.env;

module.exports = {
  content: [
    `${PWD}/resources/views/**/*.blade.php`,
    `${PWD}/resources/assets/scripts/**/*.js`,
  ],
  safelist: [
    'grid',
    {
      pattern: /^grid-cols-/,
      variants: ['sm','md', 'lg', 'xl', '2xl', '3xl'],
    },
    {
      pattern: /^gap-/,
      variants: ['md', 'lg', 'xl', '2xl', '3xl'],
    },
    {
      pattern: /^col-span-/,
      variants: ['md', 'lg', 'xl', '2xl', '3xl'],
    },
    {
      pattern: /^col-start-/,
      variants: ['md', 'lg', 'xl', '2xl', '3xl'],
    },
    {
      pattern: /^mt-/,
      variants: ['md'],
    },
    {
      pattern: /^mb-/,
      variants: ['md'],
    },
  ],
  theme: {
    fontFamily: {
      'twk': ['TWK Everett', 'Noto Sans SC', 'sans-serif'],
      'tt': ['TT Hoves Pro', 'Noto Sans SC', 'sans-serif'],
    },
    container: {
      center: true,
      padding: '1.875rem', //30px
    },
    colors: {
      primary: '#1c1d1b',
      secondary: '#fd4c1b',
      black: {
        '100': '#000',
        '200': '#515151',
        '300': '#A0A0A0',
        '400': '#0A0A10',
      },
      grey: {
        '100': '#aaa',
        '200': '#7e7e7e',
        '300': '#8b8b8b',
        '400': '#e3e3e3',
        '500': '#383838',
      },
      white: {
        '100': '#fff',
      },
      green: {
        '100': '#00ad7b',
      },
      red: {
        '100': '#ef3346',
      },
      blue: {
        '100': '#E4EFF5',
      },
      transparent: 'transparent',
    },
    extend: {
      zIndex: {
        '1': 1,
        '2': 2,
        '100': 100,
      },
      screens: {
        '2xl': '1440px',
        '3xl': '1680px',
      },
      spacing: {
        '13':	'3.25rem',
        '15':'3.75rem',
        '16':	'4rem',
        '17':	'4.25rem',
        '18':	'4.5rem',
        '19':	'4.75rem',
        '21':	'5.25rem',
        '22':	'5.5rem',
        '23':	'5.75rem',
        '25': '6.25rem',
        '26':	'6.5rem',
        '27':	'6.75rem',
        '29':	'7.25rem',
        '30':	'7.5rem',
        '31':	'7.75rem',
        '33':	'8.25rem',
        '34':	'8.5rem',
        '35':	'8.75rem',
        '37':	'9.25rem',
        '38':	'9.5rem',
        '39': '9.75rem',
      },
    },
  },
  plugins: []
}
