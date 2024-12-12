<?php

namespace Tests\Feature\Contact;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactUpdateTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_updateContact_without_beingAuthenticated_returnsUnauthorized(): void
    {
        // Arrange
        Contact::truncate();
        $telefone = sprintf("(%02d) %05d-%04d",
            $this->faker->numberBetween(10, 99),
            $this->faker->numberBetween(10000, 99999),
            $this->faker->numberBetween(1000, 9999)
        );
        $data = [
            'nome' => $this->faker->name,
            'email' => $this->faker->email,
            'telefone' => $telefone,
        ];
        $id = rand(1, 100);
        // Act
        $response = $this->putJson('api/contact/update/' . $id, $data);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertUnauthorized();
    }
    public function test_updateContact_with_beingAuthenticated_onInvalidData_rreturnsNotFound(): void
    {
        // Arrange
        Contact::truncate();
        User::truncate();
        $user = User::factory()->createOne();
        $this->actingAs($user, 'jwt');
        $telefone = sprintf("(%02d) %05d-%04d",
            $this->faker->numberBetween(10, 99),
            $this->faker->numberBetween(10000, 99999),
            $this->faker->numberBetween(1000, 9999)
        );
        $data = [
            'nome' => $this->faker->name,
            'email' => $this->faker->email,
            'telefone' => $telefone,
        ];
        $id = rand(1, 100);
        // Act
        $response = $this->putJson('api/contact/update/' . $id, $data);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertNotFound();
    }
    public function test_updateContact_with_beingAuthenticated_onValidData_returnsOk(): void
    {
        // Arrange
        Contact::truncate();
        User::truncate();
        $user = User::factory()->createOne();
        $this->actingAs($user, 'jwt');
        $telefone = sprintf("(%02d) %05d-%04d",
            $this->faker->numberBetween(10, 99),
            $this->faker->numberBetween(10000, 99999),
            $this->faker->numberBetween(1000, 9999)
        );
        $data = [
            'nome' => $this->faker->name,
            'email' => $this->faker->email,
            'telefone' => $telefone,
        ];
        $contact = Contact::factory()->createOne();
        // Act
        $response = $this->putJson('api/contact/update/' . $contact->id, $data);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertOk();
        $this->assertEquals($data['nome'], $responseBody['data']['nome']);
        $this->assertEquals($data['email'], $responseBody['data']['email']);
        $this->assertEquals($data['telefone'], $responseBody['data']['telefone']);
        $this->assertDatabaseHas('contacts', $data);
        $this->assertDatabaseHas('contacts', [
            'atualizado_em' => now()->format('Y-m-d H:i:s')
        ]);
    }
}
