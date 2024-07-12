<?php
/*
Plugin Name: Custom Dispatch Messages
Description: Adds fields to select a dispatch time range and displays messages based on order placement time.
Version: 1.1
Author: Your Name
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Plugin activation
function cdm_activate()
{
    // Add activation code here
}
register_activation_hook(__FILE__, 'cdm_activate');

// Plugin deactivation
function cdm_deactivate()
{
    // Add deactivation code here
}
register_deactivation_hook(__FILE__, 'cdm_deactivate');

// Add a settings page
function cdm_add_settings_page()
{
    add_menu_page(
        'Dispatch Messages Settings',
        'Dispatch Messages',
        'manage_options',
        'cdm-settings',
        'cdm_render_settings_page',
        'dashicons-admin-generic'
    );
}
add_action('admin_menu', 'cdm_add_settings_page');

// Render the settings page
function cdm_render_settings_page()
{
    ?>
    <div class="wrap">
        <h1><?php _e('Dispatch Messages Settings', 'cdm'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('cdm_settings_group');
            do_settings_sections('cdm-settings');
            submit_button();
            ?>
        </form>
        <h2>Dispatch Message Preview</h2>
        <div class="dispatch-message-preview">
            <?php echo do_shortcode('[dispatch_message]'); ?>
        </div>
        <h2>Holidays</h2>
        <?php
        $holidays = get_option('cdm_holidays', array());
        if (!empty($holidays)) {
            echo '<ul>';
            foreach ($holidays as $holiday) {
                echo '<li>Date: ' . $holiday['date'] . ', Content: ' . $holiday['content_dec'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No holidays set.</p>';
        }
        ?>
    </div>
    <?php
}

function cdm_register_settings()
{
    register_setting('cdm_settings_group', 'cdm_before_message');
    register_setting('cdm_settings_group', 'cdm_after_message');
    register_setting('cdm_settings_group', 'cdm_cutoff_time', 'cdm_sanitize_time');
    register_setting('cdm_settings_group', 'cdm_holidays', 'cdm_sanitize_holidays');

    add_settings_section(
        'cdm_settings_section',
        __('Dispatch Messages', 'cdm'),
        null,
        'cdm-settings'
    );

    add_settings_field(
        'cdm_cutoff_time',
        __('Cutoff Time', 'cdm'),
        'cdm_cutoff_time_field_callback',
        'cdm-settings',
        'cdm_settings_section'
    );

    add_settings_field(
        'cdm_before_message',
        __('Message Before Cutoff Time', 'cdm'),
        'cdm_before_message_field_callback',
        'cdm-settings',
        'cdm_settings_section'
    );

    add_settings_field(
        'cdm_after_message',
        __('Message After Cutoff Time', 'cdm'),
        'cdm_after_message_field_callback',
        'cdm-settings',
        'cdm_settings_section'
    );

    add_settings_field(
        'cdm_holidays',
        __('Holidays', 'cdm'),
        'cdm_holidays_field_callback',
        'cdm-settings',
        'cdm_settings_section'
    );
}
add_action('admin_init', 'cdm_register_settings');

function cdm_sanitize_holidays($input)
{
    // Sanitize each holiday entry
    $sanitized = array();
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            if (!empty($value['date']) && !empty($value['content_dec'])) {
                $sanitized[$key]['date'] = sanitize_text_field($value['date']);
                $sanitized[$key]['content_dec'] = sanitize_text_field($value['content_dec']);
            }
        }
    }
    return $sanitized;
}

function cdm_sanitize_time($time)
{
    // Validate time format (HH:MM:SS)
    if (preg_match('/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', $time)) {
        return $time;
    }
    return '00:00:00'; // Default to 00:00:00 if format is invalid
}

function cdm_holidays_field_callback()
{
    $holidays = get_option('cdm_holidays', array());

    echo '<div id="cdm-holidays-container">';
    if (!empty($holidays)) {
        foreach ($holidays as $key => $holiday) {
            ?>
            <div class="cdm-holiday-entry">
                <input type="date" name="cdm_holidays[<?php echo $key; ?>][date]" value="<?php echo esc_attr($holiday['date']); ?>">
                <input type="text" name="cdm_holidays[<?php echo $key; ?>][content_dec]" value="<?php echo esc_attr($holiday['content_dec']); ?>">
                <button class="cdm-delete-holiday button button-secondary"><?php _e('Delete', 'cdm'); ?></button>
            </div>
            <?php
        }
    }
    echo '</div>';
    ?>
    <button id="cdm-add-holiday" class="button button-primary"><?php _e('Add more', 'cdm'); ?></button>
    <script>
        jQuery(document).ready(function ($) {
            $('#cdm-add-holiday').click(function (e) {
                e.preventDefault();
                var index = $('#cdm-holidays-container .cdm-holiday-entry').length;
                $('#cdm-holidays-container').append('<div class="cdm-holiday-entry"><input type="date" name="cdm_holidays[' + index + '][date]"><input type="text" name="cdm_holidays[' + index + '][content_dec]"><button class="cdm-delete-holiday button button-secondary">Delete</button></div>');
            });

            $(document).on('click', '.cdm-delete-holiday', function (e) {
                e.preventDefault();
                $(this).parent().remove();
            });
        });
    </script>
    <?php
}

// Callback functions for
function cdm_cutoff_time_field_callback()
{
    $value = get_option('cdm_cutoff_time', '12:00:00');
    echo '<input type="time" id="cdm_cutoff_time" name="cdm_cutoff_time" value="' . esc_attr($value) . '">';
}

// Display dispatch message based on selected times and holidays
function cdm_dispatch_message_shortcode()
{
    $current_time = current_time('timestamp', true); // Set the second parameter to true to use GMT time
    $timezone = 'Asia/Kolkata'; // Set the desired time zone

    $current_time_zone = new DateTimeZone($timezone);
    $current_time_zone_dt = new DateTime(null, $current_time_zone);
    $current_time_zone_dt->setTimestamp($current_time);

    $cutoff_time = new DateTime(null, $current_time_zone);
    $cutoff_time_str = get_option('cdm_cutoff_time', '12:00:00');
    list($hour, $minute, $second) = explode(':', $cutoff_time_str);
    $cutoff_time->setTime($hour, $minute, $second);

    $holidays = get_option('cdm_holidays', array());

    // Determine the next working day considering weekends and holidays
    $next_working_day = clone $current_time_zone_dt;
    $is_holiday_or_weekend = true;
    while ($is_holiday_or_weekend) {
        $next_working_day->modify('+1 day');
        $is_holiday_or_weekend = false;
        $day_of_week = $next_working_day->format('N'); // 6 = Saturday, 7 = Sunday
        if ($day_of_week >= 6) {
            $is_holiday_or_weekend = true;
            continue;
        }
        foreach ($holidays as $holiday) {
            $holiday_date = DateTime::createFromFormat('Y-m-d', $holiday['date'], $current_time_zone);
            if ($holiday_date && $holiday_date->format('Y-m-d') === $next_working_day->format('Y-m-d')) {
                $is_holiday_or_weekend = true;
                break;
            }
        }
    }

    // Determine if today is a holiday
    $today_is_holiday = false;
    $holiday_message = '';
    foreach ($holidays as $holiday) {
        $holiday_date = DateTime::createFromFormat('Y-m-d', $holiday['date'], $current_time_zone);
        if ($holiday_date && $holiday_date->format('Y-m-d') === $current_time_zone_dt->format('Y-m-d')) {
            $today_is_holiday = true;
            $holiday_message = $holiday['content_dec'];
            break;
        }
    }

    // Determine the initial message to display
    $message = '';
    if ($today_is_holiday) {
        $message = 'Today is a holiday: ' . $holiday_message . '. Orders placed today will be dispatched on ' . $next_working_day->format('l, F j, Y') . '.';
    } else {
        if ($current_time_zone_dt < $cutoff_time) {
            $diff = $current_time_zone_dt->diff($cutoff_time);
            $message = 'Orders placed before or at the cutoff time (' . $cutoff_time->format('H:i:s') . ') will be dispatched today.<br> Time remaining: <span id="cdm-timer">' . $diff->format('%h hours, %i minutes, %s seconds') . '</span>';
        } else {
            $message = 'Orders placed after the cutoff time (' . $cutoff_time->format('H:i:s') . ') will be dispatched on ' . $next_working_day->format('l, F j, Y') . '.';
        }
    }

    // Add the JavaScript for the countdown timer
    $message .= '<script>
    function cdm_updateTimer() {
        var cutoffTime = new Date("' . $cutoff_time->format('Y-m-d H:i:s') . '").getTime();
        var now = new Date().getTime();
        var distance = cutoffTime - now;

        if (distance > 0) {
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("cdm-timer").innerHTML = hours + " hours, " + minutes + " minutes, " + seconds + " seconds";
        } else {
            document.getElementById("cdm-timer").innerHTML = "Cutoff time has passed";
        }
    }

    setInterval(cdm_updateTimer, 1000);
    </script>';

    return $message;
}
add_shortcode('dispatch_message', 'cdm_dispatch_message_shortcode');





// Register settings fields for messages
function cdm_before_message_field_callback()
{
    $value = get_option('cdm_before_message', 'Orders placed during this time will be dispatched today.');
    echo '<textarea id="cdm_before_message" name="cdm_before_message" rows="5" cols="50">' . esc_textarea($value) . '</textarea>';
}

function cdm_after_message_field_callback()
{
    $value = get_option('cdm_after_message', 'Orders placed after this time will be dispatched tomorrow.');
    echo '<textarea id="cdm_after_message" name="cdm_after_message" rows="5" cols="50">' . esc_textarea($value) . '</textarea>';
}
?>
