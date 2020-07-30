<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\BackOffice\Component;
use XCrm\Application\Base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class NavigationBuilder extends Component
{
    public $defaultMenuSections = [
        'crm' => ['title' => 'CRM'],
        'content' => ['title' => 'Content'],
        'security' => ['title' => 'Security'],
        'settings' => ['title' => 'Settings'],
        'extra' => ['title' => 'Extra']
    ];

    protected $menuSections = [];

    private $_navigation = null;

    public function getSections()
    {
        $this->ensureNavigation();
        return $this->menuSections;
    }

    /**
     * @throws InvalidConfigException
     */
    protected function ensureNavigation()
    {
        if (null !== $this->_navigation) return;
        $this->_navigation = [];

        if (!is_array($this->menuSections)) {
            throw new InvalidConfigException('menuSections should contain array');
        }
        $this->menuSections = ArrayHelper::merge($this->defaultMenuSections, $this->menuSections);

        $modules = $this->app->modules;
        foreach ($modules as $id=>$module) {
            $class = is_object($module) ? get_class($module) : ($module['class'] ?? null);
            if (!method_exists($class, 'getNavigation')) continue;

            $nav = $class::getNavigation();
            if (!isset($nav['title']) || empty($nav['title'])) {
                $nav['title'] = $class::getTitle();
            }
            $this->renderNavigation($id, $nav);
        }

        $this->removeEmptySections();
    }

    protected function removeEmptySections()
    {
        foreach ($this->menuSections as $k=>$v) {
            if (!isset($v['modules']) || empty($v['modules'])) {
                unset($this->menuSections[$k]);
            }
        }
    }

    protected function renderNavigation($id, $navigation)
    {
        if (!isset($navigation['visible'])) $navigation['visible'] = true;
        if (!$navigation['visible']) return;
        if (!isset($navigation['section']) || !isset($this->menuSections[$navigation['section']])) {
            $navigation['section'] = 'content';
        }
        if (!isset($this->menuSections[$navigation['section']]['modules'])) {
            $this->menuSections[$navigation['section']]['modules'] = [];
        }

        if (isset($navigation['links'])) {
            $links = [];
            foreach ($navigation['links'] as $link) {
                if (!isset($link['visible'])) $link['visible'] = true;
                if (!$link['visible']) continue;

                if (is_array($link['url'])) {
                    if (!isset($link['url'][0])) $link['url'][0] = '/' . $id;

                    if (0 !== strpos($link['url'][0], '/')) {
                        $link['url'][0] = '/' . $id . '/' . $link['url'][0];
                    }
                } else {
                    if (0 !== strpos($link['url'], '/'))
                        $link['url'] = '/' . $id . '/' . $link['url'];
                }

                $links[] = $link;
            }

            if (!empty($links)) {
                $this->menuSections[$navigation['section']]['modules'][] = [
                    'icon'  => $navigation['icon'] ?? 'default',
                    'title' => $navigation['title'],
                    'links' => $links,
                    'id' => $id
                ];
            }

        } else {
            $this->menuSections[$navigation['section']]['modules'][] = [
                'icon'  => $navigation['icon'] ?? 'default',
                'title' => $navigation['title'],
                'url'   => ['/' . $id],
            ];
        }
    }
}