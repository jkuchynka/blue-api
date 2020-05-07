<?php

namespace App\Messages\Tests\Unit;

use Base\Tests\TestCase;
use Base\Tests\Traits\ProvidesController;
use App\Messages\ContactMessagesController;

class ContactMessagesTest extends TestCase
{
    use ProvidesController;

    /**
     * Set the controller under test
     *
     * @return string|Base\Http\Controller
     */
    protected function controller()
    {
        return ContactMessagesController::class;
    }

    /**
     * Return validation rules that should match controller
     *
     * @param  bool|boolean $update If true, returns update rules
     * @return array
     */
    protected function rules(bool $update = false)
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ];
    }

    /**
     * Return allowed filters for index query
     *
     * @return array
     */
    protected function filters()
    {
        return [
            'id',
            'email',
            'name',
            'subject',
            'message'
        ];
    }

    /**
     * Return allowed sorts for index query
     *
     * @return array
     */
    protected function sorts()
    {
        return [
            'id',
            'email',
            'name',
            'subject'
        ];
    }

    /**
     * Test that the controller provides and matches the
     * correct validation rules for store method.
     */
    public function test_controller_has_store_rules()
    {
        $this->assertControllerHasStoreRules($this->rules(), $this->getController());
    }

    /**
     * Test that the controller provides and matches the
     * correct validation rules for update method.
     */
    public function test_controller_has_update_rules()
    {
        $this->assertControllerHasUpdateRules($this->rules(true), $this->getController());
    }

    /**
     * Test the controller provides and matches allowed filters
     * for the index query
     */
    public function test_controller_has_filters()
    {
        $this->assertControllerHasFilters($this->filters(), $this->getController());
    }

    /**
     * Test the controller provides and matches allowed sorts
     * for the index query
     */
    public function test_controller_has_sorts()
    {
        $this->assertControllerHasSorts($this->sorts(), $this->getController());
    }
}
