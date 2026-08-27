<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260826170000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute une image par langue pour les solutions et actualites';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE solution ADD image_fr VARCHAR(255) DEFAULT NULL, ADD image_en VARCHAR(255) DEFAULT NULL, ADD image_de VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE actualite ADD image_fr VARCHAR(255) DEFAULT NULL, ADD image_en VARCHAR(255) DEFAULT NULL, ADD image_de VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE solution DROP image_fr, DROP image_en, DROP image_de');
        $this->addSql('ALTER TABLE actualite DROP image_fr, DROP image_en, DROP image_de');
    }
}
