tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        animation:{
            'fadein': 'fadein 1s ease-in',
            'expand': 'expand 0.5s ease-in forwards',
            'shrink': 'shrink 0.5s ease-in forwards',
            'expandY': 'expandY 0.5s ease-in-out forwards',
        },
        keyframes: {
            'fadein':{
                '0%':{ opacity: 0 },
                '100%':{ opacity:1 }
            },
            'expand':{
                '0%':{ width:'0%', opacity: 0 },
                '100%': { width: '100%', opacity: 1 }
            },
            'shrink':{
                '0%':{ width: '100%', opacity: 1 },
                '100%': { width:'0%', opacity: 0 }
            },
            'expandY':{
                '0%':{ "max-height":'0%' },
                '100%': { "max-height": '100%' }
            }
        },
        colors: {
          primary: {"50":"#f0f9ff","100":"#e0f2fe","200":"#bae6fd","300":"#7dd3fc","400":"#38bdf8","500":"#0ea5e9","600":"#0284c7","700":"#0369a1","800":"#075985","900":"#0c4a6e"}
        }
      },
      fontFamily: {
        'body': [
      'Inter',
      'ui-sans-serif',
      'system-ui',
      '-apple-system',
      'system-ui',
      'Segoe UI',
      'Roboto',
      'Helvetica Neue',
      'Arial',
      'Noto Sans',
      'sans-serif',
      'Apple Color Emoji',
      'Segoe UI Emoji',
      'Segoe UI Symbol',
      'Noto Color Emoji'
    ],
        'sans': [
      'Inter',
      'ui-sans-serif',
      'system-ui',
      '-apple-system',
      'system-ui',
      'Segoe UI',
      'Roboto',
      'Helvetica Neue',
      'Arial',
      'Noto Sans',
      'sans-serif',
      'Apple Color Emoji',
      'Segoe UI Emoji',
      'Segoe UI Symbol',
      'Noto Color Emoji'
    ]
      }
    }
  }
