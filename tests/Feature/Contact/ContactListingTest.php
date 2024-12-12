<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactListingTest extends TestCase
{
    use DatabaseTransactions;

    public function test_getAllContacts_returs_paginatedList(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        // Act
        $response = $this->get(route('contact.listing', [
            'page' => 1,
            'perPage' => 10
        ]));
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure($this->jsonStructureBase);
        $this->assertEquals(10, count($responseBody['data']['list']));
        $this->assertEquals(100, $responseBody['data']['pagination']['total']);
    }
    public function test_getAllContacts_usingFilterNome_returns_paginatedList(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $contato = Contact::factory()->createOne();
        // Act
        $response = $this->get(route('contact.listing', [
            'page' => 1,
            'perPage' => 10,
            'nome' => substr($contato->nome, 0, 3)
        ]));
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure($this->jsonStructureBase);
        foreach ($responseBody['data']['list'] as $key => $value) {
            $this->assertStringContainsString(substr($contato['nome'], 0, 3), $value['nome']);
        }
    }
    public function test_getAllContacts_usingFilterEmail_returns_paginatedList(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $contato = Contact::factory()->createOne();
        // Act
        $response = $this->get(route('contact.listing', [
            'page' => 1,
            'perPage' => 10,
            'email' => $contato->email
        ]));
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure($this->jsonStructureBase);
        foreach ($responseBody['data']['list'] as $key => $value) {
            $this->assertEquals($contato['email'], $value['email']);
        }
    }
    public function test_getAllContacts_usingFilterTelefone_returns_paginatedList(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $contato = Contact::factory()->createOne();
        // Act
        $response = $this->get(route('contact.listing', [
            'page' => 1,
            'perPage' => 10,
            'telefone' => substr($contato->telefone, 0, 3)
        ]));
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure($this->jsonStructureBase);
        foreach ($responseBody['data']['list'] as $key => $value) {
            $this->assertStringContainsString(substr($contato['telefone'], 0, 3), $value['telefone']);
        }
    }
    public function test_getContactById_returnsContact(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $id = rand(1, 100);
        // Act
        $response = $this->get('api/contact/' . $id);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertStatus(200);
        $this->assertEquals($id, $responseBody['data']['id']);
    }
}
