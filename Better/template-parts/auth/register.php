<?php
/*
Template Name: Register Page
*/

get_header();
?>
<div class="auth-split-container">
    <div class="auth-image">
        <img src="https://thebetterco.co/wp-content/uploads/2024/09/lady-with-phone.png" alt="Lady with phone">
    </div>
    
    <div class="auth-form">
        <h1>Create your account</h1>
        <p class="auth-subtitle">Start investing in real estate with Better.</p>
        
        <form id="custom-registration" action="" method="post" enctype="multipart/form-data">
            <!-- Step 1: Personal Information -->
            <div class="form-step" id="step-1">
                <div class="role-selection">
                    <h3>I want to:</h3>
                    <div class="role-options">
                        <div class="role-option">
                            <input type="radio" id="co-buyer" name="user_role" value="co-buyer" required>
                            <label for="co-buyer">Co-buy a property</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="renter" name="user_role" value="renter" required>
                            <label for="renter">Rent a property</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="first_name" name="first_name" placeholder=" " required>
                        <label for="first_name">First name</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="last_name" name="last_name" placeholder=" " required>
                        <label for="last_name">Last name</label>
                    </div>
                </div>

                <div class="form-group">
                    <input type="date" id="dob" name="dob" placeholder=" " required>
                    <label for="dob">Date of birth</label>
                </div>

                <div class="form-group">
                    <input type="text" id="address" name="address" placeholder=" " required>
                    <label for="address">Address</label>
                </div>

                <button type="button" class="next-step">Next</button>
            </div>

            <!-- Step 2: Account Information -->
            <div class="form-step" id="step-2" style="display: none;">
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder=" " required>
                    <label for="email">Email address</label>
                </div>

                <div class="form-group">
                    <input type="tel" id="phone" name="phone" placeholder=" " required>
                    <label for="phone">Phone number</label>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder=" " required>
                    <label for="password">Password</label>
                </div>

                <div class="form-group">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*">
                    <label for="profile_image">Profile image (optional)</label>
                </div>

                <div class="button-group">
                    <button type="button" class="prev-step">Back</button>
                    <button type="submit" name="custom_registration_submit">Create account</button>
                </div>
            </div>

            <?php wp_nonce_field('custom_registration_nonce'); ?>
        </form>
    </div>
</div>
<?php get_footer(); ?>
