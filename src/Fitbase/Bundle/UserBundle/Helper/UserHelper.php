<?php
namespace Fitbase\Bundle\UserBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserHelper extends \Twig_Extension implements ContainerAwareInterface
{
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('login_code', array($this, 'getCodeLogin')),
            new \Twig_SimpleFilter('first_name', array($this, 'getFirstName')),
            new \Twig_SimpleFilter('last_name', array($this, 'getLastName')),
            new \Twig_SimpleFilter('company', array($this, 'getCompanyName')),
            new \Twig_SimpleFilter('modules', array($this, 'getModulesName')),
            new \Twig_SimpleFilter('icon', array($this, 'getCodeIcon')),
            new \Twig_SimpleFilter('image', array($this, 'getCodeImage')),
            new \Twig_SimpleFilter('focus_desc', array($this, 'getFocusDescription')),
            new \Twig_SimpleFilter('focus_style', array($this, 'getFocusStyle')),
            new \Twig_SimpleFilter('recommendation1', array($this, 'getRecommendation1')),
            new \Twig_SimpleFilter('recommendation2', array($this, 'getRecommendation2')),
        );
    }

    /**
     * Generate login code
     * @param $user
     * @return string
     */
    public function getCodeLogin($user)
    {
        if (is_object($user)) {
            if (method_exists($user, 'getId')) {
                return md5(date('Yn') * $user->getId());
            }
        }
        return null;
    }

    /**
     * Get recommendations for second percentage
     * @param $percentage
     * @return string
     */
    public function getRecommendation1($percentage)
    {
        if ($percentage < 40) {
            return 'Bitte ziehen Sie die Notbremse und ändern Sie Ihren Lebensstil, bevor ernste Erkrankungen entstehen. Ihr allgemeiner Gesundheitszustand ist verbesserungswürdig, werden Sie aktiv!';
        } else if ($percentage < 76) {
            return 'Ihr Gesundheitszustand ist in Ordnung. Kleinere Beschwerden, wie Verspannungen sind normal und vergehen, wenn Sie Ihnen mit Bewegung begegnen. Bitte  werden Sie aktiv, überprüfen Sie Ihre Lebensgewohnheiten und stellen Sie ungünstige Gewohnheiten Schritt für Schritt um.';
        } else {
            return 'Ihr Gesundheitszustand ist gut und Sie haben vermutlich keine ernsten Beschwerden. Bleiben Sie aktiv, damit sich das nicht ändert!';
        }
    }

    /**
     * Get recommendations for first percentage
     * @param $percentage
     * @return string
     */
    public function getRecommendation2($percentage)
    {
        if ($percentage < 40) {
            return 'Ihre Belastung am Arbeitsplatz ist sehr hoch und Sie muten sich zu viel zu.  Ziehen Sie die Notbremse, um die Entstehung ernster Erkrankungen zu verhindern. Werden Sie aktiv und sorgen Sie für Ausgleich am Arbeitsplatz.';
        } else if ($percentage < 76) {
            return '   Ihre Belastung am Arbeitsplatz ist in Ordnung. Bitte achten Sie weiterhin gut auf sich und beobachten Sie Stressoren und wie sich diese auf Sie auswirken. Werden Sie aktiv, um die identifizierten Belastungen zu beheben.';
        } else {
            return 'Sie kommen gut mit den Anforderungen Ihres Arbeitsplaztes zurecht. Überprüfen Sie sich bitte fortlaufend und bleiben Sie aktiv, damit sich das nicht ändert!';
        }
    }

    /**
     * Get focus style
     * @param $focus
     * @return null
     */
    public function getFocusStyle($focus)
    {
        $hashmap = array(
            'sn' => 'sn',
            'mr' => 'ub',
            'ur' => 'lb',
            'ub' => 'ub',
            'lb' => 'lb',
            'au' => 'eye',
            'rs' => 'rsi',
            'th' => 'thera',
        );

        $focus = strtolower($focus);
        if (isset($hashmap[$focus])) {
            return $hashmap[$focus];
        }
        return null;
    }

    /**
     * Get focus description
     * @param $focus
     * @return null
     */
    public function getFocusDescription($focus)
    {
        $hashmap = array(
            'sn' => 'Wählen Sie diesen Bereich, wenn Sie häufig in der Schulter verspannt',
            'mr' => 'Wählen Sie diesen Bereich bei Beschwerden im mittlerem Rücken.',
            'ur' => 'Wählen Sie diesen Bereich bei Beschwerden im unterem Rücken.',
            'ub' => 'Wählen Sie diesen Bereich bei Beschwerden im mittlerem Rücken.',
            'lb' => 'Wählen Sie diesen Bereich bei Beschwerden im unterem Rücken.',
            'au' => 'Entspannungs- und Ausgleichsübungen für die Augen.',
            'rs' => 'Prävention von Hand-Arm- Beschwerden aufgrund intensiver Belastungen.',
            'th' => 'Auch Übungen mit Thera-Band® einspielen.',
        );
        $focus = strtolower($focus);
        if (isset($hashmap[$focus])) {
            return $hashmap[$focus];
        }
        return null;
    }


    /**
     * Get icon for code
     * @todo Replace hardcoded links
     * @param $code
     * @return null
     */
    public function getCodeIcon($code)
    {
        $codes = array(
            'SN' => 'http://online-rueckenschule.de/wp-content/uploads/left_neck-150x150.jpg',
            'MR' => 'http://online-rueckenschule.de/wp-content/uploads/middle_middle-150x150.jpg',
            'UR' => 'http://online-rueckenschule.de/wp-content/uploads/right_lower-150x150.jpg',
            'FT' => '',
            'ST' => '',
            'LT' => '',
            'AU' => 'http://online-rueckenschule.de/wp-content/uploads/augenbewegung-150x150.jpg',
            'RS' => 'http://online-rueckenschule.de/wp-content/uploads/rf-06-150x150.png',
            'TH' => 'http://online-rueckenschule.de/wp-content/uploads/reminder_manon-mit-theraband-150x150.jpg',
        );

        if (isset($codes[$code])) {
            return $codes[$code];
        }
        return null;
    }

    /**
     * Get image for code
     * @todo Replace hardcoded links
     * @param $code
     * @return null
     */
    public function getCodeImage($code)
    {
        $codes = array(
            'SN' => 'http://online-rueckenschule.de/wp-content/uploads/left_neck.jpg',
            'MR' => 'http://online-rueckenschule.de/wp-content/uploads/middle_middle.jpg',
            'UR' => 'http://online-rueckenschule.de/wp-content/uploads/right_lower.jpg',
            'FT' => '',
            'ST' => '',
            'LT' => '',
            'AU' => 'http://online-rueckenschule.de/wp-content/uploads/augenbewegung.jpg',
            'RS' => 'http://online-rueckenschule.de/wp-content/uploads/rf-06.png',
            'TH' => 'http://online-rueckenschule.de/wp-content/uploads/reminder_manon-mit-theraband.jpg',
        );
        if (isset($codes[$code])) {
            return $codes[$code];
        }
        return null;
    }


    /**
     * Get user first name
     * @param $user
     * @return mixed
     */
    public function getFirstName($user)
    {
        return $this->container->get('user')->getUserFirstName($user);
    }

    /**
     * Get user last name
     * @param $user
     * @return mixed
     */
    public function getLastName($user)
    {
        return $this->container->get('user')->getUserLastName($user);
    }

    /**
     * Get user company name
     * @param $user
     * @return mixed
     */
    public function getCompanyName($user)
    {
        if (($company = $this->container->get('user')->getCompany($user))) {
            return $company->getName();
        }
        return null;
    }

    /**
     *
     * @param $user
     * @return mixed
     */
    public function getModulesName($user)
    {
        $result = array();
        $modules = $this->container->get('user')->getModules($user);
        if (!empty($modules) and count($modules)) {
            foreach ($modules as $module) {
                array_push($result, $module->getTitle());
            }
            return implode(', ', $result);
        }
        return;
    }


    public function getName()
    {
        return 'fitbase_user_extension';
    }
}