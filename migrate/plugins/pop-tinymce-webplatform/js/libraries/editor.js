"use strict";
(function($){
window.pop.Editor = {

	//-------------------------------------------------
	// PUBLIC functions
	//-------------------------------------------------

	editor : function(args) {
	
		var that = this;
		var pageSection = args.pageSection, block = args.block, targets = args.targets;

		// When the block gets its content replaced (for the editor, it happens in Edit Profile), also destroy the editor
		block.one('rerender', function(action) {

			that.destroy(targets);
		});
		var pageSectionPage = pop.Manager.getPageSectionPage(block);
		pageSectionPage.one('destroy', function() {
			that.destroy(targets);
		});

		// All the targets are inputs inside a form. Before the form submits, it will save the wpEditor value
		targets.each(function() {
			
			var editor = $(this).find('.pop-editor');
			var editorId = editor.attr('id');
			editor.closest('form')
				.on('beforeSubmit', function() {

					// It gives an error in Safari when starting in HTML mode that it doesn't find tinymce.get(editor.attr('id'))
					// So check also this condition
					// If the content changed, then this editor is set "active" and so it works fine
					if (tinymce.get(editorId)) {
						tinymce.get(editorId).save();
					}
				});
		});
		targets.filter('.pop-editor-form-clear').each(function() {
			
			var editor = $(this).find('.pop-editor');
			var editorId = editor.attr('id');
			editor.closest('form')
				.on('clear', function() {

					// It gives an error in Safari when starting in HTML mode that it doesn't find tinymce.get(editor.attr('id'))
					// So check also this condition
					// If the content changed, then this editor is set "active" and so it works fine
					if (tinymce.get(editorId)) {
						
						tinymce.get(editorId).setContent('');
					}
				});
		});

		// The first time the page is loaded, this code is already executed by WP loaded code, so no to initialize them here
		// The execution comes loaded from doing wp_editor($value, $editor_id, $options); in 'editor-forminputs-base.php'
		// So when the page settings are cached, that instruction is not executed, and so WP will not execute the js, so do it then
		// For this same reason, we're using $(document).ready(function($){, so that it will execute at the end, when everything else is initialized already
		if (!pop.Data.sitemeta.cachedsettings && pop.Manager.isFirstLoad(pageSection)) {
			return;
		}
		$(document).ready(function($){
		
			targets.each(function() {

				// The editor is wrapped with a div as to add the {{generateId}}, so the real editor is its child
				var editor = $(this).find('.pop-editor');
				var editorId = editor.attr('id');
				var settings = tinyMCEPreInit.mceInit[pop.c.MODULESETTINGS_EDITOR_NAME];
				if (editor.hasClass('pop-editor-autofocus')) {
					settings = $.extend({}, settings, {auto_focus: editorId});
				}

				tinyMCE.init(settings);
				tinymce.execCommand('mceAddEditor', true, editorId);
				
				// Get the quicktags options from the placeholder wpEditor, copy them, and change the id to initialize the new editor
				var qtOptions = $.extend({}, tinyMCEPreInit.qtInit[pop.c.MODULESETTINGS_EDITOR_NAME], {id: editorId});
				quicktags(qtOptions);

				// Copied from the code generated by wp_editor() in the footer
				if ( ! window.wpActiveEditor ) {
					window.wpActiveEditor = editorId;
				}
				if ( typeof jQuery !== 'undefined' ) {
					editor.closest('.wp-editor-wrap').on( 'click.wp-editor', function() {
						if ( this.id ) {
							window.wpActiveEditor = this.id.slice( 3, -5 );
						}
					});
				} else {
					document.getElementById( 'wp-' + editorId + '-wrap' ).onclick = function() {
						window.wpActiveEditor = this.id.slice( 3, -5 );
					}
				}
			});
		});
		
	},	

	//-------------------------------------------------
	// PUBLIC but not EXPOSED functions
	//-------------------------------------------------

	destroy : function(targets) {
	
		var that = this;
		targets.each(function() {

			var editor = $(this).find('.pop-editor');
			var editorId = editor.attr('id');
			tinymce.execCommand('mceRemoveEditor', false, editorId);
		});
	}
};
})(jQuery);

//-------------------------------------------------
// Initialize
//-------------------------------------------------
pop.JSLibraryManager.register(pop.Editor, ['editor']);
