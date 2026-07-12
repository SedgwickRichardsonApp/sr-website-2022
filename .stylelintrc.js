module.exports = {
  'extends': 'stylelint-config-standard',
  'rules': {
    'no-empty-source': null,
    "no-eol-whitespace": [ true, {
      "ignore": "empty-lines"
    } ],
    'string-quotes': 'double',
    'at-rule-no-unknown': [
      true,
      {
        'ignoreAtRules': [
          'tailwind',
          'apply',
          'responsive',
          'variants',
          'screen',
          'extend',
          'at-root',
          'debug',
          'warn',
          'error',
          'if',
          'else',
          'for',
          'each',
          'while',
          'mixin',
          'include',
          'content',
          'return',
          'function',
          'tailwind',
          'apply',
          'responsive',
          'variants',
          'screen',
        ],
      },
    ],
  },
};
