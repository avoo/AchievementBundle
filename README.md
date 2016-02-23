EloBundle
=====================
[![Build Status]
(https://scrutinizer-ci.com/g/avoo/AchievementBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/avoo/AchievementBundle/build-status/master)
[![Scrutinizer Code Quality]
(https://scrutinizer-ci.com/g/avoo/AchievementBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/avoo/AchievementBundle/?branch=master)
[![Latest Stable Version]
(https://poser.pugx.org/avoo/achievement-bundle/v/stable.svg)](https://packagist.org/packages/avoo/achievement-bundle)
[![License]
(https://poser.pugx.org/avoo/achievement-bundle/license.svg)](https://packagist.org/packages/avoo/achievement-bundle)

Achievement bundle for Symfony 2 

* [Installation](#installation)
* [Configuration](#default-configuration)
* [Class implementation](#class-implementation)
  - [Elo player class](#elo-player-class)
  - [Elo versus class](#elo-versus-class)
  - [User class](#user-class)
* [Default Usage](#default-usage)

Installation
------------

Require [`avoo/achievement-bundle`](https://packagist.org/packages/avoo/achievement-bundle) into your `composer.json` file:

``` json
{
    "require": {
        "avoo/achievement-bundle": "~1.0"
    }
}
```

Register the bundle in `app/AppKernel.php`:

``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Avoo\AchievementBundle\AvooAchievementBundle(),
    );
}
```

Default Configuration
-----------------------

#### User class

You need to implement `Avoo\AchievementBundle\Model\UserInterface`, consider the user class in `AppBundle\Entity\User`.

for FOS example:

``` php
<?php

namespace AppBundle\Entity;

use Avoo\AchievementBundle\Model\UserInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var array $achievements
     */
    protected $achievements;

    /**
     * {@inheritdoc}
     */
    public function getAchievements()
    {
        return $this->achievements;
    }
}
```

#### User Achievement class

**Class**

``` php
<?php

namespace AppBundle\Entity;

use Avoo\AchievementBundle\Entity\UserAchievement as BaseUserAchievement;
use Avoo\AchievementBundle\Model\UserInterface;

/**
 * Class UserAchievement
 */
class UserAchievement extends BaseUserAchievement
{
    /**
     * @var UserInterface $user
     */
    protected $user;
}

```

#### Doctrine configuration

And now linked the user achievement class with your own user class.

**YML**

``` yml
# src/AppBundle/Resources/config/doctrine/UserAchievement.orm.yml
AppBundle\Entity\UserAchievement:
    type:  entity
    repositoryClass: Avoo\AchievementBundle\Repository\UserAchievementRepository 
    table: avoo_user_achievement
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    manyToOne:
        user:
            targetEntity: AppBundle\Entity\User
            joinColumn:
                name: user_id
                referencedColumnName: id
                nullable: false
```

**XML**

``` xml
<?xml version="1.0" encoding="utf-8"?>
<!-- src/AppBundle/Resources/config/doctrine/UserAchievement.orm.xml -->
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                  http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="AppBundle\Entity\UserAchievement" table="avoo_user_achievement" repository-class="Avoo\AchievementBundle\Repository\UserAchievementRepository">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO"/>
        </id>

        <many-to-one target-entity="AppBundle\Entity\User" field="user">
            <join-column name="user_id" nullable="false" />
        </many-to-one>
    </entity>

</doctrine-mapping>
```

**Annotation**

``` php
namespace Avoo\EloBundle\Entity;

use Avoo\AchievementBundle\Entity\UserAchievement as BaseUserAchievement;
use Doctrine\ORM\Mapping as ORM;

class UserAchievement extends BaseUserAchievement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserAchievement")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
}
```

#### Achievement configuration

Define the user achievement class

``` yaml
# app/config/config.yml

avoo_achievement:
    user_achievement_class: AppBundle\Entity\UserAchievement
```

**Add achievement**

``` yaml
# app/config/config.yml
avoo_achievement:
    achievements:
        my_category: # it's the category of achievements
            my_super_achievement:
                class: AppBundle\Listener\SuperAchievementListener #The class handle the event.
                name: Test #Achievement name (Use the real name or the translate file, ex: achievement.global.my_super_achievement.name).
                value: 3 #The value for unlock achievement, must be an integer or float.
                description: My super description #Optional field. The achievement description, you can use the translation file.
                image: bundles/app/images/my_beautiful_image.png #Optional field.
            mega_achievement:
                class: AppBundle\Listener\OtherListener
                name: achievement.my_super_achievement.mega_achievement.name
                description: achievement.my_super_achievement.mega_achievement.description
                value: 100
        other_category:
            mega_achievement:
                class: AppBundle\Listener\OtherListener
                name: Achievement name
                value: 50
```

Class implementation
--------------------

#### Achievement listener example

``` php
<?php

namespace AppBundle\Listener;

use Avoo\AchievementBundle\Listener\AchievementListener;

/**
 * Class SuperAchievementListener
 *
 */
class SuperAchievementListener extends AchievementListener
{
}

```

That's all.

Default Usage
-------------

**Be careful, if you want to see the achievement progress, you need to be logged!**

You can use the default achievement rendering in your views:

``` twig
{{ render(controller('AvooAchievementBundle:Achievement:overview')) }} {# List all achievements #}

{{ render(controller('AvooAchievementBundle:Achievement:categories')) }} {# List of achievements categories #}

{{ render(controller('AvooAchievementBundle:Achievement:achievementsByCategory', {'category' : 'my_category'})) }} {# All achievements for unique category #}

{{ render(controller('AvooAchievementBundle:Achievement:locked')) }} {# Locked achievements #}

{{ render(controller('AvooAchievementBundle:Achievement:inProgress')) }} {# Achievements in progress #}

{{ render(controller('AvooAchievementBundle:Achievement:unlocked')) }} {# Unlocked achievements #}

{{ render(controller('AvooAchievementBundle:Achievement:latest', {'limit', 2})) }} {# The last earned achievements (limit is optional) #}

{{ render(controller('AvooAchievementBundle:Achievement:earnedByCategory')) }} {# The list of earned achievements by categories #}
```

Default Progression
-------------

Progress example:
``` php
public function indexAction(Request $request)
{
    $this->get('avoo_achievement')->get('my_category.my_super_achievement')->progress(2);
}
```

Check if current achievement is earned:
``` php
public function indexAction(Request $request)
{
    $this->get('avoo_achievement')->get('my_category.my_super_achievement')->isComplete();
}
```

Achievement validation, you can implement your ow, validation process with `isValid` function in your listener class:
``` php
<?php

namespace AppBundle\Listener;

use Avoo\AchievementBundle\Listener\AchievementListener;

/**
 * Class SuperAchievementListener
 *
 */
class SuperAchievementListener extends AchievementListener
{
    public function isValid($object = null)
    {
        //My validation process
    }
}

```

And now call:

``` php
public function indexAction(Request $request)
{
    $listener = $this->get('avoo_achievement')->get('my_category.my_super_achievement');
    if ($listener->isValid()) {
        $listener->progress(1);
    }
}
```

Or override `progress` function:
``` php
<?php

namespace AppBundle\Listener;

use Avoo\AchievementBundle\Listener\AchievementListener;

/**
 * Class SuperAchievementListener
 *
 */
class SuperAchievementListener extends AchievementListener
{
    public function progress($value)
    {
        //My progress process
    }
}

```

License
-------

This bundle is released under the MIT license. See the complete license in the bundle:

[License](https://github.com/avoo/AchievementBundle/blob/master/LICENSE)
