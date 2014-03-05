<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Tester\Cli;

use Behat\Behat\EventDispatcher\Event\ExampleTested;
use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Behat\Behat\Tester\Result\BehatTestResult;
use Behat\Testwork\Cli\Controller;
use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Behat stop on failure controller.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class StopOnFailureController implements Controller
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Initializes controller.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Configures command to be executable by the controller.
     *
     * @param Command $command
     */
    public function configure(Command $command)
    {
        $command->addOption('--stop-on-failure', null, InputOption::VALUE_NONE,
            'Stop processing on first failed scenario.'
        );
    }

    /**
     * Executes controller.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return null|integer
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getOption('stop-on-failure')) {
            return null;
        }

        $this->eventDispatcher->addListener(ScenarioTested::AFTER, array($this, 'exitOnFailure'), -100);
        $this->eventDispatcher->addListener(ExampleTested::AFTER, array($this, 'exitOnFailure'), -100);
    }

    /**
     * Exits if scenario is a failure and if stopper is enabled.
     *
     * @param \Behat\Behat\EventDispatcher\Event\ScenarioTested $event
     */
    public function exitOnFailure(ScenarioTested $event)
    {
        if (BehatTestResult::FAILED !== $event->getResultCode()) {
            return;
        }

        $this->eventDispatcher->dispatch(ExerciseCompleted::AFTER, new ExerciseCompleted(null, false));

        exit(1);
    }
}
