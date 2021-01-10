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

namespace de\codenamephp\installer\test\steps;

use de\codenamephp\installer\steps\CreateFolders;
use de\codenamephp\installer\templateCopy\variableReplacer\iVariableReplacer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class CreateFoldersTest extends TestCase {

  private CreateFolders $sut;

  protected function setUp() : void {
    $variableReplacer = $this->createMock(iVariableReplacer::class);
    $filesystem = $this->createMock(Filesystem::class);

    $this->sut = new CreateFolders($variableReplacer, $filesystem, [], []);
  }

  public function testRun() : void {
    $this->sut->variables = ['some', 'vars'];
    $this->sut->folders = ['folder1', 'folder2', 'folder3'];

    $this->sut->variableReplacer = $this->createMock(iVariableReplacer::class);
    $this->sut->variableReplacer
        ->expects(self::exactly(3))
        ->method('replace')
        ->withConsecutive(
            [$this->sut->folders[0], $this->sut->variables],
            [$this->sut->folders[1], $this->sut->variables],
            [$this->sut->folders[2], $this->sut->variables],
        )
        ->willReturnOnConsecutiveCalls('replaced1', 'replaced2', 'replaced3');

    $this->sut->filesystem = $this->createMock(Filesystem::class);
    $this->sut->filesystem->expects(self::once())->method('mkdir')->with(['replaced1', 'replaced2', 'replaced3']);

    $this->sut->run();
  }
}
