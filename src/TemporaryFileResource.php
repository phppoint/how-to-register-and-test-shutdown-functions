<?php

declare(strict_types=1);

namespace PHPPoint\HowToRegisterAndTestShutdownFunctions;

final class TemporaryFileResource
{
    public function __construct(private string $file)
    {
        $weakThis = \WeakReference::create($this);

        register_shutdown_function(
            static function () use ($weakThis): void {
                $weakThis->get()?->delete();
            }
        );
    }

    public function __destruct()
    {
        $this->delete();
    }

    public function delete(): void
    {
        @unlink($this->file);
    }
}
