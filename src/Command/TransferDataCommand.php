<?php

namespace App\Command;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:transfer-data',
    description: 'Transfère les données de MySQL vers SQLite'
)]
class TransferDataCommand extends Command
{
    public function __construct(
        private ManagerRegistry $doctrine
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        // SQLite = connexion par défaut
        $sqlite = $this->doctrine->getConnection('default');

        // MySQL = connexion temporaire
        $mysql = $this->doctrine->getConnection('mysql_source');

        $output->writeln('<info>Début du transfert MySQL → SQLite...</info>');
        $output->writeln('');

        // Vérification de MySQL
        $countActualite = $mysql
            ->fetchOne('SELECT COUNT(*) FROM actualite');

        $countSolution = $mysql
            ->fetchOne('SELECT COUNT(*) FROM solution');

        $countAdmin = $mysql
            ->fetchOne('SELECT COUNT(*) FROM admin');

        $output->writeln("MySQL actualite : <info>{$countActualite}</info>");
        $output->writeln("MySQL solution  : <info>{$countSolution}</info>");
        $output->writeln("MySQL admin     : <info>{$countAdmin}</info>");
        $output->writeln('');

        // Transfert
        $this->transferTable(
            $mysql,
            $sqlite,
            'actualite',
            $output
        );

        $this->transferTable(
            $mysql,
            $sqlite,
            'solution',
            $output
        );

        $this->transferTable(
            $mysql,
            $sqlite,
            'admin',
            $output
        );

        $output->writeln('');
        $output->writeln('<info>✅ Transfert terminé !</info>');

        return Command::SUCCESS;
    }

    private function transferTable(
        $mysql,
        $sqlite,
        string $table,
        OutputInterface $output
    ): void {
        $rows = $mysql
            ->fetchAllAssociative("SELECT * FROM {$table}");

        if (empty($rows)) {
            $output->writeln(
                "{$table} : <comment>0 ligne</comment>"
            );

            return;
        }

        foreach ($rows as $row) {
            $sqlite->insert($table, $row);
        }

        $output->writeln(
            sprintf(
                '%s : <info>%d ligne(s) transférée(s)</info>',
                $table,
                count($rows)
            )
        );
    }
}