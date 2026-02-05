<?php
define('BASEPATH', 'system');
define('ENVIRONMENT', 'development');
require_once('application/config/database.php');

$db = $db['default'];
$mysqli = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Settings to add
$settings = [
    [
        'setting_type' => 'home',
        'name' => 'promo_modal_enabled',
        'input_type' => 'dropdown',
        'options' => "0|Disabled\n1|Enabled",
        'is_numeric' => '1',
        'show_editor' => '0',
        'input_size' => 'small',
        'translate' => '0',
        'help_text' => 'Enable or disable the promotion modal on the landing page',
        'validation' => 'trim',
        'sort_order' => 176,
        'label' => 'Promotion Modal Enabled',
        'value' => '0'
    ],
    [
        'setting_type' => 'home',
        'name' => 'promo_modal_title',
        'input_type' => 'input',
        'options' => NULL,
        'is_numeric' => '0',
        'show_editor' => '0',
        'input_size' => 'medium',
        'translate' => '0',
        'help_text' => 'Title displayed on the modal',
        'validation' => 'trim',
        'sort_order' => 177,
        'label' => 'Promotion Modal Title',
        'value' => 'Special Offer!'
    ],
    [
        'setting_type' => 'home',
        'name' => 'promo_modal_content',
        'input_type' => 'textarea',
        'options' => NULL,
        'is_numeric' => '0',
        'show_editor' => '0',
        'input_size' => 'large',
        'translate' => '0',
        'help_text' => 'Content displayed on the modal',
        'validation' => 'trim',
        'sort_order' => 178,
        'label' => 'Promotion Modal Content',
        'value' => 'Get 50% off on all courses today.'
    ],
    [
        'setting_type' => 'home',
        'name' => 'promo_modal_image',
        'input_type' => 'file',
        'options' => NULL,
        'is_numeric' => '0',
        'show_editor' => '0',
        'input_size' => 'medium',
        'translate' => '0',
        'help_text' => 'Image displayed on the modal (Recommended size: 600x400)',
        'validation' => 'trim',
        'sort_order' => 179,
        'label' => 'Promotion Modal Image',
        'value' => ''
    ],
    [
        'setting_type' => 'home',
        'name' => 'promo_modal_btn_text',
        'input_type' => 'input',
        'options' => NULL,
        'is_numeric' => '0',
        'show_editor' => '0',
        'input_size' => 'small',
        'translate' => '0',
        'help_text' => 'Text for the call-to-action button',
        'validation' => 'trim',
        'sort_order' => 180,
        'label' => 'Modal Button Text',
        'value' => 'Get Offer'
    ],
    [
        'setting_type' => 'home',
        'name' => 'promo_modal_btn_url',
        'input_type' => 'input',
        'options' => NULL,
        'is_numeric' => '0',
        'show_editor' => '0',
        'input_size' => 'medium',
        'translate' => '0',
        'help_text' => 'URL for the call-to-action button',
        'validation' => 'trim',
        'sort_order' => 181,
        'label' => 'Modal Button URL',
        'value' => '#'
    ]
];

foreach ($settings as $setting) {
    // Check if exists
    $check = $mysqli->query("SELECT id FROM settings WHERE name = '" . $setting['name'] . "'");
    if ($check->num_rows == 0) {
        $keys = implode(',', array_keys($setting));
        $values = implode("','", array_map(function ($v) use ($mysqli) {
            return $mysqli->real_escape_string($v); }, array_values($setting)));
        $sql = "INSERT INTO settings ($keys) VALUES ('$values')";

        if ($mysqli->query($sql)) {
            echo "Inserted " . $setting['name'] . "\n";
        } else {
            echo "Error inserting " . $setting['name'] . ": " . $mysqli->error . "\n";
        }
    } else {
        echo "Setting " . $setting['name'] . " already exists.\n";
    }
}

$mysqli->close();
?>