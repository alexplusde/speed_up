<?php

$addon = rex_addon::get('speed_up');

$form = rex_config_form::factory($addon->name);
if(rex_addon::get('ycom')->isAvailable()) {
    echo rex_view::info($this->i18n('speed_up_info_ycom_active'));
}
if(rex_addon::get('url')->isAvailable()) {
    echo rex_view::info($this->i18n('speed_up_info_url_active'));
}


$field = $form->addSelectField('profile');
$field->setLabel($this->i18n('speed_up_profile_label'));
$field->setNotice($this->i18n('speed_up_profile_notice'));
$select = $field->getSelect();
$select->setSize(1);
$select->addOption($this->i18n('speed_up_profile_disabled'), 'disabled');
$select->addOption($this->i18n('speed_up_profile_custom'), 'custom');
$select->addOption($this->i18n('speed_up_profile_auto'), 'auto');
$select->addOption($this->i18n('speed_up_profile_aggressive'), 'aggressive');

$field = $form->addTextAreaField('prefetch', null, ["class" => "form-control"]);
$field->setLabel($this->i18n('speed_up_additional_resources_prefetch_label'));
$field->setNotice($this->i18n('speed_up_additional_resources_prefetch_notice'));

$field = $form->addTextAreaField('preload', null, ["class" => "form-control"]);
$field->setLabel($this->i18n('speed_up_additional_resources_preload_label'));
$field->setNotice($this->i18n('speed_up_additional_resources_preload_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('speed_up_settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');

echo rex_view::info($this->i18n('speed_up_info_ep'));

echo rex_view::info($this->i18n('speed_up_info_donate'));
