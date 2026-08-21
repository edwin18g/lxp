<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Page Not Found - Zeyobron</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style type="text/css">
        *, *::before, *::after { box-sizing: border-box; }
        body {
            background-color: #F8FAFC;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(124, 58, 237, 0.08) 0px, transparent 50%);
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1E293B;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .error-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .error-card {
            background: #ffffff;
            max-width: 580px;
            width: 100%;
            border-radius: 24px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.02);
            padding: 48px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .error-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4F46E5, #7C3AED, #06B6D4);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #EEF2FF;
            color: #4F46E5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 24px;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
        }

        .error-card h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 16px 0;
            letter-spacing: -0.02em;
        }

        .error-message {
            font-size: 15px;
            line-height: 1.6;
            color: #475569;
            margin: 0 0 32px 0;
        }

        .error-message p {
            margin: 8px 0;
        }

        .error-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: #ffffff !important;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.45);
        }

        .btn-secondary {
            background: #F1F5F9;
            color: #334155 !important;
            border: 1px solid #E2E8F0;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: #E2E8F0;
            color: #0F172A !important;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION) && !empty($_SESSION['impersonator'])): ?>
    <div style="background: linear-gradient(90deg, #f59e0b, #d97706); color: #ffffff; padding: 10px 24px; font-weight: 600; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 99999; font-family: 'Plus Jakarta Sans', sans-serif;">
      <div style="display: flex; align-items: center; gap: 10px; font-size: 14px;">
        <i class="fa fa-user-secret" style="font-size: 18px;"></i>
        <span>You are currently logged in as <strong><?php echo isset($_SESSION['logged_in']['first_name']) ? htmlspecialchars($_SESSION['logged_in']['first_name'] . ' ' . $_SESSION['logged_in']['last_name']) : 'User'; ?></strong></span>
      </div>
      <div style="display: flex; align-items: center; gap: 10px;">
        <a href="<?php echo config_item('base_url') . 'index.php/auth/switch_back'; ?>" style="background: #ffffff; color: #b45309; border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          Switch Back to Admin
        </a>
        <a href="<?php echo config_item('base_url') . 'index.php/logout'; ?>" style="background: rgba(255,255,255,0.25); color: #ffffff; border: 1px solid rgba(255,255,255,0.4); border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          Logout
        </a>
      </div>
    </div>
    <?php endif; ?>

    <div class="error-wrapper">
        <div class="error-card">
            <div class="icon-container">
                <i class="fa-solid fa-compass"></i>
            </div>

            <h1><?php echo $heading; ?></h1>
            <div class="error-message">
                <?php echo $message; ?>
            </div>

            <div class="error-actions">
                <a href="<?php echo config_item('base_url'); ?>" class="btn-primary">
                    <i class="fa-solid fa-house"></i> Return to Home
                </a>
                <a href="<?php echo config_item('base_url') . 'index.php/contact'; ?>" class="btn-secondary">
                    <i class="fa-solid fa-headset"></i> Contact Support
                </a>
            </div>
        </div>
    </div>
</body>
</html>