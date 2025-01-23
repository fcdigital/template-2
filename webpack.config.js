const config = {
	mode: 'production',
	entry: {
		index: './src/js/index.js',
		services: './src/js/services.js',
		specificService: './src/js/specific-service.js',
		simplePagesNavigation: './src/js/simple-pages-navigation.js'
		// about: './src/js/about.js',
	},
	output: {
		filename: '[name].bundle.js',
	},
	module: {
		rules: [
			{
				test: /\.css$/, // правило применяется к файлам формата .css
				use: ['style-loader', 'css-loader'], // style-loader вводит css-код в html с помощью тега style. CSS-loader импортирует css-код в js-модули
			},
		],
	},
};

module.exports = config;
