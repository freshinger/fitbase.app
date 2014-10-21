<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/25/14
 * Time: 11:00 AM
 */

namespace Fitbase\Bundle\UserBundle\Entity;


class UserProfile
{

    protected $id;
    protected $titel;
    protected $anrede;
    protected $vorname;
    protected $nachname;
    protected $strasse;
    protected $hausnummer;
    protected $postzahl;
    protected $ort;
    protected $phone;
    protected $handy;
    protected $email;
    protected $geburtsdatum;
    protected $showInStatistic;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $anrede
     */
    public function setAnrede($anrede)
    {
        $this->anrede = $anrede;
    }

    /**
     * @return mixed
     */
    public function getAnrede()
    {
        return $this->anrede;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $geburtsdatum
     */
    public function setGeburtsdatum($geburtsdatum)
    {
        $this->geburtsdatum = $geburtsdatum;
    }

    /**
     * @return mixed
     */
    public function getGeburtsdatum()
    {
        return $this->geburtsdatum;
    }

    /**
     * @param mixed $handy
     */
    public function setHandy($handy)
    {
        $this->handy = $handy;
    }

    /**
     * @return mixed
     */
    public function getHandy()
    {
        return $this->handy;
    }

    /**
     * @param mixed $hausnummer
     */
    public function setHausnummer($hausnummer)
    {
        $this->hausnummer = $hausnummer;
    }

    /**
     * @return mixed
     */
    public function getHausnummer()
    {
        return $this->hausnummer;
    }

    /**
     * @param mixed $nachname
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;
    }

    /**
     * @return mixed
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * @param mixed $ort
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;
    }

    /**
     * @return mixed
     */
    public function getOrt()
    {
        return $this->ort;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $postzahl
     */
    public function setPostzahl($postzahl)
    {
        $this->postzahl = $postzahl;
    }

    /**
     * @return mixed
     */
    public function getPostzahl()
    {
        return $this->postzahl;
    }

    /**
     * @param mixed $showInStatistic
     */
    public function setShowInStatistic($showInStatistic)
    {
        $this->showInStatistic = $showInStatistic;
    }

    /**
     * @return mixed
     */
    public function getShowInStatistic()
    {
        return $this->showInStatistic;
    }

    /**
     * @param mixed $strasse
     */
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;
    }

    /**
     * @return mixed
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

    /**
     * @param mixed $titel
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }

    /**
     * @return mixed
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * @param mixed $vorname
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    /**
     * @return mixed
     */
    public function getVorname()
    {
        return $this->vorname;
    }
}