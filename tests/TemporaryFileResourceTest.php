<?php

declare(strict_types=1);

namespace PHPPoint\HowToRegisterAndTestShutdownFunctions;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\PhpProcess;
use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertStringContainsString;

/**
 * @internal
 * @covers \PHPPoint\HowToRegisterAndTestShutdownFunctions\TemporaryFileResource
 */
final class TemporaryFileResourceTest extends TestCase
{
    public function testFileDeletedOnGarbageCollection(): void
    {
        $file = $this->createTempFile();
        $resource = new TemporaryFileResource($file);

        unset($resource);

        assertFileDoesNotExist($file);
    }

    public function testFileDeletedOnFatalError(): void
    {
        $file = $this->createTempFile();
        $process = new PhpProcess(
            file_get_contents(__DIR__.'/fatal_error.php'),
            __DIR__,
            ['TEMP_FILE' => $file]
        );

        $process->run();

        assertStringContainsString('Fatal error: Fatal error!', $process->getOutput());
        assertFileDoesNotExist($file);
    }

    private function createTempFile(): string
    {
        return tempnam(sys_get_temp_dir(), 'test');
    }
}
