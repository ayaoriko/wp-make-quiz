<?php
/*
Plugin Name: Quiz make plugin "sumire" 日本語クイズ作成プラグイン「すみれ」
Plugin URI: https://ayaoriko.com/coding/wordpress/wordpress-quiz-plugins/
Description: You can create multiple-choice quizzes with shortcodes. ショートコードを使用して多肢選択式クイズを作成できます。
Version: 1.2
Author: Yoshihiko Yoshida's product was modified by ayaoriko.
Domain Path: /languages
*/

function wp_make_quiz_lib(){
  if(!is_admin()){
    wp_enqueue_style('wp_make_quiz', plugins_url('css/default.css', __FILE__));
    wp_enqueue_style('wp_make_quiz_school', plugins_url('css/school.css', __FILE__));
    wp_enqueue_script('wp_make_quiz', plugins_url('script/script.js', __FILE__), array(), false, true);
    if ( !mq_get_quiz_type() ) {
      wp_enqueue_style(
        'google-material-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined',
        array(),
        null
      );
    }
  }
}

add_action('wp_enqueue_scripts', 'wp_make_quiz_lib');

function wp_make_quiz_show_text($atts, $title = null){
  if(!isset($atts['question']) || !isset($atts['answer']) || $title == null ){
    return null;
  }

  //質問一覧
  $question_list = explode(',', $atts['question']);

  //質問一覧をシャッフル
  if(isset($atts['random']) && $atts['random'] == 'true'){
    shuffle($question_list);
  }elseif(mq_is_quiz_random() === 'on'){
        shuffle($question_list);
  }

  if (!(empty($atts['style']))) {
  $style = $atts['style'];
  }elseif(mq_get_quiz_design()){
	  $style = mq_get_quiz_design();
  }else{
    $style = 'default';
  }

  if(!count($question_list)){
    return null;
  }
  if(!mq_get_quiz_type()){
	  $style .= ' css_type_google';
  }

  $answer = $atts['answer'];

  //HTML生成
  $html = '<div class="wp-make-quiz '.  $style.' ">';
  $html .= '<div class="wp-make-quiz-title"><p>'.$title.'</p></div>';
  $html .= '<ul class="wp-make-quiz-question">';
  foreach ($question_list as $question){
    if($question == $answer){
      $html .= '<li class="wp-make-quiz-question-list correct">'.$question.'</li>';
    }else{
      $html .= '<li class="wp-make-quiz-question-list incorrect">'.$question.'</li>';
    }
  }
  $html .= '</ul>';

  $html .= '<div class="wp-make-quiz-answer">';
  $html .= '<div class="wp-make-quiz-result-wrap">';
  $html .= '<p class="wp-make-quiz-result correct"><span>正解！</span></p>';
  $html .= '<p class="wp-make-quiz-result incorrect"><span>不正解...</span></p>';
  $html .= '<p class="wp-make-quiz-result-text">正解は<span>'.$answer.'</span>です。</p>';
  $html .= '</div>';
  if(isset($atts['commentary']) && $atts['commentary'] !=''){
    $html .= '<div class="wp-make-quiz-commentary"><p>'.$atts['commentary'].'</p></div>';
  }
  $html .= '<div class="wp-make-quiz-continue-wrap"><p class="wp-make-quiz-continue">問題に戻る</p></div>';
  $html .= '</div>';
  $html .= '</div>';

  return $html;
}
add_shortcode('quiz', 'wp_make_quiz_show_text');


/**
 * ショートコード設定
 * **/

add_filter( 'mce_external_plugins', 'add_add_shortcode_button_plugin' );
function add_add_shortcode_button_plugin( $plugin_array ) {
  $plugin_array[ 'wp_make_quiz_button_plugin' ] = plugins_url('script/quicktag.js', __FILE__);
  return $plugin_array;
}

add_filter( 'mce_buttons', 'add_shortcode_button' );
function add_shortcode_button( $buttons ) {
  $buttons[] = 'quiz';
  return $buttons;
}

