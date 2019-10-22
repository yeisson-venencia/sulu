<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\AdminBundle\Admin\Navigation;

class NavigationItem implements \Iterator
{
    /**
     * The id of the NavigationItem.
     *
     * @var string
     */
    protected $id;

    /**
     * The name being displayed in the navigation.
     *
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * The icon of the navigationItem.
     *
     * @var string
     */
    protected $icon;

    /**
     * @var string
     */
    protected $view;

    /**
     * @var string[]
     */
    protected $childViews = [];

    /**
     * Will be used for a custom behaviour of the navigation item.
     *
     * @var string
     */
    private $event;

    /**
     * The event arguments.
     *
     * @var string
     */
    private $eventArguments;

    /**
     * Contains the children of this item, which are other NavigationItems.
     *
     * @var array
     */
    protected $children = [];

    /**
     * The title of the head area of the NavigationItem.
     *
     * @var string
     */
    protected $headerTitle;

    /**
     * The icon of the header are of the NavigationItem.
     *
     * @var string
     */
    protected $headerIcon;

    /**
     * The current position of the iterator.
     *
     * @var int
     */
    protected $position;

    /**
     * Defines if this menu item has settings.
     *
     * @var bool
     */
    protected $hasSettings;

    /**
     * Describes how the navigation item should be shown in husky.
     *
     * @var string
     */
    protected $displayOption;

    /**
     * Defines if item is disabled.
     *
     * @var bool
     */
    protected $disabled;

