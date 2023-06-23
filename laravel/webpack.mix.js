const mix = require('laravel-mix');

require('laravel-mix-react');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

mix
    .react('resources/js/app.js', 'public/js') // ".react()" 붙트레이에 변경 ('app.js'는 적절한 경로로 교체)
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .browserSync({ // Browsersync 설정 추가
      proxy: 'localhost:8000', // Laravel 서버를 프록시로 사용
      files: [ // 감시할 파일 목록
        'app/**/*.php',
        'resources/views/**/*.php',
        'resources/js/**/*.js',
        'resources/css/**/*.css'
      ]
});
