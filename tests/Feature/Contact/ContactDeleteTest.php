<?php

namespace Tests\Feature\Contact;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactDeleteTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deleteContact_without_beingAuthenticated_returnsUnauthorized(): void
    {
        // Arrange
        Contact::truncate();
        $id = rand(1, 100);
        // Act
        $response = $this->deleteJson('api/contact/delete/' . $id);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertUnauthorized();
    }
    public function test_deleteContact_with_beingAuthenticated_onInvalidData_returnsNotFound(): void
    {
        // Arrange
        Contact::truncate();
        User::truncate();
        $user = User::factory()->createOne();
        $this->actingAs($user, 'jwt');
        $id = rand(1, 100);
        // Act
        $response = $this->deleteJson('api/contact/delete/' . $id);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertNotFound();
    }
    public function test_deleteContact_with_beingAuthenticated_onValidData_returnsOk(): void
    {
        // Arrange
        Contact::truncate();
        User::truncate();
        $user = User::factory()->createOne();
        $this->actingAs($user, 'jwt');
        $contact = Contact::factory()->createOne();
        // Act
        $response = $this->deleteJson('api/contact/delete/' . $contact->id);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertOk();
        $this->assertDatabaseHas('contacts', [
            'deletado_em' => now()->format('Y-m-d H:i:s')
        ]);
    }
}
