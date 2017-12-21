/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.toolbarGroups = [
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'tools' },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'colors' },
		{ name: 'styles' }
	];

    config.height = 620;
	config.contentsCss = "/assets/css/appPost.css";
	config.extraPlugins = 'uploadimage';
    config.uploadUrl = '/admin/upload/image';

};
