<?php

namespace App\Messages\Tests\Unit;

use App\Messages\Http\Controllers\ContactMessageController;
use App\Messages\Http\Queries\ContactMessageQuery;
use App\Messages\Http\Requests\ContactMessageDeleteManyRequest;
use App\Messages\Http\Requests\ContactMessageDeleteRequest;
use App\Messages\Http\Requests\ContactMessageStoreRequest;
use App\Messages\Http\Requests\ContactMessageUpdateRequest;
use App\Messages\Models\ContactMessage;
use Base\Tests\TestCase;

class ContactMessageControllerTest extends TestCase
{
    public function test_index_query_filters()
    {
        $this->assertEquals([
            'id',
            'subject',
            'message',
            'name',
            'email',
            'created_at'
        ], ContactMessageQuery::for(ContactMessage::class)->filters());
    }

    public function test_index_query_sorts()
    {
        $this->assertEquals([
            'id',
            'subject',
            'name',
            'email',
            'created_at'
        ], ContactMessageQuery::for(ContactMessage::class)->sorts());
    }

    public function test_store_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            ContactMessageController::class,
            'store',
            ContactMessageStoreRequest::class
        );
    }

    public function test_store_request_rules()
    {
        $this->assertEquals([
            'email' => 'required|email',
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ], (new ContactMessageStoreRequest)->rules());
    }

    public function test_update_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            ContactMessageController::class,
            'update',
            ContactMessageUpdateRequest::class
        );
    }

    public function test_update_request_rules()
    {
        $this->assertEquals([
            'email' => 'required|email',
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ], (new ContactMessageUpdateRequest)->rules());
    }

    public function test_delete_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            ContactMessageController::class,
            'destroy',
            ContactMessageDeleteRequest::class
        );
    }

    public function test_delete_request_rules()
    {
        $this->assertEquals([], (new ContactMessageDeleteRequest)->rules());
    }

    public function test_delete_many_validates_using_form_request()
    {
        $this->assertActionUsesFormRequest(
            ContactMessageController::class,
            'destroyMany',
            ContactMessageDeleteManyRequest::class
        );
    }

    public function test_delete_many_request_rules()
    {
        $this->assertEquals([
            'ids' => 'required|array'
        ], (new ContactMessageDeleteManyRequest)->rules());
    }
}
