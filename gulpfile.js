'use strict';

const gulp = require('gulp');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const ts = require('gulp-typescript');
var pxtorem = require('postcss-pxtorem');

function css() {
    return gulp
        .src('./scss/app.scss')
        .pipe(plumber())
        .pipe(
            sass({
                outputStyle: 'compressed',
                allowEmpty: true,
                silenceDeprecations: ['legacy-js-api'],
            })
        )
        .pipe(rename('misc.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(gulp.dest('./build/css/'));
}

function images() {
    return gulp.src('./images/*.{png,jpg,gif,svg}').pipe(gulp.dest('./build/images/'));
}

function fonts() {
    return gulp.src('./fonts/*').pipe(gulp.dest('./build/fonts/'));
}

function settingCSS() {
    return gulp
        .src('./scss/setting.scss')
        .pipe(
            sass({
                outputStyle: 'compressed',
                allowEmpty: true,
                silenceDeprecations: ['legacy-js-api'],
            })
        )
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(gulp.dest('./build/css/'));
}

function typescripts() {
    return (
        gulp
            .src([
                // './ts/modules/helper.ts',
                './ts/app.ts',
                // './ts/modules/db.ts',
                // './ts/modules/lazy.ts',
                // './ts/modules/map.ts',
                './ts/modules/zoom.ts',
                // './ts/modules/photos.ts',
                './ts/modules/comment.ts',
                './ts/modules/scroll.ts',
                './ts/modules/date.ts',
            ])
            .pipe(
                ts({
                    noImplicitAny: true,
                    outFile: 'ts.js',
                })
            )
            //.pipe(uglify())
            .pipe(gulp.dest('build/js/'))
    );
}

function setting() {
    return gulp
        .src(['./ts/extensions/*', './ts/setting.ts'])
        .pipe(plumber())
        .pipe(
            ts({
                noImplicitAny: true,
                outFile: 'setting.js',
                target: 'es5',
            })
        )
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./build/js/'));
}

// Watch files
function watchFiles() {
    gulp.watch(
        ['./scss/app.scss', './scss/components/*', './scss/base/*', './scss/templates/*'],
        gulp.series(css)
    );
    gulp.watch(['./scss/setting.scss'], gulp.series(settingCSS));
    gulp.watch(['./ts/app.ts', './ts/modules/*'], gulp.series(typescripts));
    gulp.watch(['./ts/setting.ts'], gulp.series(setting));
}

// define complex tasks
const watch = gulp.parallel(watchFiles);
const build = gulp.parallel(
    watch,
    gulp.parallel(css, setting, images, fonts, typescripts, settingCSS)
);

exports.setting = setting;
exports.css = css;
exports.settingCSS = settingCSS;
exports.typescripts = typescripts;
exports.build = build;
exports.watch = watch;
exports.default = build;