add_action( 'admin_print_footer_scripts', 'add_shortcode_quicktags' );
function add_shortcode_quicktags() {
  if ( wp_script_is('quicktags') ) {
?>
  <script>
    QTags.addButton( 'wp_make_quiz', '[quiz]', '[quiz]', '[/quiz]' );
  </script>
<?php
  }
}


/**
 * 管理画面の設定
 * **/

 // 管理画面にメニューを追加
add_action('admin_menu', 'mq_add_settings_menu');
function mq_add_settings_menu() {
  add_management_page(
      'クイズプラグイン「すみれ」 設定',
      'クイズプラグイン「すみれ」 ',
      'manage_options',
      'mq-settings',
      'mq_settings_page_callback'
  );
}

add_filter('plugin_action_links_wp-make-quiz/wp-make-quiz.php', 'mq_add_plugin_settings_link');
function mq_add_plugin_settings_link($links) {
    $url = admin_url('tools.php?page=mq-settings');
    $settings_link = '<a href="' . esc_url($url) . '">設定</a>';
    array_unshift($links, $settings_link);
    return $links;
}

 function mq_settings_page_callback() {
  ?>
  <div class="wrap">
      <h1>クイズプラグイン「すみれ」 設定</h1>
      <form method="post" action="options.php">
          <?php
          settings_fields('mq_settings_group');
          do_settings_sections('mq-settings');
          submit_button();
          ?>
      </form>
  </div>
  <?php
}

add_action('admin_init', 'mq_register_settings');
function mq_register_settings() {
    // オプションの登録
    register_setting('mq_settings_group', 'mq_quiz_css');
    register_setting('mq_settings_group', 'mq_quiz_random');
    register_setting('mq_settings_group', 'mq_quiz_design');
	
    // セクションの追加
    add_settings_section(
        'mq_main_section',
        '基本設定',
        null,
        'mq-settings'
    );

    // デザイン設定フィールド
    add_settings_field(
        'mq_quiz_design',
        '基本のデザイン設定',
        'mq_quiz_design_callback',
        'mq-settings',
        'mq_main_section'
    );
    
    add_settings_field(
      'mq_quiz_random',
      'ランダム出題設定',
      'mq_quiz_random_callback',
      'mq-settings',
      'mq_main_section'
  );
	
	// CSS設定フィールド
    add_settings_field(
        'mq_quiz_css',
        '（高度な設定）CSSの読み込み設定',
        'mq_quiz_css_callback',
        'mq-settings',
        'mq_main_section'
    );
	
}

function mq_quiz_design_callback() {
    $value = get_option('mq_quiz_design', 'default'); // 初期値 default

    echo '<label><input type="radio" name="mq_quiz_design" value="default"' . checked($value, 'default', false) . ' > デザインパターン1(ベーシック)</label><br>';
    echo '<label><input type="radio" name="mq_quiz_design" value="school"' . checked($value, 'school', false) . ' > デザインパターン2(学校)</label>';
}

function mq_quiz_random_callback() {
  $value = get_option('mq_quiz_random', 'on'); // 初期値は 'on'

  echo '<label><input type="radio" name="mq_quiz_random" value="on"' . checked($value, 'on', false) . ' > 有効にする</label><br>';
  echo '<label><input type="radio" name="mq_quiz_random" value="off"' . checked($value, 'off', false) . ' > 無効にする</label>';
}
function mq_quiz_css_callback() {
    $css_value = get_option('mq_quiz_css', '');
    $school_css_value = get_option('mq_quiz_school_css', '');

    echo '<label><input type="checkbox" name="mq_quiz_css" value="1"' . checked($css_value, '1', false) . '> Google WebFontsを利用しない</label><br>';

}

function mq_get_quiz_design() {
    return get_option('mq_quiz_design', 'default');
}

function mq_is_quiz_random() {
  return get_option('mq_quiz_random', 'on');
}

function mq_get_quiz_type() {
    return get_option('mq_quiz_css', '');
}