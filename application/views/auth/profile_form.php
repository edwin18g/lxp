<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$is_logged_in = $this->session->userdata('logged_in');
?>

<?php if (!$is_logged_in): ?>
  <!-- Modern Split Screen Register -->
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
      display: none;
      /* Hidden on mobile by default */
      height: 100%;
    }

    @media (min-width: 992px) {
      .auth-brand {
        display: flex;
      }
    }

    .auth-brand::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
      z-index: 1;
    }

    .brand-content {
      position: relative;
      z-index: 2;
      max-width: 480px;
    }

    .brand-content h2 {
      font-size: 2.2rem;
      /* Increased */
      font-weight: 700;
      margin-bottom: 5px;
      line-height: 1.1;
      color: #fff;
    }

    .brand-content p {
      font-size: 1rem;
      /* Increased */
      opacity: 0.9;
      font-weight: 400;
    }

    /* Right Side - Form */
    .auth-form-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: var(--bg-color);
      padding: 20px;
      /* Increased */
      height: 100%;
      overflow-y: auto;
      /* Internal scroll only */
    }

    .auth-form-wrapper {
      width: 100%;
      max-width: 480px;
      /* Slightly wider */
      animation: fadeIn 0.5s ease-out;
      margin: auto 0;
    }

    .auth-header {
      text-align: center;
      margin-bottom: 25px;
      /* Restored */
    }

    .auth-logo {
      margin-bottom: 15px;
      display: block;
      text-align: center;
    }

    .auth-logo img {
      height: 38px;
      /* Larger */
    }

    .auth-header h1 {
      font-size: 1.6rem;
      /* Increased */
      font-weight: 700;
      color: var(--text-color);
      margin-bottom: 6px;
    }

    .auth-header p {
      color: var(--text-muted);
      font-size: 0.95rem;
      /* Increased */
    }

    /* Form Elements */
    .form-group-modern {
      margin-bottom: 16px;
      /* Restored */
    }

    .form-group-modern label {
      display: block;
      font-size: 0.95rem;
      /* Increased */
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 6px;
    }

    .form-control-modern {
      width: 100%;
      padding: 10px 14px;
      /* Increased */
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 1rem;
      /* Increased */
      transition: all 0.2s;
      background: #fcfcfc;
    }

    .form-control-modern:focus {
      border-color: var(--primary-color);
      background: #fff;
      outline: none;
      box-shadow: 0 0 0 4px rgba(0, 86, 210, 0.1);
    }

    .row-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      /* Restored */
    }

    @media (max-width: 576px) {
      .row-grid {
        grid-template-columns: 1fr;
      }
    }

    .btn-primary-modern {
      width: 100%;
      padding: 12px;
      /* Increased */
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      /* Increased */
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s, transform 0.1s;
      margin-top: 10px;
    }

    .btn-primary-modern:hover {
      background: var(--primary-hover);
      transform: translateY(-1px);
    }

    .auth-links {
      margin-top: 20px;
      text-align: center;
      font-size: 0.9rem;
      /* Increased */
      color: var(--text-muted);
    }

    .auth-links a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 600;
    }

    .auth-links a:hover {
      text-decoration: underline;
    }

    /* Social Auth */
    .divider-modern {
      display: flex;
      align-items: center;
      margin: 20px 0;
      color: var(--text-muted);
      font-size: 0.8rem;
      /* Increased */
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .divider-modern::before,
    .divider-modern::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border-color);
    }

    .divider-modern span {
      padding: 0 15px;
    }

    .social-buttons {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .btn-social {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      /* Increased */
      border: 1px solid var(--border-color);
      border-radius: 8px;
      background: white;
      color: var(--text-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s;
      font-size: 0.95rem;
      /* Increased */
    }

    .btn-social:hover {
      background: #f8f9fa;
      border-color: #d1d7dc;
    }

    .btn-social i {
      margin-right: 10px;
      font-size: 1.1rem;
    }

    .btn-social.google {
      color: #db4437;
    }

    .btn-social.facebook {
      color: #4267B2;
    }

    .checkbox-modern {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 0.9rem;
      /* Increased */
      color: var(--text-muted);
      line-height: 1.4;
      margin-bottom: 20px;
    }

    .checkbox-modern input {
      margin-top: 4px;
      /* Adjusted alignment */
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

  <div class="auth-layout">
    <!-- Brand Side -->
    <div class="auth-brand">
      <div class="brand-content">
        <h2>Start your journey.</h2>
        <p>Create an account to unlock exclusive courses and community features.</p>
      </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-container">
      <div class="auth-form-wrapper">
        <div class="auth-header">
          <a href="<?php echo site_url(); ?>" class="auth-logo">
            <img src="<?php echo base_url('/upload/institute/logo.png') ?>" alt="Logo">
          </a>
          <h1>Create an Account</h1>
          <p>It's free and only takes a minute.</p>
        </div>

        <?php echo form_open_multipart('', array('role' => 'form', 'id' => 'form_register')); ?>
        <input type="hidden" name="language" value="english">

        <div class="row-grid">
          <div class="form-group-modern">
            <label>First Name</label>
            <?php echo form_input(array('name' => 'first_name', 'placeholder' => 'First Name', 'value' => set_value('first_name'), 'class' => 'form-control-modern', 'required' => 'required')); ?>
          </div>
          <div class="form-group-modern">
            <label>Last Name</label>
            <?php echo form_input(array('name' => 'last_name', 'placeholder' => 'Last Name', 'value' => set_value('last_name'), 'class' => 'form-control-modern', 'required' => 'required')); ?>
          </div>
        </div>

        <div class="form-group-modern">
          <label>Username</label>
          <?php echo form_input(array('name' => 'username', 'placeholder' => 'Choose a username', 'value' => set_value('username'), 'class' => 'form-control-modern', 'required' => 'required')); ?>
          <?php if (form_error('username')): ?><span
              class="text-danger small mt-1 d-block"><?php echo form_error('username'); ?></span><?php endif; ?>
        </div>

        <div class="form-group-modern">
          <label>Email Address</label>
          <?php echo form_input(array('name' => 'email', 'type' => 'email', 'placeholder' => 'name@example.com', 'value' => set_value('email'), 'class' => 'form-control-modern', 'required' => 'required')); ?>
          <?php if (form_error('email')): ?><span
              class="text-danger small mt-1 d-block"><?php echo form_error('email'); ?></span><?php endif; ?>
        </div>

        <div class="row-grid">
          <div class="form-group-modern">
            <label>Password</label>
            <?php echo form_password(array('name' => 'password', 'placeholder' => '••••••••', 'class' => 'form-control-modern', 'required' => 'required')); ?>
            <?php if (form_error('password')): ?><span
                class="text-danger small mt-1 d-block"><?php echo form_error('password'); ?></span><?php endif; ?>
          </div>
          <div class="form-group-modern">
            <label>Confirm Password</label>
            <?php echo form_password(array('name' => 'password_confirm', 'placeholder' => '••••••••', 'class' => 'form-control-modern', 'required' => 'required')); ?>
            <?php if (form_error('password_confirm')): ?><span
                class="text-danger small mt-1 d-block"><?php echo form_error('password_confirm'); ?></span><?php endif; ?>
          </div>
        </div>

        <label class="checkbox-modern">
          <input type="checkbox" name="terms" value="1" required>
          <span>I agree to the Terms and Conditions. The content, videos, and materials belong to Z-eyobron. Unauthorized
            sharing is subject to penalties.</span>
        </label>

        <button type="submit" name="submit_form" class="btn-primary-modern"><?php echo lang('users_register'); ?></button>
        <?php echo form_close(); ?>

        <div class="auth-links">
          Already have an account? <a href="<?php echo site_url('auth/login'); ?>">Log in</a>
        </div>

        <?php if (($this->settings->fb_app_id && $this->settings->fb_app_secret) || ($this->settings->g_client_id && $this->settings->g_client_secret)): ?>
          <div class="divider-modern"><span>Or sign up with</span></div>

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

<?php else: ?>
  <!-- Existing Profile Edit UI (For Logged In Users) -->
  <!-- ... (Keep existing logged-in profile edit code same as before, only showing non-logged in part here for brevity in this tool call, but strictly I must preserve the file content. I will paste the original else block below) ... -->
  <div class="page-default bg-grey">
    <div class="container">
      <?php echo form_open_multipart('', array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'form_login')); ?>
      <input type="hidden" name="fb_access_token">
      <input type="hidden" name="fb_user_id">
      <input type="hidden" name="fb_email">
      <input type="hidden" name="fb_fullname">
      <div class="row">
        <div class="col-md-12 text-center image-card">
          <div class="picture-container">
            <div class="picture">
              <img
                src="<?php echo (isset($user['image']) && $user['image']) ? base_url('upload/users/images/') . $user['image'] : base_url('themes/default/images/avatar.jpg'); ?>"
                class="picture-src img-responsive" id="wizardPicturePreview" title="" />
              <input type="file" id="wizard-picture" name="image">
            </div>
          </div>
        </div>
      </div>
      <br><br>
      <div class="row">
        <div class="col-md-5">
          <div class="form-group <?php echo form_error('first_name') ? ' has-error' : ''; ?>">
            <?php echo lang('users_first_name', 'first_name', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_input(array('name' => 'first_name', 'value' => set_value('first_name', (isset($user['first_name']) ? $user['first_name'] : '')), 'class' => 'form-control input-lg')); ?>
            </div>
          </div>
          <div class="form-group <?php echo form_error('email') ? ' has-error' : ''; ?>">
            <?php echo lang('users_email', 'email', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_input(array('name' => 'email', 'value' => set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class' => 'form-control input-lg', 'type' => 'email')); ?>
            </div>
          </div>
          <div class="form-group <?php echo form_error('mobile') ? ' has-error' : ''; ?>">
            <?php echo lang('users_mobile', 'mobile', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-sm-8">
              <?php echo form_input(array('name' => 'mobile', 'value' => set_value('mobile', (isset($user['mobile']) ? $user['mobile'] : '')), 'class' => 'form-control input-lg')); ?>
            </div>
          </div>
          <div class="form-group <?php echo form_error('dob') ? ' has-error' : ''; ?>">
            <?php echo lang('users_dob', 'dob', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_input(array('name' => 'dob', 'value' => set_value('dob', (isset($user['dob']) ? $user['dob'] : '')), 'class' => 'form-control input-lg', 'id' => 'dob')); ?>
            </div>
          </div>
          <?php if (!$this->ion_auth->is_non_admin()) { ?>
            <div class="form-group <?php echo form_error('profession') ? ' has-error' : ''; ?>">
              <?php echo lang('users_profession', 'profession', array('class' => 'col-md-4 control-label')); ?>
              <div class="col-md-8">
                <?php echo form_input(array('name' => 'profession', 'value' => set_value('profession', (isset($user['profession']) ? $user['profession'] : '')), 'class' => 'form-control input-lg')); ?>
              </div>
            </div>
          <?php } ?>
          <div class="form-group <?php echo form_error('password') ? ' has-error' : ''; ?>">
            <?php echo lang('users_password', 'password', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_password(array('name' => 'password', 'value' => set_value('password', (isset($user['password']) ? $user['password'] : '')), 'class' => 'form-control input-lg')); ?>
            </div>
          </div>
          <div class="form-group <?php echo form_error('address') ? ' has-error' : ''; ?>">
            <?php echo lang('users_address', 'address', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_textarea(array('name' => 'address', 'value' => set_value('address', (isset($user['address']) ? $user['address'] : '')), 'class' => 'form-control input-lg', 'rows' => 3)); ?>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="form-group <?php echo form_error('last_name') ? ' has-error' : ''; ?>">
            <?php echo lang('users_last_name', 'last_name', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_input(array('name' => 'last_name', 'value' => set_value('last_name', (isset($user['last_name']) ? $user['last_name'] : '')), 'class' => 'form-control input-lg')); ?>
            </div>
          </div>
          <div class="form-group <?php echo form_error('username') ? ' has-error' : ''; ?>">
            <?php echo lang('users_username', 'username', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_input(array('name' => 'username', 'value' => set_value('username', (isset($user['username']) ? $user['username'] : '')), 'class' => 'form-control input-lg')); ?>
            </div>
          </div>
          <div class="form-group <?php echo form_error('language') ? ' has-error' : ''; ?>">
            <?php echo lang('users_language', 'language', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_dropdown('language', $this->languages, (isset($user['language']) ? $user['language'] : $this->config->item('language')), 'id="language" class="form-control input-lg"'); ?>
            </div>
          </div>
          <div class="form-group <?php echo form_error('gender') ? ' has-error' : ''; ?>">
            <?php echo lang('users_gender', 'gender', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_dropdown('gender', array('male' => lang('users_gender_male'), 'female' => lang('users_gender_female'), 'other' => lang('users_gender_other')), (isset($user['gender']) ? $user['gender'] : 'male'), 'id="gender" class="form-control input-lg"'); ?>
            </div>
          </div>
          <?php if (!$this->ion_auth->is_non_admin()) { ?>
            <div class="form-group <?php echo form_error('experience') ? ' has-error' : ''; ?>">
              <?php echo lang('users_experience', 'experience', array('class' => 'col-md-4 control-label')); ?>
              <div class="col-md-8">
                <?php echo form_input(array('name' => 'experience', 'value' => set_value('experience', (isset($user['experience']) ? $user['experience'] : '')), 'class' => 'form-control input-lg', 'type' => 'number')); ?>
              </div>
            </div>
          <?php } ?>
          <div class="form-group <?php echo form_error('password_confirm') ? ' has-error' : ''; ?>">
            <?php echo lang('users_password_confirm', 'password_confirm', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
              <?php echo form_password(array('name' => 'password_confirm', 'value' => '', 'class' => 'form-control input-lg', 'autocomplete' => 'off')); ?>
              <span class="help-block"><?php echo lang('users_password_help'); ?></span>
            </div>
          </div>
        </div>

      </div>
      <br>
      <div class="row">
        <div class="col-md-12 text-center">
          <button type="submit" name="submit_form" id="submit_form"
            class="btn"><?php echo lang('action_save'); ?></button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
<?php endif; ?>