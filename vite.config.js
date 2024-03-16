export default {
	root: 'src/resources/assets',
	mode: 'development',
	build: {
		manifest: true,
		outDir: '../../../public/static',
		emptyOutDir: true,
		rollupOptions: {
			input: [
				'src/resources/assets/css/app.css',
				'src/resources/assets/js/app.js',
			]
		},
	},
};
