const gulp = require('gulp');
const replace = require('gulp-replace'); // перестановка строк

// HTML
const fileInclude = require('gulp-file-include'); // включение html-файла внутрь другого html-файла
const htmlclean = require('gulp-htmlclean'); // очистка и минификация html-кода
const webpHTML = require('gulp-webp-retina-html'); // генерирует html-разметку для webp-картинок и ретина дисплеев
const typograf = require('gulp-typograf'); // применяет типографические правила и форматирует контент

// SASS
const sass = require('gulp-sass')(require('sass'));
const sassGlob = require('gulp-sass-glob'); // импортирует файлы с использованием glob-патерна
const autoprefixer = require('gulp-autoprefixer');
const csso = require('gulp-csso'); // минифицирует css-фалы
const webImagesCSS = require('gulp-web-images-css');  //Вывод WEBP-изображений

const server = require('gulp-server-livereload');
const clean = require('gulp-clean'); // убирает артифакты и временные файлы
const fs = require('fs');
const sourceMaps = require('gulp-sourcemaps');
const groupMedia = require('gulp-group-css-media-queries'); // группирует css-запросы в вместе в одном файле
const plumber = require('gulp-plumber'); // предотвращает ошибки
const notify = require('gulp-notify'); // уведомления о событиях в работе gulp
const webpack = require('webpack-stream'); // интегрирует webpack в gulp
const babel = require('gulp-babel'); // компилятор, который позволяет писать js согласно ES6, а потом переводить в формат подходящих для старых браузеров
const changed = require('gulp-changed');

// Images
const imagemin = require('gulp-imagemin'); // оптимизирует JPEG, PNG, GIF, and SVG
const imageminWebp = require('imagemin-webp'); // конвертирует и оптимизирует картинки в webp
const extReplace = require('gulp-ext-replace'); // замняет расширение файлов
const webp = require('gulp-webp'); // конвертирует картинки в webp

// SVG
const svgsprite = require('gulp-svg-sprite'); // генерирует спрайты

gulp.task('clean:prod', function (done) {
	if (fs.existsSync('./prod/')) {
		return gulp
			.src('./prod/', { read: false })
			.pipe(clean({ force: true }));
	}
	done();
});

const fileIncludeSetting = {
	prefix: '@@',
	basepath: '@file',
};

const plumberNotify = (title) => {
	return {
		errorHandler: notify.onError({
			title: title,
			message: 'Error <%= error.message %>',
			sound: false,
		}),
	};
};

gulp.task('html:prod', function () {
	return gulp
		.src(['./src/html/**/*.html', '!./src/html/blocks/*.html'])
		.pipe(changed('./prod/'))
		.pipe(plumber(plumberNotify('HTML')))
		.pipe(fileInclude(fileIncludeSetting))
		.pipe(
			replace(
				/(?<=src=|href=|srcset=)(['"])(\.(\.)?\/)*(img|images|fonts|css|scss|sass|js|files|audio|video)(\/[^\/'"]+(\/))?([^'"]*)\1/gi,
				'$1./$4$5$7$1'
			)
		)
		.pipe(
			typograf({
				locale: ['ru', 'en-US'],
				htmlEntity: { type: 'digit' },
				safeTags: [
					['<\\?php', '\\?>'],
					['<no-typography>', '</no-typography>'],
				],
			})
		)
		.pipe(
			webpHTML({
				extensions: ['jpg', 'jpeg', 'png', 'gif', 'webp'],
				retina: {
					1: '',
					2: '@2x',
				},
			})
		)
		.pipe(htmlclean())
		.pipe(gulp.dest('./prod/'));
});

gulp.task('sass:prod', function () {
	return gulp
		.src('./src/scss/*.scss')
		.pipe(changed('./prod/css/'))
		.pipe(plumber(plumberNotify('SCSS')))
		.pipe(sourceMaps.init())
		.pipe(autoprefixer())
		.pipe(sassGlob())
		.pipe(groupMedia())
		.pipe(sass())
		.pipe(
			webImagesCSS({
				mode: 'webp',
			})
		)
		.pipe(
			replace(
				/(['"]?)(\.\.\/)+(img|images|fonts|css|scss|sass|js|files|audio|video)(\/[^\/'"]+(\/))?([^'"]*)\1/gi,
				'$1$2$3$4$6$1'
			)
		)
		.pipe(csso())
		.pipe(sourceMaps.write())
		.pipe(gulp.dest('./prod/css/'));
});

gulp.task('images:prod', function () {
	return gulp
		.src(['./src/img/**/*', '!./src/img/svgicons/**/*'])
		.pipe(changed('./prod/img/'))
		.pipe(
			imagemin([
				imageminWebp({
					quality: 85,
				}),
			])
		)
		.pipe(webp({
			quality: 80,
			preset: 'photo', // определяет конфигурацию для оптимизации картинок
			method: 6 // степень сжатия
		}))
		// .pipe(extReplace('.webp'))
		.pipe(gulp.dest('./prod/img/'))
		.pipe(gulp.src('./src/img/**/*'))
		.pipe(changed('./prod/img/'))
		.pipe(
			imagemin(
				[
					imagemin.gifsicle({ interlaced: true }), // оптимизация gif
					imagemin.mozjpeg({ quality: 85, progressive: true }), // оптимизация jpge
					imagemin.optipng({ optimizationLevel: 5 }), // оптимизация png
				],
				{ verbose: true }
			)
		)
		.pipe(gulp.dest('./prod/img/'));
});

const svgStack = {
	mode: {
		stack: {
			example: true,
		},
	},
};

const svgSymbol = {
	mode: {
		symbol: {
			sprite: '../sprite.symbol.svg',
		},
	},
	shape: {
		transform: [
			{
				svgo: {
					plugins: [
						{
							name: 'removeAttrs',
							params: {
								attrs: '(fill|stroke)',
							},
						},
					],
				},
			},
		],
	},
};

gulp.task('svgStack:prod', function () {
	return gulp
		.src('./src/img/svgicons/**/*.svg')
		.pipe(plumber(plumberNotify('SVG:dev')))
		.pipe(svgsprite(svgStack))
		.pipe(gulp.dest('./prod/img/svgsprite/'));
});

gulp.task('svgSymbol:prod', function () {
	return gulp
		.src('./src/img/svgicons/**/*.svg')
		.pipe(plumber(plumberNotify('SVG:prod')))
		.pipe(svgsprite(svgSymbol))
		.pipe(gulp.dest('./prod/img/svgsprite/'));
});

gulp.task('files:prod', function () {
	return gulp
		.src('./src/files/**/*')
		.pipe(changed('./prod/files/'))
		.pipe(gulp.dest('./prod/files/'));
});

gulp.task('js:prod', function () {
	return gulp
		.src('./src/js/*.js')
		.pipe(changed('./prod/js/'))
		.pipe(plumber(plumberNotify('JS')))
		.pipe(babel())
		.pipe(webpack(require('./../webpack.config.js')))
		.pipe(gulp.dest('./prod/js/'));
});

const serverOptions = {
	livereload: true,
	open: true,
};

gulp.task('server:prod', function () {
	return gulp.src('./prod/').pipe(server(serverOptions));
});
