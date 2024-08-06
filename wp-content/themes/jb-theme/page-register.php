<?php /* Template Name: Custom Register */ ?>

<?php get_header(); ?>

<main>
    <div class="bg" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/bg.png) no-repeat center center; background-size: cover;"></div>

    <section>
        <div>
            <div class="left-content">
                <div>
                    <?php the_title('<h1>','</h1>'); ?>
                    
                    <?php $registration_successful = false;

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['register_nonce']) && wp_verify_nonce($_POST['register_nonce'], 'register_user')) {
                        $username = sanitize_text_field($_POST['username']);
                        $email = sanitize_email($_POST['email']);
                        $errors = [];

                        // does username field validate
                        if (empty($username)) {
                            $username_error = 'This field is required';
                        }
                        
                        // does email field validate
                        if (empty($email)) {
                            $email_error = 'This field is required';
                        }

                        // check to see if username exists
                        if (username_exists($username)) {
                            $errors[] = 'Username already exists.';
                        }

                        // is email a valid email and is it already assigned to an account
                        if (!is_email($email)) {
                            $errors[] = 'Invalid email address.';
                        } elseif (email_exists($email)) {
                            $errors[] = 'Email already exists.';
                        }

                        if (empty($errors)) {
                            // Generate a random password
                            $password = wp_generate_password();
                            $user_id = wp_create_user($username, $password, $email);

                            if (!is_wp_error($user_id)) {

                                $registration_successful = true;

                                // Send email to the user with the generated password
                                wp_mail($email, 'Your new account '.$username, 'Your username is: ' . $username . ' | Your password is: ' . $password); ?>
                                    <div class="registration-complete">
                                        <h2>Registration Complete!</h2>
                                        <p>Registration complete. Please check your email.</p>
                                        <div><a href="/login">Login Here</a></div>
                                    </div>
                                <?php 
                            } else {
                                $errors[] = $user_id->get_error_message();
                            }
                        }

                        // display errors if form cannot validate
                        if (!empty($errors)) {?>
                            <div class="errors">
                                <?php foreach ($errors as $error) {
                                    echo '<p class="error">'.esc_html($error).'</p>';
                                } ?>
                            </div>
                        <?php }
                    }

                    if (!$registration_successful) { ?>

                        <form action="" method="post" autocomplete="on">
                            <label for="username" class="required">Username</label>
                            <input type="text" name="username" id="username" autocomplete="on">
                            <?php if (!empty($username_error)): ?>
                                <p class="error"><?php echo $username_error; ?></p>
                            <?php endif; ?>
                            <label for="email" class="required">Email</label>
                            <input type="email" name="email" id="email" autocomplete="on">
                            <?php if (!empty($email_error)): ?>
                                <p class="error"><?php echo $email_error; ?></p>
                            <?php endif; ?>
                            <button type="submit">Register</button>
                            <?php wp_nonce_field('register_user', 'register_nonce'); ?>
                        </form>
                        
                        <p class="help">Already have an account? <a href="/login">Login Here</a></p>
                    <?php } ?>
                    
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