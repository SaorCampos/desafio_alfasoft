<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactCreateTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_createContact_without_beingAuthenticated_returnsUnauthorized(): void
    {
        // Arrange
        $data = [
            'nome' => $this->faker->name,
            'email' => $this->faker->email,
            'telefone' => $this->faker->phoneNumber,
        ];
        // Act
        $response = $this->postJson('api/contact/create', $data);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertUnauthorized();
    }
    public function test_createContact_with_beingAuthenticated_returnsOk(): void
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
        // Act
        $response = $this->postJson('api/contact/create', $data);
        $responseBody = json_decode($response->getContent(), true);
        // Assert
        $response->assertOk();
        $this->assertArrayHasKey('id', $responseBody['data']);
        $this->assertEquals($responseBody['data']['nome'], $data['nome']);
        $this->assertEquals($responseBody['data']['email'], $data['email']);
        $this->assertEquals($responseBody['data']['telefone'], $data['telefone']);
        $this->assertDatabaseHas('contacts', [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
        ]);
    }
}
