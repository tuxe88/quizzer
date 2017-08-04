<?php

namespace tests\AppBundle\Model;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TextFormatterTest extends WebTestCase
{
   public function testFormatEmptyText()
    {
        $tf = new \AppBundle\Model\TextFormatter("");
        $result = $tf->separateParagraphs("");

        // assert that your calculator added the numbers correctly!
        $this->assertEquals("", "dd");

    }
}