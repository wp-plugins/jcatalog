/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 //config.language = 'en';
	 //config.uiColor = '#DDE8F2';
	config.toolbar =  'Basic'; 
	
    config.toolbar = 'ckbasic';

	config.toolbar_ckbasic=[
	                    	{ name: 'basicstyles', items : ['Bold','Italic','Strike','-','RemoveFormat'] },
	                    	{ name: 'clipboard', items : ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'] },
	                    	{ name: 'styles', items : ['Styles','Format'] }
	                    	];

	config.toolbar_ckstandard=[
	                           { name: 'basicstyles', items : ['Bold','Italic','Strike','-','RemoveFormat'] },
	                           { name: 'clipboard', items : ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'] },
	                           { name: 'styles', items : ['Styles','Format'] },
	                           '/',
	                           { name: 'paragraph', items : ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote'] },
	                           { name: 'colors', items : ['TextColor','BGColor'] }
	                           ];

	
    config.toolbar_ckfull =[
                            { name: 'basicstyles', items : ['Bold','Italic','Strike','-','RemoveFormat'] },
                            { name: 'clipboard', items : ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'] },
                            { name: 'styles', items : ['Styles','Format'] },
                            '/',
                            { name: 'paragraph', items : ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote'] },
                            { name: 'colors', items : ['TextColor','BGColor'] },
                            '/',
                            { name: 'editing', items : ['Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt'] },
                            { name: 'forms', items : ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
                            '/',
                            { name: 'links', items : ['Link','Unlink','Anchor'] },
                            { name: 'insert', items : ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'] }
                            ];


};
