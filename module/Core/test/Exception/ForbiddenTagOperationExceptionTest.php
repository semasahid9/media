<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Core\Exception;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Core\Exception\ForbiddenTagOperationException;

class ForbiddenTagOperationExceptionTest extends TestCase
{
    #[Test, DataProvider('provideExceptions')]
    public function createsExpectedExceptionForDeletion(
        ForbiddenTagOperationException $e,
        string $expectedMessage,
    ): void {
        $this->assertExceptionShape($e, $expectedMessage);
    }

    private function assertExceptionShape(ForbiddenTagOperationException $e, string $expectedMessage): void
    {
        self::assertEquals($expectedMessage, $e->getMessage());
        self::assertEquals($expectedMessage, $e->getDetail());
        self::assertEquals('Forbidden tag operation', $e->getTitle());
        self::assertEquals('https://shlink.io/api/error/forbidden-tag-operation', $e->getType());
        self::assertEquals(403, $e->getStatus());
    }

    public static function provideExceptions(): iterable
    {
        yield 'deletion' => [ForbiddenTagOperationException::forDeletion(), 'You are not allowed to delete tags'];
        yield 'renaming' => [ForbiddenTagOperationException::forRenaming(), 'You are not allowed to rename tags'];
    }
}
