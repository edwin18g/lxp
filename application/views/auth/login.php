<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Modern Split Screen Login -->
<style>
  :root {
    --primary-color: #0056d2;
    --primary-hover: #0044a5;
    --text-color: #1a1a1a;
    --text-muted: #6d7a8d;
    --border-color: #e1e5eb;
    --bg-color: #ffffff;
  }

  body,
  html {
    height: 100%;
    margin: 0;
    overflow: hidden;
    /* Prevent body scroll */
  }

  .auth-layout {
    display: flex;
    height: 100vh;
    /* Fixed height */
    width: 100%;
    overflow: hidden;
    /* Prevent layout scroll */
  }

  /* Left Side - Brand/Image */
  .auth-brand {
    flex: 1;
    background-image: url('<?php echo base_url("themes/default/images/course/course-01.jpg"); ?>');
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 30px;
    /* Reduced from 40px */
    color: white;
    height: 100%;
    display: none;
  }

  /* ... media query ... */

  /* ... auth-brand::before ... */

  .brand-content {
    position: relative;
    z-index: 2;
    max-width: 480px;
  }

  .brand-content h2 {
    font-size: 2.2rem;
    /* Increased from 2rem */
    font-weight: 700;
    margin-bottom: 5px;
    line-height: 1.1;
    color: #fff;
  }

  .brand-content p {
    font-size: 1rem;
    /* Increased from 0.95rem */
    opacity: 0.9;
    font-weight: 400;
  }

  /* Right Side - Form */
  .auth-form-container {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-color);
    padding: 20px;
    /* Slight increase for breathing room */
    height: 100%;
    overflow-y: auto;
    /* Internal scroll only */
    position: relative;
  }

  .auth-form-wrapper {
    width: 100%;
    max-width: 380px;
    animation: fadeIn 0.5s ease-out;
  }

  .auth-header {
    text-align: center;
    margin-bottom: 25px;
    /* Restored slightly */
  }

  .auth-logo {
    margin-bottom: 15px;
    display: block;
    text-align: center;
  }

  .auth-logo img {
    height: 38px;
    /* Slightly larger */
  }

  .auth-header h1 {
    font-size: 1.6rem;
    /* Increased from 1.4rem */
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 6px;
  }

  .auth-header p {
    color: var(--text-muted);
    font-size: 0.95rem;
    /* Increased from 0.85rem */
  }

  /* Form Elements */
  .form-group-modern {
    margin-bottom: 18px;
    /* Restored space */
  }

  .form-group-modern label {
    display: block;
    font-size: 0.95rem;
    /* Increased from 0.85rem */
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 6px;
  }

  .form-control-modern {
    width: 100%;
    padding: 10px 14px;
    /* Increased padding */
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    /* Increased from 0.9rem */
    transition: all 0.2s;
    background: #fcfcfc;
  }

  /* ... focus ... */

  .btn-primary-modern {
    width: 100%;
    padding: 12px;
    /* Increased */
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    /* Increased from 0.9rem */
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    margin-top: 8px;
  }

  /* ... links ... */
  .auth-links {
    margin-top: 20px;
    font-size: 0.9rem;
    /* Increased */
  }

  /* ... social ... */
  .divider-modern {
    margin: 20px 0;
    font-size: 0.8rem;
    /* Increased */
  }

  .btn-social {
    padding: 10px;
    /* Increased */
    font-size: 0.95rem;
    /* Increased */
  }

  /* ... social hover ... */

  .btn-social i {
    margin-right: 10px;
    font-size: 1.1rem;
  }

  /* ... colors ... */

  /* ... animations ... */

  .form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .remember-me {
    font-size: 0.9rem;
    /* Increased */
  }

  .forgot-pass {
    font-size: 0.9rem;
    /* Increased */
  }
</style>

<div class="auth-layout">
  <!-- Brand Side -->
  <div class="auth-brand">
    <div class="brand-content">
      <h2>Learn without limits.</h2>
      <p>Join the world's most supportive learning community today.</p>
    </div>
  </div>

  <!-- Form Side -->
  <div class="auth-form-container">
    <div class="auth-form-wrapper">
      <div class="auth-header">
        <a href="<?php echo site_url(); ?>" class="auth-logo">
          <img src="<?php echo base_url('/upload/institute/logo.png') ?>" alt="Logo">
        </a>
        <h1>Welcome back</h1>
        <p>Please enter your details to sign in.</p>
      </div>

      <?php echo form_open('auth/login', array('id' => 'form_login')); ?>
      <input type="hidden" name="fb_access_token">

      <div class="form-group-modern">
        <label for="identity">Email or Username</label>
        <?php echo form_input(array('name' => 'identity', 'id' => 'identity', 'class' => 'form-control-modern', 'placeholder' => 'Enter your email', 'value' => set_value('identity'))); ?>
        <?php if (form_error('identity')): ?><span
            class="text-danger small mt-1 d-block"><?php echo form_error('identity'); ?></span><?php endif; ?>
      </div>

      <div class="form-group-modern">
        <label for="password">Password</label>
        <?php echo form_password(array('name' => 'password', 'id' => 'password', 'class' => 'form-control-modern', 'placeholder' => '••••••••', 'autocomplete' => 'off')); ?>
        <?php if (form_error('password')): ?><span
            class="text-danger small mt-1 d-block"><?php echo form_error('password'); ?></span><?php endif; ?>
      </div>

      <div class="form-options">
        <label class="remember-me">
          <input type="checkbox" name="remember" value="1" id="remember">
          Remember me
        </label>
        <a href="<?php echo site_url('auth/forgot_password'); ?>" class="forgot-pass">Forgot password?</a>
      </div>

      <button type="submit" class="btn-primary-modern"><?php echo lang('users_login'); ?></button>
      <?php echo form_close(); ?>

      <div class="auth-links">
        Don't have an account? <a href="<?php echo site_url('auth/register'); ?>">Sign up for free</a>
      </div>

      <?php if (($this->settings->fb_app_id && $this->settings->fb_app_secret) || ($this->settings->g_client_id && $this->settings->g_client_secret)): ?>
        <div class="divider-modern"><span>Or continue with</span></div>

        <div class="social-buttons">
          <?php if ($this->settings->g_client_id && $this->settings->g_client_secret): ?>
            <a href="<?php echo site_url('auth/g_register') ?>" class="btn-social google">
              <i class="fa fa-google"></i> Google
            </a>
          <?php endif; ?>

          <?php if ($this->settings->fb_app_id && $this->settings->fb_app_secret): ?>
            <a href="<?php echo site_url('auth/f_register') ?>" class="btn-social facebook">
              <i class="fa fa-facebook"></i> Facebook
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>