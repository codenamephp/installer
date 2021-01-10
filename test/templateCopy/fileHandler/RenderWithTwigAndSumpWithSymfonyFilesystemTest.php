<?php declare(strict_types=1);
/**
 * Copyright 2021 Bastian Schwarz <bastian@codename-php.de>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace de\codenamephp\installer\test\templateCopy\fileHandler;

use de\codenamephp\installer\templateCopy\fileHandler\RenderWithTwigAndSumpWithSymfonyFilesystem;
use de\codenamephp\installer\templateCopy\variableReplacer\iVariableReplacer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class RenderWithTwigAndSumpWithSymfonyFilesystemTest extends TestCase {

  private RenderWithTwigAndSumpWithSymfonyFilesystem $sut;

  protected function setUp() : void {
    $filesystem = $this->createMock(Filesystem::class);
    $variableReplacer = $this->createMock(iVariableReplacer::class);
    $twig = $this->createMock(Environment::class);

    $this->sut = new RenderWithTwigAndSumpWithSymfonyFilesystem($filesystem, $variableReplacer, $twig);
  }

  public function testHandle() : void {
    $target = 'some target';
    $variables = ['some', 'vars'];
    $targetPath = 'some path';
    $templateResult = 'some output';
    $source = 'some source';

    $variableReplacer = $this->createMock(iVariableReplacer::class);
    $variableReplacer->expects(self::once())->method('replace')->with($target, $variables)->willReturn($targetPath);
    $this->sut->variableReplacer = $variableReplacer;

    $twig = $this->createMock(Environment::class);
    $twig->expects(self::once())->method('render')->with($source, $variables)->willReturn($templateResult);
    $this->sut->twig = $twig;

    $filesystem = $this->createMock(Filesystem::class);
    $filesystem->expects(self::once())->method('dumpFile')->with($targetPath, $templateResult);
    $this->sut->filesystem = $filesystem;

    $this->sut->handle($source, $target, $variables);
  }
}
