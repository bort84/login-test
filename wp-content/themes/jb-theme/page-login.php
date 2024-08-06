<?php /* Template Name: Custom Login */ ?>

<?php if (isset($_POST['login_nonce']) && wp_verify_nonce($_POST['login_nonce'], 'user_login')) {
    $username = sanitize_text_field($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // does username field validate
    if (empty($username)) {
        $username_error = 'This field is required';
    }
    
    // does password field validate
    if (empty($password)) {
        $password_error = 'This field is required';
    }

    $creds = [
        'user_login' => $username,
        'user_password' => $password,
        'remember' => $remember,
    ];

    // parse creds through sign on and return true or false
    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        // do nothing
    } else {
        wp_safe_redirect(home_url());
        exit;
    }
} ?>

<?php get_header(); ?>

<main>
    <div class="bg" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/bg.png) no-repeat center center; background-size: cover;"></div>

    <section>
        <div>
            <div class="left-content">
                <div>
                    <?php the_title('<h1>','</h1>'); ?>
                    
                    <form action="" method="post" autocomplete="on">
                        <label for="username" class="required">Username or Email Address</label>
                        <input placeholder="Email@domain.com" type="text" name="username" id="username" autocomplete="on">
                        <?php if (!empty($username_error)): ?>
                                <p class="error"><?php echo $username_error; ?></p>
                            <?php endif; ?>
                        <label for="password" class="required">Password</label>
                        <input type="password" name="password" id="password" autocomplete="on">
                        <?php if (!empty($password_error)): ?>
                                <p class="error"><?php echo $password_error; ?></p>
                            <?php endif; ?>
                        <label for="remember" class="remember-me">Remember Me
                            <input type="checkbox" name="remember" id="remember"> 
                            <span class="checkmark"></span>
                        </label>
                        <button type="submit">Log in</button>
                        <?php wp_nonce_field('user_login', 'login_nonce'); ?>
                    </form>

                    <p class="help">Don't have an account? <a href="/register">Create one</a></p>
                </div>
            </div>
            <div class="right-content" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/right-bg.jpg) no-repeat center center; background-size: cover;">
                <?php // Get thumbnail and ACF fields

                $thumbnail_ID = get_post_thumbnail_id(get_the_ID());
                $featured_image = wp_get_attachment_image( $thumbnail_ID, 'full');
                $image_header = get_field('image_header'); 
                $image_text = get_field('image_text'); 
                
                if ($thumbnail_ID || $image_header || $image_text) { ?>
                    <div>
                        <?php echo $featured_image; ?>
                        <?php if ($image_header) { ?><h2>Develop Custom Partner Programs in Minutes!</h2><?php } ?>
                        <?php if ($image_text) { ?><p>With SuperCorpSoft all of your programs live in one spot!</p><?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>