/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.language = 'vi';
    config.removePlugins = 'flash';
    config.fillEmptyBlocks = false;
    config.allowedContent = true;
    config.ignoreEmptyParagraph = false;
    // ALLOW <i></i>
    config.protectedSource.push(/<i[^>]*><\/i>/g);
    // config.uiColor = '#AADC6E';
    var url='/freelancer/dathang86/assets/';
    config.filebrowserBrowseUrl         =url+ 'ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl  	=url+ 'ckfinder/ckfinder.html?type=Images';
    //config.filebrowserFlashBrowseUrl 	=url+ 'ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl 	=url+ 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl 	=url+ 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    //config.filebrowserFlashUploadUrl 	=url+ 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

    //config.toolbar = 'ShortToolbar';
    config.toolbar_ShortToolbar =
        [
            { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
            //{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
            //{ name: 'insert', items : [ 'Image', 'Table' ] },
            { name: 'tools', items : [ 'Maximize'] }
        ];
};
