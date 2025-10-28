/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  safelist: [
    // Gradient direction classes
    'bg-gradient-to-br',
    
    // Exact gradient classes from home.blade.php
    'from-orange-50',
    'to-orange-100',
    'from-amber-50',
    'to-amber-100',
    'from-green-50',
    'to-green-100',
    'from-red-50',
    'to-red-100',
    'from-purple-50',
    'to-purple-100',
    'from-blue-50',
    'to-blue-100',
    'from-pink-50',
    'to-pink-100',
    'from-indigo-50',
    'to-indigo-100',
    'from-teal-50',
    'to-teal-100',
    'from-cyan-50',
    'to-cyan-100',
    'from-lime-50',
    'to-lime-100',
    'from-emerald-50',
    'to-emerald-100',
    'from-violet-50',
    'to-violet-100',
    'from-fuchsia-50',
    'to-fuchsia-100',
    
    // Pattern-based safelist for comprehensive coverage
    {
      pattern: /bg-gradient-to-(r|l|t|b|tr|tl|br|bl)/,
    },
    {
      pattern: /from-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900)/,
    },
    {
      pattern: /to-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900)/,
    },
  ]
}