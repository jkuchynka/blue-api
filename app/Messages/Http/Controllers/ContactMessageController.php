<?php

namespace App\Messages\Http\Controllers;

use App\Messages\Mail\ContactMessageMail;
use App\Messages\Models\ContactMessage;
use App\Messages\Http\Queries\ContactMessageQuery;
use App\Messages\Http\Requests\ContactMessageDeleteManyRequest;
use App\Messages\Http\Requests\ContactMessageDeleteRequest;
use App\Messages\Http\Requests\ContactMessageStoreRequest;
use App\Messages\Http\Requests\ContactMessageUpdateRequest;
use App\Messages\Http\Resources\ContactMessageCollection;
use App\Messages\Http\Resources\ContactMessageResource;
use Base\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ContactMessageCollection
     */
    public function index()
    {
        return new ContactMessageCollection(
            ContactMessageQuery::for(ContactMessage::class)->jsonPaginate()
        );
    }

    /**
     * Store a contact message.
     *
     * @param ContactMessageStoreRequest $request
     * @return ContactMessageResource
     */
    public function store(ContactMessageStoreRequest $request)
    {
        $data = $request->validated();

        $contactMessage = ContactMessage::create($data);

        // Send emails about this message
        $messages = app('modules')->getModule('messages');
        $emails = [];
        foreach ($messages['contactMessageEmailTo'] as $email) {
            $emails[] = ['email' => $email];
        }
        Mail::to(
            $emails
        )->send(new ContactMessageMail($contactMessage));

        return new ContactMessageResource($contactMessage);
    }

    /**
     * Show a contact message.
     *
     * @param ContactMessage $contactMessage
     * @return ContactMessageResource
     */
    public function show(ContactMessage $contactMessage)
    {
        return new ContactMessageResource($contactMessage);
    }

    /**
     * Update a contact message.
     *
     * @param ContactMessageUpdateRequest $request
     * @param ContactMessage $contactMessage
     * @return ContactMessageResource
     */
    public function update(ContactMessageUpdateRequest $request, ContactMessage $contactMessage)
    {
        $contactMessage->update($request->validated());
        return new ContactMessageResource($contactMessage);
    }

    /**
     * Delete a contact message.
     *
     * @param ContactMessageDeleteRequest $request
     * @param ContactMessage $contactMessage
     * @return JsonResponse
     */
    public function destroy(ContactMessageDeleteRequest $request, ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return response()->json([
            'success' => true,
            'message' => 'Contact message deleted.'
        ], 204);
    }

    /**
     * Delete contact messages.
     *
     * @param ContactMessageDeleteManyRequest $request
     * @return JsonResponse
     */
    public function destroyMany(ContactMessageDeleteManyRequest $request)
    {
        $data = $request->validated();
        foreach ($data['ids'] as $id) {
            $contactMessage = ContactMessage::findOrFail($id);
            $contactMessage->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Contact messages deleted.'
        ], 204);
    }
}
