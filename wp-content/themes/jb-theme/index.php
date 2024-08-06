<?php get_header(); ?>
<main>
	<h1> You are logged in. Click here to <?php wp_loginout('/login'); ?>

	<p>View your profile <a href="/wp-admin/profile.php">here</a>
</main>
<?php get_footer(); ?>