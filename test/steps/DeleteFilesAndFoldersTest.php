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

use de\codenamephp\installer\steps\DeleteFilesAndFolders;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DeleteFilesAndFoldersTest extends TestCase {

  private DeleteFilesAndFolders $sut;

  protected function setUp() : void {
    $filesystem = $this->createMock(Filesystem::class);

    $this->sut = new DeleteFilesAndFolders($filesystem, []);
  }

  public function testRun() : void {
    $this->sut->filesAndFoldersToDelete = ['some', 'files'];

    $filesystem = $this->createMock(Filesystem::class);
    $filesystem->expects(self::once())->method('remove')->with($this->sut->filesAndFoldersToDelete);
    $this->sut->filesystem = $filesystem;

    $this->sut->run();
  }
}
