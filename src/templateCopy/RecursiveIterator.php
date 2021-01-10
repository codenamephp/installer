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

namespace de\codenamephp\installer\templateCopy;

use de\codenamephp\installer\templateCopy\directoryHandler\iDirectoryHandler;
use de\codenamephp\installer\templateCopy\fileHandler\iFileHandler;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use UnexpectedValueException;

final class RecursiveIterator implements iTemplateCopy {

  public function __construct(public iDirectoryHandler $directoryHandler, public iFileHandler $fileHandler) { }

  /**
   * @inheritDoc
   * @throws UnexpectedValueException
   */
  public function copy(string $source, string $target, array $variables) : void {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);

    /** @var SplFileInfo $file */
    foreach($iterator as $file) {
      $targetPath = $this->replaceSourceFolderWithTargetFolder($source, $target, $file);
      $isDir = $file->isDir();
      $isDir ? $this->directoryHandler->handle($targetPath, $variables) : $this->fileHandler->handle($file->getPathname(), $targetPath, $variables);
    }
  }

  private function replaceSourceFolderWithTargetFolder(string $source, string $target, SplFileInfo $file) : string {
    $trimPath = static fn(string $path) : string => rtrim($path, DIRECTORY_SEPARATOR . ' ');
    return str_replace($trimPath($source), $trimPath($target), $trimPath($file->getPathname()));
  }
}