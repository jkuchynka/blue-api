<?php

namespace App\Messages\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Base\Tests\TestCase;
use Base\Tests\Traits\ProvidesModel;
use App\Messages\ContactMessage;
use App\Messages\ContactMessagesController;

class ContactMessagseApiTest extends TestCase
{
    use RefreshDatabase,
        ProvidesModel;

    protected $loadModules = ['messages'];

    /**
     * Return the model under test
     *
     * @return Model
     */
    protected function model()
    {
        return ContactMessage::class;
    }

    /**
     * Return the fields that should be in responses
     *
     * @return array
     */
    protected function responseFields()
    {
        return [
            'id',
            'email',
            'name',
            'subject',
            'message',
            'created_at',
            'updated_at'
        ];
    }

    public function test_index()
    {
        $route = route('messages.contacts.index');

        $this->assertApiIndex($route, $this->getModel(), $this->responseFields());
    }

    /**
     * Test that the store api returns a validation
     * errors response with an invalid field.
     */
    public function test_store_validates()
    {
        $route = route('messages.contacts.store');

        $this->assertApiStoreValidates($route, 'email', $this->getModel());
    }

    /**
     * Test that the store api successfully creates record.
     */
    public function test_store_success()
    {
        $route = route('messages.contacts.store');

        $this->assertApiStoreSuccess($route, $this->getModel(), $this->responseFields());
    }
}
