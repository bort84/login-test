		<footer>
			<?php if (has_nav_menu('footer')) {
				wp_nav_menu(array('theme_location' => 'footer', 'container' => 'nav', 'container_class' => 'footer-navigation'));
			} ?>
		</footer>

		<?php wp_footer(); ?>
	</body>
</html>