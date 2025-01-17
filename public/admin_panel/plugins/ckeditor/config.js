/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

/*
CKEDITOR.editorConfig = function( config ) {
	config.extraPlugins = 'abbr';
};
*/



CKEDITOR.editorConfig = function( config ) {
	//config.enterMode = CKEDITOR.ENTER_BR;
	//config.shiftEnterMode = CKEDITOR.ENTER_P;
	//TSK0100
	config.enterMode = CKEDITOR.ENTER_P;
	config.shiftEnterMode = CKEDITOR.ENTER_BR;
	
	config.extraPlugins = 'texttransform';
	
	config.removePlugins = 'save,print,preview,find,about,maximize,showblocks,cut,copy,smiley,pastefromword,copyformatting,paste';
	
/*
config.toolbar = [
    { name: 'texttransform', items: [ 'TransformTextToUppercase', 'TransformTextToLowercase', 'TransformTextCapitalize', 'TransformTextSwitcher' ] }
];*/
	
	//config.font = 'Arial,Helvetica,sans-serif';
	//GN config.contentsCss = "body {font-size: 20px;}";
	config.contentsCss = "body {font-size: 18px; font-family: Arial,Helvetica,sans-serif}";
	
	//config.allowedContent = 'p[style] center b br u em strong ul li a[!href,target] table[style] thead tfoot tbody tr td th div span img';
	//config.allowedContent = 'p[style] table tr td th tbody thead tfoot';
	//config.disAllowedContent: 'ul li ol';
	config.allowedContent = CKEDITOR.dtd;
	config.allowedContent =  'p{*}; table[*]; tr; td[*]; th; tbody; thead; tfoot; center; b; br; u; em; ul; li; strong; a[!href,target]; div{*}; span{*}; img[*]';

	config.autoParagraph = false;
	CKEDITOR.dtd.p.div = 1;
	//CKEDITOR.dtd.p.ul = 1;
	CKEDITOR.dtd.p.table  = 1;
	
	//config.font_names =  'serif;sans serif;monospace;cursive;fantasy;Lobster;'+config.font_names;
	CKEDITOR.config.fontSize_sizes="8/15px;9/16px;10/17px;11/18px;12/19px;13/20px;14/21px;16/23px;18/25px;20/27px;22/29px;24/31px;26/33px;28/35px;36/43px;48/55px;72/79px";
	
	
	config.forcePasteAsPlainText = true;

};

