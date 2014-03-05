<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Tester;

use Behat\Testwork\Tester\SpecificationTester;

/**
 * Behat feature tester interface.
 *
 * This interface defines an API for Tree Feature testers.
 * Behat feature tester is simply a specification tester in Testwork terms.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
interface FeatureTester extends SpecificationTester
{
}
