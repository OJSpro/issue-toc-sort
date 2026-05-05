<?php

/**
 * @file plugins/generic/issuearticlesort/IssuearticlesortSettingsForm.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class IssuearticlesortSettingsForm
 *
 * @brief Form for journal managers to modify Issue Article Sorting plugin settings
 */

namespace APP\plugins\generic\issuearticlesort;

use APP\template\TemplateManager;
use PKP\form\Form;

class IssuearticlesortSettingsForm extends Form
{
    /** @var int */
    public $_journalId;

    /** @var object */
    public $_plugin;

    /**
     * Constructor
     *
     * @param IssuearticlesortPlugin $plugin
     * @param int $journalId
     */
    public function __construct($plugin, $journalId)
    {
        $this->_journalId = $journalId;
        $this->_plugin = $plugin;

        parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));

        $this->addCheck(new \PKP\form\validation\FormValidator($this, 'sortOrder', 'required', 'plugins.generic.issuearticlesort.manager.settings.sortOrderRequired'));
        $this->addCheck(new \PKP\form\validation\FormValidatorPost($this));
        $this->addCheck(new \PKP\form\validation\FormValidatorCSRF($this));
    }

    /**
     * Initialize form data.
     */
    public function initData()
    {
        $this->_data = [
            'sortOrder' => $this->_plugin->getSetting($this->_journalId, 'sortOrder'),
        ];
    }

    /**
     * Assign form data to user-submitted data.
     */
    public function readInputData()
    {
        $this->readUserVars(['sortOrder']);
    }

    /**
     * @copydoc Form::fetch()
     */
    public function fetch($request, $template = null, $display = false)
    {
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->_plugin->getName());
        
        $templateMgr->assign('sortOptions', [
            'alphabetical' => 'plugins.generic.issuearticlesort.settings.alphabetical',
            'alphabetical_reverse' => 'plugins.generic.issuearticlesort.settings.alphabeticalReverse',
            'page_range' => 'plugins.generic.issuearticlesort.settings.pageRange',
            'date_published' => 'plugins.generic.issuearticlesort.settings.datePublished',
            'date_published_reverse' => 'plugins.generic.issuearticlesort.settings.datePublishedReverse',
        ]);
        
        return parent::fetch($request, $template, $display);
    }

    /**
     * @copydoc Form::execute()
     */
    public function execute(...$functionArgs)
    {
        $this->_plugin->updateSetting($this->_journalId, 'sortOrder', $this->getData('sortOrder'), 'string');
        parent::execute(...$functionArgs);
    }
}
