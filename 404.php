<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage MyBlog
 * @since 3.0
 */

    $randomPost = $wpdb->get_var("SELECT guid FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_date > '2012-01-01 00:00:00' ORDER BY rand() LIMIT 1");

    get_template_part( '_head' );
?>

<body <?php body_class(); ?>>

<?php
    get_header();
?>

<div id="wrapper" class="hfeed">
    <div id="error404">
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
    </div><!-- #main -->

    <?php get_footer(); ?>

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body></html>