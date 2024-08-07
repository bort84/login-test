<?php get_header(); ?>
<main>
	<h1>You are logged in. View your profile <a href="<?php echo admin_url( 'profile.php' ); ?>" target="_blank">here</a></h1>

	<p>Click here to <?php wp_loginout('/login'); ?></p>
</main>
<?php get_footer(); ?>