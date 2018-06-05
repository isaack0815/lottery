<?php
class Lottery
{
    private $lottotable;

    public function __construct()
    {
        $this->lottotable = isset($_SESSION["lottotabel"]) ? $_SESSION["lottotabel"] : array();
    }

    public function getLotteryTable()
    {
        return $this->lottotable;
    }

    public function addWeekTable($weektable)
    {
        $errortable = $this->checkData($weektable);

        if (empty($errortable))
        {
            $this->lottotable[] = $weektable;
            $_SESSION["lottotabel"] = $this->lottotable;
        }
        return $errortable;
    }

    private function checkData($weektable)
    {
        $errortable = array();

        foreach ($weektable as $nr => $number)
        {
            if($number < 1 || $number > 42 || $this->occurencesNumberInWeek($number, $weektable) > 1)
            {
                $errortable[] = "Foute invoer bij lottogetal".$nr;
            }
        }

        return $errortable;
    }

    private function occurencesNumberInWeek($number, $table)
    {
        $amount = 0;
        foreach ($table as $value)
        {
            if($number == $value)
            {
                $amount++;
            }
        }
        return $amount;
    }

    public function countOccurences()
    {
        //Tel het aantal voorkomens van elk lottogetal
        $voorkomens = array();
        for($lottogetal = 1; $lottogetal <= 42 ; $lottogetal++)
        {
            $voorkomens[$lottogetal] = 0;
        }

        foreach($this->lottotable as $week)
        {
            foreach($week as $lottogetal)
            {
                $voorkomens[$lottogetal]++;
            }
        }
        return $voorkomens;
    }

    public function mostOccuring($occurences)
    {
        $mostOccuring = array();

        //Zoek het grootste aantal voorkomens
        $largestAmount = max($occurences);

        //het aantal gevonden lottogetallen met het grootst aantal voorkomens
        //minstens 7 getallen
        $amountOfNumbers = 0;
        do
        {
            for($lotterynumber = 1; $lotterynumber <= 42; $lotterynumber++)
            {
                if($occurences[$lotterynumber]==$largestAmount)
                {
                    $mostOccuring[$lotterynumber] = $largestAmount;
                    $amountOfNumbers++;
                }
            }
            $largestAmount--;
        } while($amountOfNumbers < 7);

        return $mostOccuring;
    }

}