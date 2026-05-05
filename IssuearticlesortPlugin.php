<?php

/**
 * @file plugins/generic/issuearticlesort/IssuearticlesortPlugin.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class IssuearticlesortPlugin
 *
 * @brief Plugin to sort articles in each issue.
 */

namespace APP\plugins\generic\issuearticlesort;

use APP\core\Application;
use APP\template\TemplateManager;
use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use PKP\core\JSONMessage;

class IssuearticlesortPlugin extends GenericPlugin
{
    /**
     * @copydoc Plugin::register()
     */
    public function register($category, $path, $mainContextId = null)
    {
        $success = parent::register($category, $path, $mainContextId);
        if ($success && $this->getEnabled($mainContextId)) {
            Hook::add('TemplateManager::display', [$this, 'sortArticles']);
        }
        return $success;
    }

    /**
     * @copydoc Plugin::getDisplayName()
     */
    public function getDisplayName()
    {
        return __('plugins.generic.issuearticlesort.displayName');
    }

    /**
     * @copydoc Plugin::getDescription()
     */
    public function getDescription()
    {
        return __('plugins.generic.issuearticlesort.description');
    }

    /**
     * @copydoc Plugin::getActions()
     */
    public function getActions($request, $verb)
    {
        $router = $request->getRouter();
        return array_merge(
            $this->getEnabled() ? [
                new LinkAction(
                    'settings',
                    new AjaxModal(
                        $router->url($request, null, null, 'manage', null, ['verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic']),
                        $this->getDisplayName()
                    ),
                    __('manager.plugins.settings'),
                    null
                ),
            ] : [],
            parent::getActions($request, $verb)
        );
    }

    /**
     * @copydoc Plugin::manage()
     */
    public function manage($args, $request)
    {
        switch ($request->getUserVar('verb')) {
            case 'settings':
                $context = $request->getContext();
                $templateMgr = TemplateManager::getManager($request);

                $form = new IssuearticlesortSettingsForm($this, $context->getId());

                if ($request->getUserVar('save')) {
                    $form->readInputData();
                    if ($form->validate()) {
                        $form->execute();
                        return new JSONMessage(true);
                    }
                } else {
                    $form->initData();
                }
                return new JSONMessage(true, $form->fetch($request));
        }
        return parent::manage($args, $request);
    }

    /**
     * Hook callback to sort articles.
     */
    public function sortArticles($hookName, $args)
    {
        $templateMgr = $args[0];
        $template = $args[1];

        if ($template !== 'frontend/pages/issue.tpl') {
            return false;
        }

        $publishedSubmissions = $templateMgr->getTemplateVars('publishedSubmissions');
        if (empty($publishedSubmissions)) {
            return false;
        }

        $request = Application::get()->getRequest();
        $context = $request->getContext();
        if (!$context) return false;
        
        $sortOrder = $this->getSetting($context->getId(), 'sortOrder');

        if (!$sortOrder) {
            return false;
        }

        foreach ($publishedSubmissions as $sectionId => &$sectionData) {
            if (!empty($sectionData['articles'])) {
                usort($sectionData['articles'], function ($a, $b) use ($sortOrder) {
                    $publicationA = $a->getCurrentPublication();
                    $publicationB = $b->getCurrentPublication();
                    
                    if (!$publicationA || !$publicationB) return 0;

                    switch ($sortOrder) {
                        case 'alphabetical':
                            return strcasecmp($publicationA->getLocalizedTitle() ?? '', $publicationB->getLocalizedTitle() ?? '');
                        case 'alphabetical_reverse':
                            return strcasecmp($publicationB->getLocalizedTitle() ?? '', $publicationA->getLocalizedTitle() ?? '');
                        case 'page_range':
                            $aPages = $publicationA->getData('pages');
                            $bPages = $publicationB->getData('pages');
                            preg_match('/\d+/', $aPages ?? '', $aMatches);
                            preg_match('/\d+/', $bPages ?? '', $bMatches);
                            $aStart = isset($aMatches[0]) ? (int)$aMatches[0] : 0;
                            $bStart = isset($bMatches[0]) ? (int)$bMatches[0] : 0;
                            return $aStart - $bStart;
                        case 'date_published':
                            $dateA = $publicationA->getData('datePublished');
                            $dateB = $publicationB->getData('datePublished');
                            return strtotime($dateA ?? '0') - strtotime($dateB ?? '0');
                        case 'date_published_reverse':
                            $dateA = $publicationA->getData('datePublished');
                            $dateB = $publicationB->getData('datePublished');
                            return strtotime($dateB ?? '0') - strtotime($dateA ?? '0');
                    }
                    return 0;
                });
            }
        }

        $templateMgr->assign('publishedSubmissions', $publishedSubmissions);

        return false;
    }
}
