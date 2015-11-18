<?php
namespace APP\MaldabaBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ClientImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('client:import')
        ->setDescription('Import Clients ')
        ->addArgument(
            'dir',
            InputArgument::REQUIRED,
            'DIR'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $disable_sql = 'ALTER TABLE clients DISABLE KEYS';
        $stmt = $em->getConnection()->prepare($disable_sql);
        $stmt->execute();

        $Loadsql = "LOAD DATA INFILE '".$dir."' INTO TABLE clients COLUMNS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES (title,first_name,surname,date_of_birth,email,mobile_phone,status)";
        $stmt = $em->getConnection()->prepare($Loadsql);
        $stmt->execute();

        $enable_sql = 'ALTER TABLE clients ENABLE KEYS';
        $stmt = $em->getConnection()->prepare($enable_sql);
        $stmt->execute();
    }
}