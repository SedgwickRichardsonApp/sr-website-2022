module.exports = {
  'root': true,
  'extends': [
    'eslint:recommended',
    'plugin:react/recommended',
  ],
  'globals': {
    'wp': true,
    'SR': true,
  },
  'env': {
    'node': true,
    'es6': true,
    'amd': true,
    'browser': true,
    'jquery': true,
  },
  'parser': 'babel-eslint',
  'parserOptions': {
    'ecmaFeatures': {
      'globalReturn': true,
      'generators': false,
      'jsx': true,
      'modules': true,
      'objectLiteralDuplicateProperties': false,
      'experimentalObjectRestSpread': true,
    },
    'ecmaVersion': 2017,
    'sourceType': 'module',
  },
  'plugins': [
    'import',
  ],
  'settings': {
    'import/core-modules': [],
    'import/ignore': [
      'node_modules',
      '\\.(coffee|scss|css|less|hbs|svg|json)$',
    ],
    'react': {
      'createClass': 'createReactClass',
      'pragma': 'React',
      'version': '16.4.1',
    },
  },
  'rules': {
    'no-console': 0,
    'arrow-parens': ['error', 'always'],
    'comma-dangle': [
      'error',
      {
        'arrays': 'always-multiline',
        'objects': 'always-multiline',
        'imports': 'always-multiline',
        'exports': 'always-multiline',
        'functions': 'ignore',
      },
    ],
    'curly': 'error',
    'eol-last': ['error', 'always'],
    'indent': [
      'error', 2, {
        SwitchCase: 1,
        VariableDeclarator: 1,
        outerIIFEBody: 1,
        FunctionDeclaration: {
          parameters: 1,
          body: 1,
        },
        FunctionExpression: {
          parameters: 1,
          body: 1,
        },
        CallExpression: {
          arguments: 1,
        },
        ArrayExpression: 1,
        ObjectExpression: 1,
        ImportDeclaration: 1,
        flatTernaryExpressions: false,
        ignoredNodes: ['JSXElement', 'JSXElement > *', 'JSXAttribute', 'JSXIdentifier', 'JSXNamespacedName', 'JSXMemberExpression', 'JSXSpreadAttribute', 'JSXExpressionContainer', 'JSXOpeningElement', 'JSXClosingElement', 'JSXText', 'JSXEmptyExpression', 'JSXSpreadChild'],
        ignoreComments: false,
      }],
    'no-trailing-spaces': ["error", { "ignoreComments": true, "skipBlankLines": true }],
    'no-var': 'error',
    'quotes': ['error', 'single'],
    'rest-spread-spacing': ['error', 'never'],
    'no-unused-vars': 'off',
    // 'semi': ['error', 'always'],
  },
};
