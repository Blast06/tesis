<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientDeleteMediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function client_can_delete_a_media()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function guest_cannot_delelete_media()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function client_cannot_delete_a_media_to_other_website()
    {
        $this->markTestIncomplete();
    }
}
