<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260826173000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute les textes multilingues des solutions et actualites';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE solution ADD nom_fr VARCHAR(150) DEFAULT NULL, ADD nom_en VARCHAR(150) DEFAULT NULL, ADD nom_de VARCHAR(150) DEFAULT NULL, ADD description_fr VARCHAR(255) DEFAULT NULL, ADD description_en VARCHAR(255) DEFAULT NULL, ADD description_de VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE actualite ADD titre_fr VARCHAR(150) DEFAULT NULL, ADD titre_en VARCHAR(150) DEFAULT NULL, ADD titre_de VARCHAR(150) DEFAULT NULL, ADD contenu_fr LONGTEXT DEFAULT NULL, ADD contenu_en LONGTEXT DEFAULT NULL, ADD contenu_de LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE solution DROP nom_fr, DROP nom_en, DROP nom_de, DROP description_fr, DROP description_en, DROP description_de');
        $this->addSql('ALTER TABLE actualite DROP titre_fr, DROP titre_en, DROP titre_de, DROP contenu_fr, DROP contenu_en, DROP contenu_de');
    }
}
