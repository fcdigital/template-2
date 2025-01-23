const gulp = require('gulp');
const fileInclude = require('gulp-file-include');
const sass = require('gulp-sass')(require('sass'));
const sassGlob = require('gulp-sass-glob');
const server = require('gulp-server-livereload');
const clean = require('gulp-clean');
const fs = require('fs');
const sourceMaps = require('gulp-sourcemaps');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const webpack = require('webpack-stream');
const babel = require('gulp-babel');
const imagemin = require('gulp-imagemin');
const changed = require('gulp-changed');
const typograf = require('gulp-typograf');
const svgsprite = require('gulp-svg-sprite');
const replace = require('gulp-replace');

gulp.task('clean:dev', function (done) {
	if (fs.existsSync('./build/')) { // проверяет, что build существует
		return gulp
			.src('./build/', { read: false })
			.pipe(clean({ force: true })); // очищает внутренности build
	}
	done(); // сигнализирует об окончании операции
});

const fileIncludeSetting = {
	prefix: '@@',
	basepath: '@file',
};

const plumberNotify = (title) => { // выводит сообщение об ошибке
	return {
		errorHandler: notify.onError({
			title: title,
			message: 'Error <%= error.message %>',
			sound: false,
		}),
	};
};

gulp.task('html:dev', function () {
	return gulp
		.src(['./src/html/**/*.html', '!./src/html/blocks/*.html']) // обращается ко всем html файлам кроме одной директории
		.pipe(changed('./build/', { hasChanged: changed.compareContents })) // с помощью changed плагина выявляет где были изменения
		.pipe(plumber(plumberNotify('HTML'))) // используется plumber плагин. Если есть ошибка, вызывается ранее определенная plumberNotify
		.pipe(fileInclude(fileIncludeSetting)) // обрабатывает файлы, которые основываются на настройках fileIncludeSetting
		.pipe(
			replace(
				/(?<=src=|href=|srcset=)(['"])(\.(\.)?\/)*(img|images|fonts|css|scss|sass|js|files|audio|video)(\/[^\/'"]+(\/))?([^'"]*)\1/gi,
				'$1./$4$5$7$1'
			) // заменяет путь к файлам на ./
		)
		.pipe(
			typograf({ // плагин, который преобразует ковычки и т.д.
				locale: ['ru', 'en-US'], // используется для русского и английского
				htmlEntity: { type: 'digit' },  // цифровые символы будут преобразованы в их html эквиваленты
				safeTags: [
					['<\\?php', '\\?>'],
					['<no-typography>', '</no-typography>'], // текст в этих двух тегах не будет обрабатываться плагином типографии
				],
			})
		)
		.pipe(gulp.dest('./build/')); // куда будут помещены файлы
});

gulp.task('sass:dev', function () {
	return gulp
		.src('./src/scss/*.scss')
		.pipe(changed('./build/css/'))
		.pipe(plumber(plumberNotify('SCSS')))
		.pipe(sourceMaps.init()) // инициализирует карты
		.pipe(sassGlob())  // плагин разрешает импорт нескольких файлов одним выражением импорта
		.pipe(sass()) // компилирует sass в css
		.pipe(
			replace(
				/(['"]?)(\.\.\/)+(img|images|fonts|css|scss|sass|js|files|audio|video)(\/[^\/'"]+(\/))?([^'"]*)\1/gi,
				'$1$2$3$4$6$1'
			)
		)
		.pipe(sourceMaps.write()) // дописывает путь к картам для файлов
		.pipe(gulp.dest('./build/css/'));
});

gulp.task('images:dev', function () {
	return (
		gulp
			.src(['./src/img/**/*', '!./src/img/svgicons/**/*'])
			.pipe(changed('./build/img/'))
			// .pipe(imagemin({ verbose: true })) // сжатие картинок. Verbose отвечает за подробный вывод информации о прецессе
			.pipe(gulp.dest('./build/img/'))
	);
});

const svgStack = {
	mode: {
		stack: {
			example: true, // настройка stack означает создание спрайтов. Example: true - с создание примеров.
		},
	},
	shape: {
		transform: [
			{
				svgo: {
					js2svg: { indent: 4, pretty: true }, // Этот объект представляет преобразование, выполняемое с помощью SVGO (SVG Optimizer). SVGO используется для оптимизации SVG-файлов. js2svg - Настройки для преобразования SVG из JavaScript-объекта в строку SVG. Указано 4 пробела и применение переносов строк и отступов
				},
			},
		],
	},
};

const svgSymbol = {
	mode: {
		symbol: {
			sprite: '../sprite.symbol.svg', // там будут спрайты
		},
	},
	shape: {
		transform: [
			{
				svgo: {
					js2svg: { indent: 4, pretty: true },
					plugins: [
						{
							name: 'removeAttrs', // будем убирать при создании спрайта атрибуты fill и stroke, указанные ниже
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

gulp.task('svgStack:dev', function () {
	return gulp
		.src('./src/img/svgicons/**/*.svg')
		.pipe(plumber(plumberNotify('SVG:dev')))
		.pipe(svgsprite(svgStack))
		.pipe(gulp.dest('./build/img/svgsprite/'))
});

gulp.task('svgSymbol:dev', function () {
	return gulp
		.src('./src/img/svgicons/**/*.svg')
		.pipe(plumber(plumberNotify('SVG:dev')))
		.pipe(svgsprite(svgSymbol))
		.pipe(gulp.dest('./build/img/svgsprite/'));
});

gulp.task('files:dev', function () {
	return gulp
		.src('./src/files/**/*')
		.pipe(changed('./build/files/'))
		.pipe(gulp.dest('./build/files/'));
});

gulp.task('js:dev', function () {
	return gulp
		.src('./src/js/*.js')
		.pipe(changed('./build/js/'))
		.pipe(plumber(plumberNotify('JS')))
		// .pipe(babel()) // компилятор, который позволяет писать js согласно ES6, а потом переводить в формат подходящих для старых браузеров
		.pipe(webpack(require('./../webpack.config.js')))  // запускает webpack.config.js
		.pipe(gulp.dest('./build/js/'));
});

const serverOptions = {
	livereload: true,
	open: true,
};

gulp.task('server:dev', function () {
	return gulp.src('./build/').pipe(server(serverOptions));
});

gulp.task('watch:dev', function () {
	gulp.watch('./src/scss/**/*.scss', gulp.parallel('sass:dev')); // следит за scss-файлами, когда изменяются, запускается sass:dev
	gulp.watch(
		['./src/html/**/*.html', './src/html/**/*.json'],
		gulp.parallel('html:dev')
	);
	gulp.watch('./src/img/**/*', gulp.parallel('images:dev'));
	gulp.watch('./src/files/**/*', gulp.parallel('files:dev'));
	gulp.watch('./src/js/**/*.js', gulp.parallel('js:dev'));
	gulp.watch(
		'./src/img/svgicons/*',
		gulp.series('svgStack:dev', 'svgSymbol:dev') // series запускает таски последовательно в отличает от parallel
	);
});