    /**
     * @param string $name The name of the item
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->disabled = false;
    }

    /**
     * Sets the id of the NavigationItem.
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the id of the NavigationItem.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the name being displayed in the navigation.
     *
     * @param string $name The name being displayed in the navigation
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name being displayed in the navigation.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setLabel(string $label = null): void
    {
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Set the icon of the NavigaitonItem.
     *
     * @param string $icon The icon of the NavigationItem
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * Returns the icon of the NavigationItem.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    public function setView(string $view = null): void
    {
        $this->view = $view;
    }

    public function getView(): ?string
    {
        return $this->view;
    }

    public function setChildViews(array $childViews): void
    {
        $this->childViews = $childViews;
    }

    public function addChildView(string $childView): void
    {
        $this->childViews[] = $childView;
    }

    /**
     * @return string[]
     */
    public function getChildViews(): array
    {
        return $this->childViews;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getEventArguments()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEventArguments($eventArguments)
    {
        $this->eventArguments = $eventArguments;
    }

    /**
     * Adds a child to the navigation item.
     *
     * @param NavigationItem $child
     */
    public function addChild(self $child)
    {
        $this->children[] = $child;
    }

    /**
     * Returns all children from this navigation item.
     *
     * @return self[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Sets the icon of the header.
     *
     * @param string $headerIcon
     */
    public function setHeaderIcon($headerIcon)
    {
        $this->headerIcon = $headerIcon;
    }

    /**
     * Returns the icon of the header.
     *
     * @return string
     */
    public function getHeaderIcon()
    {
        return $this->headerIcon;
    }

    /**
     * Sets the title of the header.
     *
     * @param string $headerTitle The title of the header
     */
    public function setHeaderTitle($headerTitle)
    {
        $this->headerTitle = $headerTitle;
    }

    /**
     * Returns the title of the header.
     *
     * @return string The title of the header
     */
    public function getHeaderTitle()
    {
        return $this->headerTitle;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Checks if the NavigationItem has some children.
     *
     * @return bool True if the item has children, otherwise false
     */
    public function hasChildren()
    {
        return count($this->getChildren()) > 0;
    }

    /**
     * @param bool $hasSettings
     */
    public function setHasSettings($hasSettings)
    {
        $this->hasSettings = $hasSettings;
    }

    /**
     * @return bool
     */
    public function getHasSettings()
    {
        return $this->hasSettings;
    }

    /**
     * @param bool $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    /**
     * @return bool
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Returns a copy of this navigation item without its children.
     *
     * @return NavigationItem
     */
    public function copyChildless()
    {
        $new = $this->copyWithName();
        $new->setView($this->getView());
        $new->setChildViews($this->getChildViews());
        $new->setEvent($this->getEvent());
        $new->setEventArguments($this->getEventArguments());
        $new->setIcon($this->getIcon());
        $new->setHeaderIcon($this->getHeaderIcon());
        $new->setHeaderTitle($this->getHeaderTitle());
        $new->setId($this->getId());
        $new->setHasSettings($this->getHasSettings());
        $new->setPosition($this->getPosition());
        $new->setLabel($this->getLabel());

        return $new;
    }

    /**
     * Create a new instance of current navigation item class.
     *
     * @return NavigationItem
     */
    protected function copyWithName()
    {
        return new self($this->getName());
    }

    /**
     * Compares this item with another one, but doesn't check the children.
     *
     * @param NavigationItem $other The other NavigationItem of the comparison
     *
     * @return bool True if the NavigationItems are equal, otherwise false
     */
    public function equalsChildless(self $other)
    {
        return $this->getName() == $other->getName();
    }

    /**
     * Searches for the equivalent of a specific NavigationItem.
     *
     * @param NavigationItem $navigationItem The NavigationItem to look for
     *
     * @return NavigationItem The item if it is found, otherwise false
     */
    public function find($navigationItem)
    {
        $stack = [$this];
        while (!empty($stack)) {
            /** @var NavigationItem $item */
            $item = array_pop($stack);
            if ($item->equalsChildless($navigationItem)) {
                return $item;
            }
            foreach ($item->getChildren() as $child) {
                /* @var NavigationItem $child */
                $stack[] = $child;
            }
        }

        return;
    }

    /**
     * Searches for a specific NavigationItem in the children of this NavigationItem.
     *
     * @param NavigationItem $navigationItem The navigationItem we look for
     *
     * @return NavigationItem|null Null if the NavigationItem is not found, otherwise the found NavigationItem
     */
    public function findChildren(self $navigationItem)
    {
        foreach ($this->getChildren() as $child) {
            /** @var NavigationItem $child */
            if ($child->equalsChildless($navigationItem)) {
                return $child;
            }
        }

        return;
    }

    /**
     * Return the current element.
     *
     * @see http://php.net/manual/en/iterator.current.php
     *
     * @return mixed Can return any type
     */
    public function current()
    {
        return $this->children[$this->position];
    }

    /**
     * Move forward to next element.
     *
     * @see http://php.net/manual/en/iterator.next.php
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element.
     *
     * @see http://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid.
     *
     * @see http://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure
     */
    public function valid()
    {
        return $this->position < count($this->children);
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Returns the content of the NavigationItem as array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = [
            'title' => $this->getName(),
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
            'view' => $this->getView(),
            'event' => $this->getEvent(),
            'eventArguments' => $this->getEventArguments(),
            'hasSettings' => $this->getHasSettings(),
            'disabled' => $this->getDisabled(),
            'id' => (null != $this->getId()) ? $this->getId() : str_replace('.', '', uniqid('', true)), //FIXME don't use uniqid()
        ];

        if (count($this->getChildViews()) > 0) {
            $array['childViews'] = $this->getChildViews();
        }

        if (null != $this->getHeaderIcon() || null != $this->getHeaderTitle()) {
            $array['header'] = [
                'title' => $this->getHeaderTitle(),
                'logo' => $this->getHeaderIcon(),
            ];
        }

        $children = $this->getChildren();

        usort(
            $children,
            function(NavigationItem $a, NavigationItem $b) {
                $aPosition = $a->getPosition() ?? PHP_INT_MAX;
                $bPosition = $b->getPosition() ?? PHP_INT_MAX;

                return $aPosition - $bPosition;
            }
        );

        foreach ($children as $key => $child) {
            /* @var NavigationItem $child */
            $array['items'][$key] = $child->toArray();
        }

        return $array;
    }
}