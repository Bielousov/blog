<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header();
//$randomPost = $wpdb->get_var("SELECT guid FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY rand() LIMIT 1");
$randomPost = $wpdb->get_var("SELECT guid FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_date > '2012-01-01 00:00:00' ORDER BY rand() LIMIT 1");
?>
</div><div id="error404">
	<div class="content">
		<h1>Страница, которой <big>НЕТ!</big></h1>
		<p class="main">Пока одни ищут правду, другие — братьев по разуму,<br/>
						третьи — лекарство от рака, а четвертые и вовсе — смысл жизни…</p>
		<p class="main"><big>Вы ищите страницу, которой нет.</big><br/>
			<?php echo '<small>Зачем? Ведь есть же <a href="'.$randomPost.'">страница, которая есть</a>!</small>'; ?>
		</p>
		<br/>
		<p>	А здесь вы не узнаете совершенно ничего нового об <a href="/category/immigration/">иммиграции</a> и не увидите <a href="/category/photos/">красивых фотографий</a>,<br/>
		   	не совершите <a href="/travels/">виртуального путешествия</a> и даже не почитаете <a href="/tag/news/">увлекательных репортажей</a>.<br/>
		   	Потому что этой страницы нет.
		 </p>

		<br/><br/><br/>

		<p><strong>Полный список того, чего здесь нет, есть на самой главной странице, которая есть</strong>.<br/>
			Вы можете нажать <a href="/">здесь</a> или <a href="/">здесь</a> чтобы перейти на нее. Или кликнуть <a href="/">здесь</a>.</p>
	</div>

<?php
/*
?>

	<div id="container">
		<div id="content" role="main">

			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( '404я страница', 'myblog' ); ?></h1>
				<div class="entry-content">
					<p style="font-size:125%;">
					    404 — очень много, почему бы не начать <a href="/">с первой</a>?
                    </p>

                    <script type="text/javascript">
                          var GOOG_FIXURL_LANG = 'ru';
                          var GOOG_FIXURL_SITE = 'http://www.example.com'
                        </script>
                        <script type="text/javascript"
                          src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js">
                    </script>

				</div><!-- .entry-content -->
			</div><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #container -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php */ get_footer(); ?>