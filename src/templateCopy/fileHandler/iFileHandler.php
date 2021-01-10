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

namespace de\codenamephp\installer\templateCopy\fileHandler;

/**
 * Interface to handles files while they are copied from a source to a target
 */
interface iFileHandler {

  /**
   * Handles the file copy. Implementations MUST make sure to replace all placeholders in the file and in the file paths
   *
   * @param string $source The source path of the template being copied
   * @param string $target The target path to where the template should be rendered to
   * @param array $variables The variables that should be used to replace placeholders in the paths and the file
   */
  public function handle(string $source, string $target, array $variables) : void;
}