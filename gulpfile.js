const gulp = require('gulp');

// Tasks
require('./gulp/dev.js');
require('./gulp/prod.js');
require('./gulp/fontsDev.js');
require('./gulp/fontsProd.js');

gulp.task(
	'default',
	gulp.series(
		'clean:dev', 'fontsDev',
		gulp.parallel('html:dev', 'sass:dev', 'images:dev', gulp.series('svgStack:dev', 'svgSymbol:dev'), 'files:dev', 'js:dev'),
		gulp.parallel('server:dev', 'watch:dev')
	)
);

gulp.task(
	'prod',
	gulp.series(
		'clean:prod', 'fontsProd',
		gulp.parallel('html:prod', 'sass:prod', 'images:prod', gulp.series('svgStack:prod', 'svgSymbol:prod'), 'files:prod', 'js:prod'),
		gulp.parallel('server:prod')
	)
);
