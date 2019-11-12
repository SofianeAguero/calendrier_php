<?php

namespace App\Date;

class Month
{

    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet',
        'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    public $month;
    public $year;

    /**
     * Month constructor.
     * @param int $month mois compris entre 1 et 12
     * @param int $year L'année
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
        }

        if ($year === null) {
            $year = intval(date('Y'));
        }

        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Renvoie le premier jour du mois
     * @return \DateTime
     */
    public function getStartingDay(): \DateTime
    {
        return new \DateTime("{$this->year}-{$this->month}-01");

    }

    /**
     * retourne le mois en lettre
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * renvoie le nb de semaine dans le mois
     * @return int
     */
    public function getWeeks(): int
    {
        $start = $this->getStartingDay();
        $end = (clone $start)->modify('+1 month - 1day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }

    /**
     * est ce que le J est dans le M en cours
     * @param \DateTime $date
     * @return bool
     */
    public function withinMonth(\DateTime $date): bool
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');

    }

    /**
     * renvoie le mois suivant
     * @return Month
     */
    public function nextMonth(): Month
    {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * renvoie le mois precedent
     * @return Month
     */
    public function previousMonth(): Month
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 1;
            $year -= 1;
        }
        return new Month($month, $year);
    }

}

