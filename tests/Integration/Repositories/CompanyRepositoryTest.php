<?php

namespace Tests\Integration\Repositories;

use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


final class CompanyRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected CompanyRepository $companyRepository;
    protected Company $company;

    protected function setUp() : void
    {
        parent::setUp();

        $this->company = Company::factory()->create();
        $this->companyRepository = new CompanyRepository($this->company);
    }

    #[Test]
    public function testAllReturnsCollectionOfRecordsSuccessfully()
    {
        $result = $this->companyRepository->all();

        $this->assertInstanceOf(Collection::class, $result);

        $this->assertGreaterThan(0, $result->count());
    }

    #[Test]
    public function testFindReturnsNullForNonExistentRecord()
    {
        $invalidId = 999;

        $result = $this->companyRepository->find($invalidId);

        $this->assertNull($result);
    }

    #[Test]
    public function testFindReturnsCompanyForExistentRecord()
    {
        $result = $this->companyRepository->find($this->company->id);

        $this->assertInstanceOf(Company::class, $result);

        $this->assertDatabaseHas('companies', $result);
    }

    #[Test]
    public function testUpdateCompanyReturnsUpdatedCompanySuccessfully()
    {
        $updatedData = [
            'name' => $this->faker->title,
            'country' => $this->faker->country,
        ];

        $result = $this->companyRepository->update($updatedData, $this->company->id);

        $this->assertInstanceOf(Company::class, $result);

        $this->assertEquals($updatedData['name'], $result->name);
        $this->assertEquals($updatedData['country'], $result->country);

        $this->assertDatabaseHas('companies',$updatedData);
    }

    #[Test]
    public function testDeleteCompanyReturnsTrueOnSuccess()
    {
        $result = $this->companyRepository->delete($this->company->id);

        $this->assertTrue($result);

        $this->assertDatabaseMissing('companies', ['id' => $this->company->id]);
    }



}
