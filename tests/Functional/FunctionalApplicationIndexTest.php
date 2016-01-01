<?php

class FunctionalApplicationIndexTest extends \TestCase
{
    public function testVisitIndexRender()
    {
        $this->visit('/')
            ->see('サンプルアプリケーションについて')
            ->see('MailCatcher')
            ->see('URIガイド');
        $this->assertViewHas('list');
    }
}
