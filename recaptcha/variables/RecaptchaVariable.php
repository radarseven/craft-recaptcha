<?php

namespace Craft;
/*
*
* reCaptcha for Craft Variables
* Author: Aaron Berkowitz (@asberk)
* https://github.com/aberkie/craft-recaptcha
*
*/

class RecaptchaVariable
{
    public function render($params = null)
    {
        $return = craft()->recaptcha_render->render($params);
        return $return;
    }

    /**
     * Render multiple widgets.
     * @param null $ids
     * @return bool|null|string
     */
    public function renderMultiple($ids = null)
    {
        // Make sure we're working with any array.
        if (!is_array($ids)) {
            return false;
        }

        // Plugin settings
        $settings = $this->getPluginSettings();

        // Template rendering for plugin.
        $oldTemplatesPath = craft()->path->getTemplatesPath();
        $newTemplatesPath = craft()->path->getPluginsPath() . 'recaptcha/templates/';
        craft()->path->setTemplatesPath($newTemplatesPath);

        // Template vars
        $vars = array(
            'ids'     => $ids, // HTML #ids to render the widgets in
            'siteKey' => $settings->attributes['siteKey'] // The siteKey from settings
        );

        // Rendered template
        $html = craft()->templates->render('frontend/renderMultiple.js.twig', $vars);

        // Reset template path
        craft()->path->setTemplatesPath($oldTemplatesPath);

        // Include the Google Recaptcha API file with additional querystring parameters to support explicit rendering.
        craft()->templates->includeJsFile('https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit');

        // Push rendered HTML/JS to the <head>
        craft()->templates->includeHeadHtml($html);

    }

    /**
     * Return the plugin's settings.
     * @return mixed
     */
    protected function getPluginSettings()
    {
        $plugin   = craft()->plugins->getPlugin('recaptcha');
        $settings = $plugin->getSettings();

        return $settings;
    }

}
