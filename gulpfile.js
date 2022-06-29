import gulp from 'gulp'
import del from 'del'
import dartSass from 'sass'
import gulpSass from 'gulp-sass'
import cleanCSS from 'gulp-clean-css'
import rename from 'gulp-rename'
import babel from 'gulp-babel'
import terser from 'gulp-terser'
import concat from 'gulp-concat'
import sourcemaps from 'gulp-sourcemaps'
import autoprefixer from 'gulp-autoprefixer'
import imagemin from 'gulp-imagemin'
import webp from 'gulp-webp'
import htmlmin from 'gulp-htmlmin'
import phpMinify from '@cedx/gulp-php-minify'
import fileinclude from 'gulp-file-include'
import newer from 'gulp-newer'
import browsersync from 'browser-sync'

const prj_folder = 'oxyproject',
	src_folder = 'src'

const { src, dest, watch, series, parallel } = gulp,
	sass = gulpSass(dartSass),
	{ init, write } = sourcemaps

const path = {
	src: {
		php: src_folder + '/*.php',
		phpServer: [src_folder + '/php/*.php', '!' + src_folder + '/**/_*.php'],
		css: src_folder + '/sass/style.scss',
		js: src_folder + '/js/index.js',
		img: src_folder + '/img/**/*',
		collection: src_folder + '/collection/**/*',
	},
	watch: {
		php: src_folder + '/**/*.php',
		css: src_folder + '/sass/**/*.scss',
		js: src_folder + '/js/**/*.js',
		img: src_folder + '/img/**/*',
		collection: src_folder + '/collection/**/*',
	},
	build: {
		php: prj_folder + '/',
		phpServer: prj_folder + '/php/',
		css: prj_folder + '/css/',
		js: prj_folder + '/js/',
		img: prj_folder + '/img/',
		collection: prj_folder + '/collection/',
	},
	clean: {
		all: [
			prj_folder + '/css/',
			prj_folder + '/js/',
			prj_folder + '/php/',
			prj_folder + '/*.php',
			prj_folder + '/img/',
			prj_folder + '/collection/',
		],
	},
}

//clean task
function cleanTask() {
	return del(path.clean.all)
}

//browsersync task
function browsersyncTask() {
	browsersync.init({
		proxy: {
			target: 'https://oxyproject.test/oxyproject/',
		},
	})
}

//php task
function phpTask() {
	return src(path.src.php)
		.pipe(fileinclude())
		.pipe(htmlmin({ collapseWhitespace: true }))
		.pipe(dest(path.build.php))
		.pipe(browsersync.stream())
}

//php server task
function phpServerTask() {
	return src(path.src.phpServer)
		.pipe(fileinclude())
		.pipe(phpMinify())
		.pipe(dest(path.build.phpServer))
		.pipe(browsersync.stream())
}

//style task
function styleTask() {
	return src(path.src.css)
		.pipe(init())
		.pipe(sass().on('error', sass.logError))
		.pipe(
			autoprefixer({
				cascade: false,
			})
		)
		.pipe(
			cleanCSS({
				level: 2,
			})
		)
		.pipe(
			rename({
				basename: 'style',
				suffix: '.min',
			})
		)
		.pipe(write('.'))
		.pipe(dest(path.build.css))
		.pipe(browsersync.stream())
}

//js task
function jsTask() {
	return src(path.src.js)
		.pipe(init())
		.pipe(
			babel({
				presets: ['@babel/preset-env'],
			})
		)
		.pipe(terser())
		.pipe(concat('main.min.js'))
		.pipe(write('.'))
		.pipe(dest(path.build.js))
		.pipe(browsersync.stream())
}

//images task
function imagesTask() {
	return src(path.src.img)
		.pipe(newer(path.build.img))
		.pipe(
			webp({
				quality: 80,
			})
		)
		.pipe(dest(path.build.img))
		.pipe(src(path.src.img))
		.pipe(
			imagemin({
				progressive: true,
				svgoPlugins: [{ removeViewBox: false }],
				interlaced: true,
				optimizationLevel: 3,
			})
		)
		.pipe(dest(path.build.img))
}

//collection task
function collectionTask() {
	return src(path.src.collection)
		.pipe(newer(path.build.collection))
		.pipe(
			webp({
				quality: 90,
			})
		)
		.pipe(dest(path.build.collection))
		.pipe(src(path.src.collection))
		.pipe(
			imagemin({
				progressive: true,
				svgoPlugins: [{ removeViewBox: false }],
				interlaced: true,
				optimizationLevel: 2,
			})
		)
		.pipe(dest(path.build.collection))
}

//watch task
function watchTask() {
	watch(path.build.php).on('change', browsersync.reload)
	watch(path.watch.php, phpTask)
	watch(path.watch.php, phpServerTask)
	watch(path.watch.css, styleTask)
	watch(path.watch.js, jsTask)
	watch(path.watch.img, imagesTask)
	watch(path.watch.collection, collectionTask)
}

//build
const _build = series(
	cleanTask,
	parallel(phpTask, phpServerTask, styleTask, jsTask, imagesTask, collectionTask)
)

//watch
const _watch = parallel(_build, watchTask, browsersyncTask)

//gulp tasks
export const _clean = cleanTask
export const _php = phpTask
export const _phpServer = phpServerTask
export const _style = styleTask
export const _js = jsTask
export const _img = imagesTask
export const _collection = collectionTask
export const __build = _build
export const __watch = _watch

//default gulp task
const _default = _watch
export { _default as default }
