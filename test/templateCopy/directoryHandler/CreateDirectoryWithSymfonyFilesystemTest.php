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

namespace de\codenamephp\installer\test\templateCopy\directoryHandler;

use de\codenamephp\installer\templateCopy\directoryHandler\CreateDirectoryWithSymfonyFilesystem;
use de\codenamephp\installer\templateCopy\variableReplacer\iVariableReplacer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class CreateDirectoryWithSymfonyFilesystemTest extends TestCase {

  private CreateDirectoryWithSymfonyFilesystem $sut;

  protected function setUp() : void {
    $filesystem = $this->createMock(Filesystem::class);
    $variableReplacer = $this->createMock(iVariableReplacer::class);

    $this->sut = new CreateDirectoryWithSymfonyFilesystem($filesystem, $variableReplacer);
  }

  public function testHandle() : void {
    $target = 'some target';
    $variables = ['some', 'vars'];
    $targetPath = 'some path';

    $variableReplacer = $this->createMock(iVariableReplacer::class);
    $variableReplacer->expects(self::once())->method('replace')->with($target, $variables)->willReturn($targetPath);
    $this->sut->variableReplacer = $variableReplacer;

    $filesystem = $this->createMock(Filesystem::class);
    $filesystem->expects(self::once())->method('mkdir')->with($targetPath);
    $this->sut->filesystem = $filesystem;

    $this->sut->handle($target, $variables);
  }
}
