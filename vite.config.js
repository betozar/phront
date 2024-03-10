export default {
	root: 'src/resources/assets',
	mode: 'development',
	build: {
		manifest: true,
		outDir: '../../../public/static',
		emptyOutDir: true,
		rollupOptions: {
			input: [
				'src/resources/assets/app.css',
				'src/resources/assets/app.js',
				'src/resources/assets/login.js',
			]
		},
	},
};
