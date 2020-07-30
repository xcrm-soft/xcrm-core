<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Media;

class ImageUploadBehavior extends FileUploadBehavior
{
    public function getImage($attribute, $options = [])
    {
        if ($attribute === $this->attribute) {
            return $this->app->view->html::img($this->getFileUrl($this->attribute), array_merge([
                'alt' => $this->altAttribute ? $this->owner->i18n->{$this->altAttribute} : null
            ], $options));
        }
    }
}