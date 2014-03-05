<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Testwork\Tester\Result\Interpretation;

use Behat\Testwork\Tester\Result\TestResult;

/**
 * Testwork strict result interpretation.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class StrictInterpretation implements ResultInterpretation
{
    /**
     * Checks if provided test result should be considered as a failure.
     *
     * @param TestResult $result
     *
     * @return Boolean
     */
    public function isFailure(TestResult $result)
    {
        return intval(TestResult::PASSED < $result->getResultCode());
    }
}
