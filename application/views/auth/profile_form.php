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
      --border-color: rgba(255, 255, 255, 0.2);
      --bg-color: #ffffff;
    }

    body,
    html {
      height: 100%;
      margin: 0;
      overflow-x: hidden;
      font-family: 'Inter', sans-serif;
    }

    .auth-layout {
      min-height: 100vh;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      /* Premium Mesh Gradient Background */
      background-color: #f8fbff;
      background-image:
        radial-gradient(at 0% 0%, hsla(216, 100%, 95%, 1) 0, transparent 50%),
        radial-gradient(at 50% 0%, hsla(202, 100%, 98%, 1) 0, transparent 50%),
        radial-gradient(at 100% 0%, hsla(190, 100%, 96%, 1) 0, transparent 50%),
        radial-gradient(at 50% 100%, hsla(216, 100%, 95%, 1) 0, transparent 50%);
    }

    /* Glassmorphism Card */
    .auth-form-wrapper {
      width: 100%;
      max-width: 500px;
      padding: 50px;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.4);
      border-radius: 24px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
      animation: fadeInScale 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .auth-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .auth-logo {
      margin-bottom: 24px;
      display: block;
    }

    .auth-logo img {
      height: 42px;
    }

    .auth-header h1 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: var(--text-color);
      margin-bottom: 8px;
      letter-spacing: -0.03em;
    }

    .auth-header p {
      color: var(--text-muted);
      font-size: 1rem;
      font-weight: 500;
    }

    /* Form Elements */
    .form-group-modern {
      margin-bottom: 20px;
    }

    .form-group-modern label {
      display: block;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 8px;
    }

    .form-control-modern {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid #e1e5eb;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s;
      background: rgba(255, 255, 255, 0.5);
      color: var(--text-color);
    }

    .form-control-modern:focus {
      border-color: var(--primary-color);
      background: #fff;
      outline: none;
      box-shadow: 0 0 0 4px rgba(0, 86, 210, 0.1);
      transform: translateY(-1px);
    }

    .row-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    @media (max-width: 576px) {
      .row-grid {
        grid-template-columns: 1fr;
      }

      .auth-form-wrapper {
        padding: 30px 20px;
      }
    }

    .btn-primary-modern {
      width: 100%;
      padding: 14px;
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
      margin-top: 15px;
      box-shadow: 0 10px 20px -5px rgba(0, 86, 210, 0.3);
    }

    .btn-primary-modern:hover {
      background: var(--primary-hover);
      transform: translateY(-3px);
      box-shadow: 0 15px 30px -8px rgba(0, 86, 210, 0.4);
    }

    .auth-links {
      margin-top: 25px;
      text-align: center;
      font-size: 0.95rem;
      color: var(--text-muted);
      font-weight: 500;
    }

    .auth-links a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 700;
    }

    /* Social Auth */
    .divider-modern {
      display: flex;
      align-items: center;
      margin: 30px 0;
      color: var(--text-muted);
      font-size: 0.8rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }

    .divider-modern::before,
    .divider-modern::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e1e5eb;
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
      padding: 12px;
      border: 1.5px solid #e1e5eb;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.5);
      color: var(--text-color);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      font-size: 0.95rem;
    }

    .btn-social:hover {
      background: #fff;
      border-color: var(--primary-color);
      transform: translateY(-2px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
    }

    .checkbox-modern {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      font-size: 0.85rem;
      color: var(--text-muted);
      line-height: 1.5;
      margin-bottom: 25px;
      cursor: pointer;
    }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
      }

      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }
  </style>

  <div class="auth-layout">
    <div class="auth-form-wrapper">
      <div class="auth-header">
        <a href="<?php echo site_url(); ?>" class="auth-logo">
          <img src="<?php echo base_url('/upload/institute/logo.png') ?>" alt="Logo">
        </a>
        <h1>Create an Account</h1>
        <p>Start your learning journey today</p>
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