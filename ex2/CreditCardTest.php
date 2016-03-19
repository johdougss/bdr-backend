<?php
include_once 'CreditCard.php';

class CreditCardTest extends PHPUnit_Framework_TestCase
{

    function testValidNumber()
    {
        $credit_card = new CreditCard();
        $credit_card->set('4444333322221111');
        $this->assertTrue($credit_card->validCreditCard());
    }

    function testInvalidNumberShouldReturnError()
    {
        $credit_card = new CreditCard();
        $credit_card->set('3333555522221111');
        $this->assertEquals(CreditCard::ERROR_INVALID_LENGTH, $credit_card->validCreditCard());
    }

    function testValidNumberShouldSetAndGet()
    {
        $credit_card = new CreditCard();
        $credit_card->set('4444333322221111');
        $this->assertEquals('4444333322221111', $credit_card->get());
    }
}