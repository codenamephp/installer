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

namespace de\codenamephp\installer\test\templateCopy;

use de\codenamephp\installer\templateCopy\directoryHandler\iDirectoryHandler;
use de\codenamephp\installer\templateCopy\fileHandler\iFileHandler;
use de\codenamephp\installer\templateCopy\RecursiveIterator;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class RecursiveIteratorTest extends TestCase {

  private RecursiveIterator $sut;

  protected function setUp() : void {
    $directoryHandler = $this->createMock(iDirectoryHandler::class);
    $fileHandler = $this->createMock(iFileHandler::class);

    $this->sut = new RecursiveIterator($directoryHandler, $fileHandler);

    vfsStream::setup('/');
  }

  public function testCopy() : void {
    vfsStream::create([
        'template' => [
            'file1' => '',
            'folder1' => [
                '__varFolder__' => [
                    'fileInVarFolder' => '',
                ],
                'fileInFolder1' => '',
            ],
        ],
    ]);

    $variables = ['some', 'vars'];

    $directoryHandler = $this->createMock(iDirectoryHandler::class);
    $directoryHandler
        ->expects(self::exactly(2))
        ->method('handle')
        ->withConsecutive(
            [vfsStream::url('/target/folder1'), $variables],
            [vfsStream::url('/target/folder1/__varFolder__'), $variables]
        );
    $this->sut->directoryHandler = $directoryHandler;

    $fileHandler = $this->createMock(iFileHandler::class);
    $fileHandler
        ->expects(self::exactly(3))
        ->method('handle')
        ->withConsecutive(
            [vfsStream::url('/template/file1'), vfsStream::url('/target/file1')],
            [vfsStream::url('/template/folder1/__varFolder__/fileInVarFolder'), vfsStream::url('/target/folder1/__varFolder__/fileInVarFolder')],
            [vfsStream::url('/template/folder1/fileInFolder1'), vfsStream::url('/target/folder1/fileInFolder1')],
        );
    $this->sut->fileHandler = $fileHandler;

    $this->sut->copy(vfsStream::url('/template/'), vfsStream::url('/target'), $variables);
  }
}
