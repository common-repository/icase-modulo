(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

(function() {
    tinymce.create("tinymce.plugins.botao_acesso_restrito", {

        init : function(ed, url) {

            ed.addButton("restrito", {
                title : "Conteúdo restrito",
                cmd : "conteudo_restrito",
                image : "http://icase.newcbr.itarget.com.br/images/itarget/icase.ico"
            });

            ed.addCommand("conteudo_restrito", function() {
                var return_text = "[restrito] # Aidicione o conteúdo restrito aqui # [/restrito]";
                ed.execCommand("mceInsertContent", false, return_text);
            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Acesso restrito",
                author : "Itarget Tecnologia",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("botao_acesso_restrito", tinymce.plugins.botao_acesso_restrito);
})();
