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

namespace de\codenamephp\installer\steps;

use de\codenamephp\installer\templateCopy\variableReplacer\iVariableReplacer;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Deletes files and folders using symfony filesystem
 */
final class DeleteFilesAndFolders implements iStep {

  /**
   * @param iVariableReplacer $variableReplacer Used to replace variables in the paths of the files and folders
   * @param Filesystem $filesystem Used to delete the files and folders
   * @param array<string> $filesAndFoldersToDelete The absolute paths of the files and folders to be deleted
   * @param array<string, string> $variables Used in variable replacement in the folder paths of the files and folders
   */
  public function __construct(public iVariableReplacer $variableReplacer, public Filesystem $filesystem, public array $filesAndFoldersToDelete, public array $variables) { }

  /**
   *
   * @inheritDoc
   * @throws IOException
   */
  public function run() : void {
    $this->filesystem->remove(array_map(fn(string $path) => $this->variableReplacer->replace($path, $this->variables), $this->filesAndFoldersToDelete));
  }
}