<?php

if (!defined('ABSPATH')) {
    // Exit if accessed directly
    exit;
}

/**
 * Live Story Plugin Admin Page
 */

$defaultBrandCode = get_option('livestory_brandcode');
if (!$defaultBrandCode && defined('LIVESTORY_BRANDCODE') && LIVESTORY_BRANDCODE) {
    $defaultBrandCode = LIVESTORY_BRANDCODE;
}
?>

<div class="wrap">
    <div style="display: inline-block; margin-right: 20px;">
        <img src="<?php echo esc_url(plugins_url('live-story-short-code/images/logo.png')); ?>" width="64" height="64" />
    </div>
    <div style="display: inline-block; height: 64px; vertical-align: top;">
        <h1>Live Story</h1>
        <h2 style="margin-top: 0"><em>Activate your content</em></h2>
    </div>
    <hr />
    <form method="post" action="options.php">
        <?php settings_fields('livestory_settings'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Enable</th>
                <td>
                    <?php if(get_option('livestory_enable', 'enabled')): ?>
                        <input type="checkbox" name="livestory_enable" value="enabled" checked="checked" />
                    <?php else: ?>
                        <input type="checkbox" name="livestory_enable" value="enabled" />
                    <?php endif; ?>
                    <p class="description">Globally enable or disable Live Story (default: <em>enabled</em>)</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Brand Code</th>
                <td>
                    <input type="text" name="livestory_brandcode" value="<?php echo esc_attr($defaultBrandCode); ?>" />
                    <p class="descriprion">The customer code, usually the first part of the main credentials (<em><strong>brandcode</strong>@accounts.livestory.nyc</em>)</p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
