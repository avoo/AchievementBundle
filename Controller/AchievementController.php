<?php

namespace Avoo\AchievementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AchievementController
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
class AchievementController extends Controller
{
    /**
     * Get all categories
     *
     * @return Response
     */
    public function categoriesAction()
    {
        $achievement = $this->get('avoo_achievement');

        return $this->render('AvooAchievementBundle:Achievement:categories.html.twig', array(
            'categories' => $achievement->getCategories(),
        ));
    }

    public function achievementsByCategoryAction($category)
    {
        $achievement = $this->get('avoo_achievement');

        return $this->render('AvooAchievementBundle:Achievement:achievements.html.twig', array(
            'achievements' => $achievement->getAll($category),
            'category' => $category
        ));
    }

    /**
     * Get achievements overview
     *
     * @return Response
     */
    public function overviewAction()
    {
        $achievement = $this->get('avoo_achievement');

        return $this->render('AvooAchievementBundle:Achievement:overview.html.twig', array(
            'overview' => $achievement->getEarnedOverallAchievements(),
        ));
    }

    /**
     * Get achievements earned by categories
     *
     * @return Response
     */
    public function earnedByCategoryAction()
    {
        $achievement = $this->get('avoo_achievement');
        $earnedByCategories = array();
        foreach ($achievement->getCategories() as $category) {
            $earnedByCategories[$category] = $achievement->getEarnedOverallAchievements($category);
        }

        return $this->render('AvooAchievementBundle:Achievement:overview.html.twig', array(
            'earnedByCategories' => $earnedByCategories,
        ));
    }

    /**
     * Get locked achievements
     *
     * @return Response
     */
    public function lockedAction()
    {
        $achievement = $this->get('avoo_achievement');

        return $this->render('AvooAchievementBundle:Achievement:achievements.html.twig', array(
            'achievements' => $achievement->getLockedAchievements(),
        ));
    }

    /**
     * Get unlocked achievements
     *
     * @return Response
     */
    public function unlockedAction()
    {
        $achievement = $this->get('avoo_achievement');

        return $this->render('AvooAchievementBundle:Achievement:achievements.html.twig', array(
            'achievements' => $achievement->getUnlockedAchievements(),
        ));
    }

    /**
     * Get in prgress achievements
     *
     * @return Response
     */
    public function inProgressAction()
    {
        $achievement = $this->get('avoo_achievement');

        return $this->render('AvooAchievementBundle:Achievement:achievements.html.twig', array(
            'achievements' => $achievement->getInProgressAchievements(),
        ));
    }

    /**
     * Get latest achievements earned
     *
     * @param integer $limit
     *
     * @return Response
     */
    public function latestAction($limit = 1)
    {
        $achievement = $this->get('avoo_achievement');

        return $this->render('AvooAchievementBundle:Achievement:achievements.html.twig', array(
            'achievements' => $achievement->getLatestAchievements($limit),
        ));
    }
}
