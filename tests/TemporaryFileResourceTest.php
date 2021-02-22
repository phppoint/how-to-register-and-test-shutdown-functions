<?php

declare(strict_types=1);

namespace PHPPoint\HowToRegisterAndTestShutdownFunctions;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\PhpProcess;
use function PHPUnit\Framework\assertFileDoesNotExist;

/**
 * @internal
 * @covers \PHPPoint\HowToRegisterAndTestShutdownFunctions\TemporaryFileResource
 * @group unit
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
        $process = new PhpProcess(sprintf(file_get_contents(__DIR__.'/fatal_error.php'), $file));

        $process->run();

        assertFileDoesNotExist($file);
    }

    private function createTempFile(): string
    {
        return tempnam(sys_get_temp_dir(), 'test');
    }
}
