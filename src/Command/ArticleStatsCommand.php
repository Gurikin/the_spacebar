<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'article:stats';

    protected function configure()
    {
        $this
            ->setDescription('Return some article stats!')
            ->addArgument('slug', InputArgument::REQUIRED, 'The article\'s slug')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text')
        ;
    }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|void|null
   * @throws \Exception
   */
  protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
          'slug' => $slug,
          'heart' => rand(10, 100)
        ];

        switch ($input->getOption('format')) {
          case 'text':
            $rows = [];
            foreach ($data as $key => $value) {
              $rows[] = [$key, $value];
            }
//            $io->listing($data);
          $io->table(['Key', 'Value'], $rows);
            break;
          case 'json':
            $io->write(json_encode($data)."\n");
            break;
          default:
            throw new \Exception('What kind of crazy format is that!?');
        }

//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
