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

/**
 * Interface to copy files and/or folders while replacing varibles e.g. by using a template engines
 *
 * Implementations MUST support variables in files and paths
 */
interface iTemplateCopy {

  /**
   * Copies the source to the target while replacing any placeholders in the file (if it is a file) or in the path
   *
   * @param string $source The absolute path to the source file or folder
   * @param string $target The absolute path to the target file or folder
   * @param string[] $variables An array of variables that will be used for replacing placeholders
   */
  public function copy(string $source, string $target, array $variables) : void;
}