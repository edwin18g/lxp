<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo strip_tags($heading); ?> - Zeyobron</title>
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
            background: #FEF3C7;
            color: #D97706;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 24px;
            box-shadow: 0 10px 20px rgba(217, 119, 6, 0.15);
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
                <?php 
                $h_lower = strtolower($heading);
                if (strpos($h_lower, 'lock') !== false || strpos($h_lower, 'denied') !== false || strpos($h_lower, 'forbidden') !== false): 
                ?>
                    <i class="fa-solid fa-lock"></i>
                <?php elseif (strpos($h_lower, 'not found') !== false || strpos($h_lower, '404') !== false): ?>
                    <i class="fa-solid fa-compass"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-exclamation"></i>
                <?php endif; ?>
            </div>

            <h1><?php echo $heading; ?></h1>
            <div class="error-message">
                <?php echo $message; ?>
            </div>

            <?php 
            $is_lock_page = (strpos(strtolower($heading), 'lock') !== false);
            $active_sessions = array();
            if ($is_lock_page && function_exists('get_instance')) {
                $CI =& get_instance();
                if ($CI && !empty($CI->user['id'])) {
                    $CI->load->model('user_sessions_model');
                    $active_sessions = $CI->user_sessions_model->get_active($CI->user['id']);
                }
            }
            ?>

            <?php if ($is_lock_page): ?>
                <div style="margin: 24px 0; text-align: left; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px;">
                    <div style="font-weight: 700; font-size: 14px; color: #334155; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-laptop-code" style="color: #4F46E5; margin-right: 6px;"></i> Active Account Sessions</span>
                        <span style="background: #EEF2FF; color: #4F46E5; font-size: 12px; padding: 2px 10px; border-radius: 20px; font-weight: 600;"><?php echo count($active_sessions); ?> active</span>
                    </div>

                    <?php if (!empty($active_sessions)): ?>
                        <div style="display: flex; flex-direction: column; gap: 8px; max-height: 200px; overflow-y: auto; padding-right: 4px;">
                            <?php foreach ($active_sessions as $sess): ?>
                                <?php 
                                $is_current = ($sess['session_id'] === session_id());
                                $dev_type = strtolower($sess['device_type']);
                                $icon = ($dev_type === 'mobile') ? 'fa-mobile-screen-button' : (($dev_type === 'tablet') ? 'fa-tablet-screen-button' : 'fa-laptop');
                                ?>
                                <div style="display: flex; align-items: center; justify-content: space-between; background: #ffffff; padding: 10px 14px; border-radius: 10px; border: 1px solid <?php echo $is_current ? '#C7D2FE' : '#F1F5F9'; ?>;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 34px; height: 34px; border-radius: 8px; background: <?php echo $is_current ? '#EEF2FF' : '#F8FAFC'; ?>; color: <?php echo $is_current ? '#4F46E5' : '#64748B'; ?>; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                            <i class="fa-solid <?php echo $icon; ?>"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 13px; font-weight: 600; color: #0F172A;">
                                                <?php echo htmlspecialchars(($sess['browser'] ? $sess['browser'] : 'Browser') . ' on ' . ($sess['os'] ? $sess['os'] : 'Device')); ?>
                                                <?php if ($is_current): ?>
                                                    <span style="background: #DCFCE7; color: #15803D; font-size: 10px; padding: 1px 6px; border-radius: 4px; font-weight: 700; margin-left: 6px;">THIS DEVICE</span>
                                                <?php endif; ?>
                                            </div>
                                            <div style="font-size: 11px; color: #64748B;">
                                                IP: <?php echo htmlspecialchars($sess['ip_address']); ?> &bull; Active <?php echo date('M d, H:i', $sess['last_activity']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="font-size: 13px; color: #64748B; margin: 0;">Multiple simultaneous device logins were detected on your account.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

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