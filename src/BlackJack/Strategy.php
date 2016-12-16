<?php

namespace BlackJack;

use NoelDavies\Cards\Card;

class Strategy
{
    public static function iShouldStand(Hand $hand, Hand $dealersHand)
    {
        $handTotal        = $hand->handTotal();
        $dealersHandTotal = $dealersHand->handTotal();

        if ($handTotal >= 17 && 20 >= $handTotal) {
            return true;
        }

        if (in_array($handTotal, [13,14,15,16]) && $dealersHandTotal >= 2 && 6 >= $dealersHandTotal) {
            return true;
        }

        if (in_array($handTotal, [12]) && $dealersHandTotal >= 4 && 6 >= $dealersHandTotal) {
            return true;
        }

        return false;
    }

    /**
     * @param Hand $hand
     * @param Hand $dealersHand
     *
     * @return bool
     */
    public static function iShouldHit(Hand $hand, Hand $dealersHand)
    {
        $handTotal        = $hand->handTotal();
        $dealersCard      = $dealersHand->cards()->first()->value();

        // should hit when my cards total 5 through 8
        if ($handTotal >= 5 && 8 >= $handTotal) {
            return true;
        }

        // should hit when my cards total 9 and the dealers card is a 2
        if ($handTotal === 9 && $dealersCard === 2) {
            return true;
        }

        // should hit when my cards total 10 and the dealers card is a 10
        if ($handTotal === 10 && $dealersCard === 10) {
            return true;
        }

        // should hit when my cards total 12 and the dealers card is 2 or 3
        if ($handTotal === 12 && in_array($dealersCard, [2,3], true)) {
            return true;
        }

        // should hit when my cards total 9 and the dealers card is between 7 and ace
        // should hit when my cards total is 13 or 14 and the dealer has between 7 and ace
        if (in_array($handTotal, [9,13,14],true) && in_array($dealersCard, [7,8,9,10,Card::JACK,Card::QUEEN,Card::KING,Card::ACE], true)) {
            return true;
        }

        // should hit when my cards total 15 and the dealer has 7 8 or 9
        if ($handTotal === 15 && in_array($dealersCard, [7,8,9], true)) {
            return true;
        }

        // should hit when my cards total 16 and the dealer has a 7 or 8
        if (in_array($handTotal, [10,11,15]) && $dealersCard === Card::ACE) {
            return true;
        }

        // should hit when my cards total 16 and the dealer has a 7 or 8
        if ($handTotal === 16 && in_array($dealersCard, [7,8], true)) {
            return true;
        }

        if (self::iShouldDouble($hand, $dealersHand)) {
            return true;
        }

        return false;
    }

    /**
     * @param Hand $hand
     * @param Hand $dealersHand
     *
     * @return bool
     */
    public static function iShouldSurrender(Hand $hand, Hand $dealersHand)
    {
        $handTotal        = $hand->handTotal();
        $dealersCard      = $dealersHand->cards()->first()->value();

        // should surrender when my cards total 16 and the dealer has a 9, 10 or ace
        if ($handTotal === 16 && in_array($dealersCard, [9,10,Card::ACE], true)) {
            return true;
        }

        if ($handTotal === 15 && $dealersCard === 10) {
            return true;
        }

        return false;
    }

    /**
     * @param Hand $hand
     * @param Hand
     *
     * @return bool
     */
    public static function iShouldDouble(Hand $hand, Hand $dealersHand)
    {
        $handTotal        = $hand->handTotal();
        $dealersHandTotal = $dealersHand->handTotal();
        $dealersCard      = $dealersHand->cards()->first()->value();

        // should double when my cards total 9 and the dealers card is between 3 and 6
        if ($handTotal === 9 && $dealersCard >= 3 && 6 >= $dealersCard) {
            return true;
        }

        // it should hit when my cards total 11 and the dealers card is 2 through 10
        if ($handTotal === 11 && $dealersCard >= 2 && 10 >= $dealersCard) {
            return true;
        }

        // should double when my cards total 11 and the dealers card is between 2 and 9
        if ($handTotal === 10 && $dealersCard >= 2 && 9 >= $dealersCard) {
            return true;
        }

        return false;
    }
}
