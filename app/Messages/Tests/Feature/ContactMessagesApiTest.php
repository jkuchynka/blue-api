<?php

namespace App\Messages\Tests\Feature;

use App\Messages\Http\Controllers\ContactMessageController;
use App\Messages\Http\Queries\ContactMessageQuery;
use App\Messages\Mail\ContactMessageMail;
use App\Messages\Models\ContactMessage;
use Base\Tests\TestCase;
use Base\Tests\Traits\TestsApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class ContactMessagesApiTest extends TestCase
{
    use RefreshDatabase,
        TestsApi;

    /**
     * @var string[]
     */
    protected $loadModules = ['messages'];

    protected function responseFields()
    {
        return [
            'id',
            'name',
            'email',
            'message',
            'created_at',
            'updated_at'
        ];
    }

    protected function controller()
    {
        return ContactMessageController::class;
    }

    protected function model()
    {
        return ContactMessage::class;
    }

    protected function queryBuilder()
    {
        return ContactMessageQuery::for(ContactMessage::class);
    }

    /**
     * Test the basic index api
     */
    public function test_index()
    {
        $this->assertApiIndex('messages.contactMessages.index');
    }

    /**
     * Test that the index api filters correct fields
     */
    public function test_index_filters_fields()
    {
        $this->assertApiIndexFilters('messages.contactMessages.index');
    }

    /**
     * Test that the index api searches across fields
     */
    public function test_index_searches_fields()
    {
        $this->assertApiIndexSearches('messages.contactMessages.index');
    }

    /**
     * Test that the index api sorts fields
     */
    public function test_index_sorts_by_fields()
    {
        $this->assertApiIndexSorts('messages.contactMessages.index');
    }

    /**
     * Test that the index api paginates fields
     */
    public function test_index_paginates_fields()
    {
        $this->assertApiIndexPaginates('messages.contactMessages.index');
    }

    /**
     * Test that the store api successfully creates record.
     */
    public function test_store_success()
    {
        Mail::fake();

        $this->assertApiStoreSuccess('messages.contactMessages.store');

        $messages = app('modules')->getModule('messages');
        $emails = [];
        foreach ($messages['contactMessageEmailTo'] as $to) {
            $emails[] = $to;
        }
        Mail::assertSent(ContactMessageMail::class, function ($mail) use ($emails) {
            return $mail->hasTo($emails);
        });
    }

    /**
     * Test that the show api successfully returns record.
     */
    public function test_show()
    {
        $this->assertApiShow('messages.contactMessages.show');
    }

    /**
     * Test that the show api returns 404 if record not found.
     */
    public function test_show_returns_404()
    {
        $this->assertApiShow404('messages.contactMessages.show');
    }

    /**
     * Test that the update api successfully updates record.
     */
    public function test_update_success()
    {
        $this->assertApiUpdateSuccess('messages.contactMessages.update', 'email', 'foobar@mail.net');
    }

    /**
     * Test that the destroy api successfully deletes record.
     */
    public function test_delete_success()
    {
        $this->assertApiDestroySuccess('messages.contactMessages.destroy', true);
    }

    /**
     * Test that the destroy many api successfully deletes records.
     */
    public function test_delete_many_success()
    {
        $this->assertApiDestroyManySuccess('messages.contactMessages.destroyMany', true);
    }
}
