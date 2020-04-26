<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactMessagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function testItCreatesContactMessage()
    {
        $name = 'Donald Duck';
        $email = 'donald@disney.com';
        $subject = 'Test Subject';
        $message = 'Test message.';
        $response = $this->postJson('/api/contact', [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully created contact message.'
            ]);
    }
}
