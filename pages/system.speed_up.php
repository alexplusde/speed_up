<?php

$addon = rex_addon::get('speed_up');

$form = rex_config_form::factory($addon->getName());

$field = $form->addSelectField('profile');
$field->setLabel($this->i18n('speed_up_profile_label'));
$field->setNotice($this->i18n('speed_up_profile_notice'));
$select = $field->getSelect();
$select->setSize(1);
$select->addOption($this->i18n('speed_up_profile_disabled'), 'disabled');
$select->addOption($this->i18n('speed_up_profile_custom'), 'custom');
$select->addOption($this->i18n('speed_up_profile_auto'), 'auto');
$select->addOption($this->i18n('speed_up_profile_aggressive'), 'aggressive');

$field = $form->addTextAreaField('prefetch', null, ['class' => 'form-control']);
$field->setLabel($this->i18n('speed_up_additional_resources_prefetch_label'));
$field->setNotice($this->i18n('speed_up_additional_resources_prefetch_notice'));

$field = $form->addTextAreaField('preload', null, ['class' => 'form-control']);
$field->setLabel($this->i18n('speed_up_additional_resources_preload_label'));
$field->setNotice($this->i18n('speed_up_additional_resources_preload_notice'));

$field = $form->addLinkmapField('prefetch_articles');
$field->setLabel($this->i18n('speed_up_additional_resources_prefeth_articles_label'));

$field = $form->addMedialistField('preload_media');
$field->setLabel($this->i18n('speed_up_additional_resources_preload_media_label'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('speed_up_settings'), false);
$fragment->setVar('body', $form->get(), false);

?>
<div class="row">
	<div class="col-lg-8">
		<?= $fragment->parse('core/page/section.php') ?>
	</div>
	<div class="col-lg-4">
		<?php

$anchor = '<a target="_blank" href="https://donate.alexplus.de/?addon=speed_up"><img src="' . rex_url::addonAssets('speed_up', 'jetzt-beauftragen.svg') . '" style="width: 100% max-width: 400px;"></a>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'info', false);
$fragment->setVar('title', $this->i18n('speed_up_donate'), false);
$fragment->setVar('body', '<p>' . $this->i18n('speed_up_info_donate') . '</p>' . $anchor, false);
echo !rex_config::get('alexplusde', 'donated') ? $fragment->parse('core/page/section.php') : '';

if (rex_addon::get('ycom')->isAvailable()) {
    echo rex_view::info($this->i18n('speed_up_info_ycom_active'));
}
if (rex_addon::get('url')->isAvailable()) {
    echo rex_view::info($this->i18n('speed_up_info_url_active'));
}

if (!rex_request::isHttps() && 'HTTP/2.0' != $_SERVER['SERVER_PROTOCOL']) {
    echo rex_view::error($this->i18n('speed_up_no_http2') . $_SERVER['SERVER_PROTOCOL']);
}

echo rex_view::info($this->i18n('speed_up_info_ep'));

if (!rex_addon::get('media_manager_responsive')->isAvailable()) {
    $anchor = '<a target="_blank" href="https://github.com/alexplusde/media_manager_responsive/">' . $this->i18n('speed_up_info_media_manager_responsive_install') . '</a>';
    $fragment = new rex_fragment();
    $fragment->setVar('class', 'info', false);
    $fragment->setVar('title', $this->i18n('speed_up_info_media_manager_responsive_title'), false);
    $fragment->setVar('body', '<p>' . $this->i18n('speed_up_info_media_manager_responsive_inactive') . '</p>' . $anchor, false);
    echo $fragment->parse('core/page/section.php');
}

$package = rex_install_packages::getUpdatePackages();
if (isset($packages['speed_up'])) {
    $current_version = rex_addon::get('speed_up')->getProperty('version');
    if (isset($package['files'])) {
        $latest_version = array_pop($updates)['version'];
    }
    if (rex_version::compare($latest_version, $current_version, '>')) {
        echo rex_view::info($this->i18n('speed_up_update_available') . ' ' . $latest_version);
    }
}
?>
	</div>
</div>
