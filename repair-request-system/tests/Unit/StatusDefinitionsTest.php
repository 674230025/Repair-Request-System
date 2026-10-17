<?php

namespace Tests\Unit;

use App\Models\RepairRequest;
use PHPUnit\Framework\TestCase;

class StatusDefinitionsTest extends TestCase
{
    public function test_each_repair_status_has_a_thai_label(): void
    {
        $this->assertArrayHasKey('pending', RepairRequest::STATUSES);
        $this->assertArrayHasKey('completed', RepairRequest::STATUSES);
        $this->assertArrayHasKey('cancelled', RepairRequest::STATUSES);
        $this->assertNotEmpty(RepairRequest::STATUSES['pending']);
    }
}
