{**
 * plugins/generic/issuearticlesort/templates/settingsForm.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Issue Article Sorting plugin settings form.
 *}
<script>
    $(function() {ldelim}
    // Attach the form handler.
    $('#issueArticleSortSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
    {rdelim});
</script>

<form class="pkp_form" id="issueArticleSortSettingsForm" method="post"
    action="{url router=$smarty.const.ROUTE_COMPONENT component="grid.settings.plugins.SettingsPluginGridHandler" op="manage" params=$URLArgs verb="settings" plugin=$pluginName category="generic" save=true}">
    {csrf}
    {include file="common/formErrors.tpl"}

    {fbvFormArea id="issueArticleSortSettings"}
    {fbvFormSection title="plugins.generic.issuearticlesort.settings.sortOrder" list=true}
    {foreach from=$sortOptions key=optionValue item=optionLabel}
        {fbvElement type="radio" name="sortOrder" id="sortOrder-`$optionValue`" value=$optionValue label=$optionLabel checked=$sortOrder|compare:$optionValue}
    {/foreach}
    {/fbvFormSection}
    {/fbvFormArea}

    {fbvFormButtons id="issueArticleSortSettingsFormSubmit" submitText="common.save" hideCancel=true}
</form>