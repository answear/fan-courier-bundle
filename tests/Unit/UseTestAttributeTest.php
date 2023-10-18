<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UseTestAttributeTest extends TestCase
{
    #[Test]
    public function testNoAnnotationTest(): void
    {
        $directory = __DIR__ . '/../';
        $report = [];

        $this->scanDirectory($directory, $report);

        $this->assertEmpty($report, '@test annotation found in one or more test files, please use attribute.');
    }

    private function scanDirectory($dir, &$report): void
    {
        $files = scandir($dir);

        foreach ($files as $file) {
            if ('.' !== $file && '..' !== $file) {
                $path = $dir . '/' . $file;

                if (is_dir($path)) {
                    $this->scanDirectory($path, $report);
                } elseif (is_file($path)
                    && 'php' === pathinfo($path, PATHINFO_EXTENSION)
                    && 'UseTestAttributeTest' !== pathinfo($path, PATHINFO_FILENAME)
                ) {
                    $content = file_get_contents($path);

                    if (str_contains($content, '@test')) {
                        $report[] = '@test annotation found in: ' . $path . ' file.';
                    }
                }
            }
        }
    }
}
