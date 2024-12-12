<?php

namespace Tests\Unit\Repositories;

use App\Core\ApplicationModels\Pagination;
use App\Core\Dtos\ContactDto;
use App\Core\Repositories\Contact\IContactRepository;
use App\Data\Repositories\Contact\ContactRepository;
use App\Http\Requests\Contact\ContactListingRequest;
use App\Models\Contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private IContactRepository $sut;

    public function test_getAllContacts_returnsPaginatedList(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $request = new ContactListingRequest();
        $pagination = new Pagination();
        $pagination->page = 1;
        $pagination->perPage = 10;
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->getAllContacts($request, $pagination);
        // Assert
        $this->assertEquals($pagination->page, $result->pagination->page);
        $this->assertEquals($pagination->perPage, $result->pagination->perPage);
        $this->assertIsArray($result->list);
        foreach ($result->list as $contact) {
            $this->assertInstanceOf(ContactDto::class, $contact);
        }
    }
    public function test_getAllContacts_usingFilterNome_returnsPaginatedist(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $contato = Contact::factory()->createOne();
        $request = new ContactListingRequest();
        $request->nome = substr($contato->nome, 0, 3);
        $pagination = new Pagination();
        $pagination->page = 1;
        $pagination->perPage = 10;
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->getAllContacts($request, $pagination);
        // Assert
        $this->assertEquals($pagination->page, $result->pagination->page);
        $this->assertEquals($pagination->perPage, $result->pagination->perPage);
        $this->assertIsArray($result->list);
        foreach ($result->list as $contact) {
            $this->assertInstanceOf(ContactDto::class, $contact);
            $this->assertStringContainsString(substr($contato['nome'], 0, 3), $contact->nome);
        }
    }
    public function test_getAllContacts_usingFilterEmail_returnsPaginatedist(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $contato = Contact::factory()->createOne();
        $request = new ContactListingRequest();
        $request->email = substr($contato->email, 0, 3);
        $pagination = new Pagination();
        $pagination->page = 1;
        $pagination->perPage = 10;
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->getAllContacts($request, $pagination);
        // Assert
        $this->assertEquals($pagination->page, $result->pagination->page);
        $this->assertEquals($pagination->perPage, $result->pagination->perPage);
        $this->assertIsArray($result->list);
        foreach ($result->list as $contact) {
            $this->assertInstanceOf(ContactDto::class, $contact);
            $this->assertStringContainsString(substr($contato['email'], 0, 3), $contact->email);
        }
    }
    public function test_getAllContacts_usingFilterTelefone_returnsPaginatedist(): void
    {
        // Arrange
        Contact::truncate();
        Contact::factory(100)->create();
        $contato = Contact::factory()->createOne();
        $request = new ContactListingRequest();
        $request->telefone = substr($contato->telefone, 0, 3);
        $pagination = new Pagination();
        $pagination->page = 1;
        $pagination->perPage = 10;
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->getAllContacts($request, $pagination);
        // Assert
        $this->assertEquals($pagination->page, $result->pagination->page);
        $this->assertEquals($pagination->perPage, $result->pagination->perPage);
        $this->assertIsArray($result->list);
        foreach ($result->list as $contact) {
            $this->assertInstanceOf(ContactDto::class, $contact);
            $this->assertStringContainsString(substr($contato['telefone'], 0, 3), $contact->telefone);
        }
    }
    public function test_getContactById_returnsContact(): void
    {
        // Arrange
        Contact::truncate();
        $contato = Contact::factory()->createOne();
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->getContactById($contato->id);
        // Assert
        $this->assertInstanceOf(ContactDto::class, $result);
        $this->assertEquals($contato->id, $result->id);
    }
    public function test_createContact_returnsContact(): void
    {
        // Arrange
        Contact::truncate();
        $contato = Contact::factory()->makeOne();
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->createContact($contato);
        // Assert
        $this->assertInstanceOf(Contact::class, $result);
        $this->assertEquals($contato->nome, $result->nome);
        $this->assertEquals($contato->email, $result->email);
        $this->assertEquals($contato->telefone, $result->telefone);
    }
    public function test_updateContact_returnsTrue(): void
    {
        // Arrange
        Contact::truncate();
        $contato = Contact::factory()->createOne();
        $contato->nome = 'Novo Nome';
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->updateContact($contato->id, $contato);
        // Assert
        $this->assertTrue($result);
    }
    public function test_deleteContact_returnsTrue(): void
    {
        // Arrange
        Contact::truncate();
        $contato = Contact::factory()->createOne();
        $this->sut = new ContactRepository();
        // Act
        $result = $this->sut->deleteContact($contato->id);
        // Assert
        $this->assertTrue($result);
    }
}
