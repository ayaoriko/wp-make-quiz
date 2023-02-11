(function() {
    tinymce.create( 'tinymce.plugins.wp_make_quiz_button', {
      init: function( ed, url ) {
        ed.addButton( 'quiz', {
          title: 'クイズプラグイン',
          icon: 'code',
          cmd: 'quiz_cmd'
        });

        ed.addCommand( 'quiz_cmd', function() {
          // var selected_text = ed.selection.getContent(),
              return_text = '[quiz question="桃太郎,浦島太郎,金太郎" answer="桃太郎" commentary="桃太郎だけが桃から生まれました" random="true" style="school"]桃から生まれたのは？[/quiz]';
          ed.execCommand( 'mceInsertContent', 0, return_text );
        });
      },
      createControl : function( n, cm ) {
        return null;
      },
    });
    tinymce.PluginManager.add( 'wp_make_quiz_button_plugin', tinymce.plugins.wp_make_quiz_button );
  })();